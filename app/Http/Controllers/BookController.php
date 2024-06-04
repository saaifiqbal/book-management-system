<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $data = Book::where('is_deleted', 0)->get();
            return $this->sendResponse("List fetched successfully", $data, 200);
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:100',
                'description' => 'nullable|string|max:250',
                'author_id' => 'required|exists:authors,id',
                'publisher_id' => 'required|exists:publishers,id',
                'publish_date' => 'required|date',
                'price' => 'required|numeric|between:0,999999999.99',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Please Enter Valid Input Data.', $validator->errors(), 400);
            }

            DB::beginTransaction();

            $data = $validator->validated();
            $data['created_by'] = Auth::id();

            $Book = Book::create($data);

            DB::commit();

            return $this->sendResponse("Book created successfully", ['Book' => $Book], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->handleException($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $data['Book'] = Book::with(['author','publisher', 'createdByUser'])->where('is_deleted', 0)->findOrFail($id);
            if (empty($data['Book'])) {
                return $this->sendError('Book not found.', ["general" => "Book not found"], 404);
            }
            return $this->sendResponse("Book retrieved successfully", $data, 200);
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $Book = Book::where('is_deleted', 0)->findOrFail($id);

            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:100',
                'description' => 'nullable|string|max:250',
                'author_id' => 'required|exists:authors,id',
                'publisher_id' => 'required|exists:publishers,id',
                'publish_date' => 'required|date',
                'price' => 'required|numeric|between:0,999999999.99',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Please Enter Valid Input Data.', $validator->errors(), 400);
            }

            DB::beginTransaction();

            $data = $validator->validated();
            $data['updated_by'] = Auth::id(); // Set updated_by to the authenticated user's ID

            $Book->update($data);

            DB::commit();

            return $this->sendResponse("Book updated successfully", ['Book' => $Book], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->handleException($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        try {
            $Book = Book::where('is_deleted', 0)->findOrFail($id);

            DB::beginTransaction();

//            $Book->update([
//                'is_deleted' => true,
//                'deleted_by' => Auth::id(),
//            ]);
            $Book->is_deleted = true;
            $Book->deleted_by = Auth::id();
            $Book->deleted_at = now();
            $Book->save();


            DB::commit();

            return $this->sendResponse("Book marked as deleted successfully", ['Book' => $Book], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->handleException($e);
        }
    }
}
