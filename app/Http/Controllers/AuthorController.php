<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $data = Author::where('is_deleted', 0)->get();
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
                'name' => 'required|string|max:100',
                'date_of_birth' => 'nullable|date',
                'nationality' => 'required|string|max:100',
                'phone' => 'nullable|string|max:12',
                'email' => 'required|email|max:50|unique:authors,email',
                'address' => 'nullable|string|max:200',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Please Enter Valid Input Data.', $validator->errors(), 400);
            }

            DB::beginTransaction();

            $data = $validator->validated();
            $data['created_by'] = Auth::id(); // Set created_by to the authenticated user's ID

            $author = Author::create($data);

            DB::commit();

            return $this->sendResponse("Author created successfully", ['author' => $author], 201);
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
            $data['Author'] = Author::with(['book', 'createdByUser'])->where('is_deleted', 0)->findOrFail($id);
            if (empty($data['Author'])) {
                return $this->sendError('Author not found.', ["general" => "Author not found"], 404);
            }
            return $this->sendResponse("Author retrieved successfully", $data, 200);
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
            $author = Author::where('is_deleted', 0)->findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:100',
                'date_of_birth' => 'nullable|date',
                'nationality' => 'required|string|max:100',
                'phone' => 'nullable|string|max:12',
                'email' => 'required|email|max:50|unique:authors,email,' . $author->id,
                'address' => 'nullable|string|max:200',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Please Enter Valid Input Data.', $validator->errors(), 400);
            }

            DB::beginTransaction();

            $data = $validator->validated();
            $data['updated_by'] = Auth::id(); // Set updated_by to the authenticated user's ID

            $author->update($data);

            DB::commit();

            return $this->sendResponse("Author updated successfully", ['author' => $author], 200);
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
            $author = Author::where('is_deleted', 0)->findOrFail($id);

            DB::beginTransaction();

//            $author->update([
//                'is_deleted' => true,
//                'deleted_by' => Auth::id(),
//            ]);
            $author->is_deleted = true;
            $author->deleted_by = Auth::id();
            $author->deleted_at = now();
            $author->save();


            DB::commit();

            return $this->sendResponse("Author marked as deleted successfully", ['author' => $author], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->handleException($e);
        }
    }

}
