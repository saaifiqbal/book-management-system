<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PublisherController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $data = Publisher::where('is_deleted', 0)->get();
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
                'phone' => 'nullable|string|max:12',
                'email' => 'nullable|email|max:50',
                'address' => 'nullable|string|max:200',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Please Enter Valid Input Data.', $validator->errors(), 400);
            }

            DB::beginTransaction();

            $data = $validator->validated();
            $data['created_by'] = Auth::id();

            $Publisher = Publisher::create($data);

            DB::commit();

            return $this->sendResponse("Publisher created successfully", ['Publisher' => $Publisher], 201);
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
            $data['Publisher'] = Publisher::with(['book', 'createdByUser'])->where('is_deleted', 0)->findOrFail($id);
            if (empty($data['Publisher'])) {
                return $this->sendError('Publisher not found.', ["general" => "Publisher not found"], 404);
            }
            return $this->sendResponse("Publisher retrieved successfully", $data, 200);
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
            $Publisher = Publisher::where('is_deleted', 0)->findOrFail($id);


            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:100',
                'phone' => 'nullable|string|max:12',
                'email' => 'nullable|email|max:50',
                'address' => 'nullable|string|max:200',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Please Enter Valid Input Data.', $validator->errors(), 400);
            }

            DB::beginTransaction();

            $data = $validator->validated();
            $data['updated_by'] = Auth::id(); // Set updated_by to the authenticated user's ID

            $Publisher->update($data);

            DB::commit();

            return $this->sendResponse("Publisher updated successfully", ['Publisher' => $Publisher], 200);
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
            $Publisher = Publisher::where('is_deleted', 0)->findOrFail($id);

            DB::beginTransaction();

//            $Publisher->update([
//                'is_deleted' => true,
//                'deleted_by' => Auth::id(),
//            ]);
            $Publisher->is_deleted = true;
            $Publisher->deleted_by = Auth::id();
            $Publisher->deleted_at = now();
            $Publisher->save();


            DB::commit();

            return $this->sendResponse("Publisher marked as deleted successfully", ['Publisher' => $Publisher], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->handleException($e);
        }
    }
}
