<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChecksheetRecordResource;
use App\Http\Resources\ChecksheetTypeResource;
use App\Models\ChecksheetRecord;
use App\Models\ChecksheetType;
use App\Models\ChecksheetDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ChecksheetApiController extends Controller
{
    /**
     * Get all checksheet types with items
     */
    public function getTypes()
    {
        try {
            $types = ChecksheetType::active()
                                   ->with('activeItems')
                                   ->get();

            return response()->json([
                'success' => true,
                'data' => ChecksheetTypeResource::collection($types)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve checksheet types',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get checksheet type by code (daily, 6m, 12m)
     */
    public function getTypeByCode($code)
    {
        try {
            $type = ChecksheetType::with('activeItems')
                                  ->byCode($code)
                                  ->active()
                                  ->firstOrFail();

            return response()->json([
                'success' => true,
                'data' => new ChecksheetTypeResource($type)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Checksheet type not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Display a listing of checksheet records
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 15);
            $machineId = $request->input('machine_id');
            $typeId = $request->input('type_id');
            $status = $request->input('status');
            $year = $request->input('year', date('Y'));
            $month = $request->input('month');
            $userId = $request->input('user_id');

            $query = ChecksheetRecord::with(['machine', 'checksheetType', 'user', 'leader']);

            // Filters
            if ($machineId) {
                $query->byMachine($machineId);
            }

            if ($typeId) {
                $query->byType($typeId);
            }

            if ($status) {
                $query->byStatus($status);
            }

            if ($year) {
                $query->byPeriod($year, $month);
            }

            if ($userId) {
                $query->byUser($userId);
            }

            $records = $query->orderBy('check_date', 'desc')
                           ->orderBy('created_at', 'desc')
                           ->paginate($perPage);

            return ChecksheetRecordResource::collection($records);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve checksheet records',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified checksheet record
     */
    public function show($id)
    {
        try {
            $record = ChecksheetRecord::with([
                'machine',
                'checksheetType.items',
                'user',
                'leader',
                'foreman',
                'supervisor',
                'details.item'
            ])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => new ChecksheetRecordResource($record)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Checksheet record not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Store a new checksheet record
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'machine_id' => 'required|exists:machines,id',
            'checksheet_type_id' => 'required|exists:checksheet_types,id',
            'check_date' => 'required|date',
            'check_day' => 'nullable|integer|min:1|max:31',
            'check_month' => 'required|integer|min:1|max:12',
            'check_year' => 'required|integer|min:2020',
            'work_hours' => 'nullable|numeric|min:0',
            'technician_notes' => 'nullable|string',
            'details' => 'required|array',
            'details.*.checksheet_item_id' => 'required|exists:checksheet_items,id',
            'details.*.check_status' => 'nullable|in:ok,attention,abnormal',
            'details.*.check_value' => 'nullable|string|max:255',
            'details.*.remarks' => 'nullable|string',
            'details.*.image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // 5MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Create checksheet record
            $record = ChecksheetRecord::create([
                'machine_id' => $request->machine_id,
                'checksheet_type_id' => $request->checksheet_type_id,
                'user_id' => auth()->id(),
                'check_date' => $request->check_date,
                'check_day' => $request->check_day,
                'check_month' => $request->check_month,
                'check_year' => $request->check_year,
                'work_hours' => $request->work_hours,
                'technician_notes' => $request->technician_notes,
                'status' => 'draft',
            ]);

            // Create checksheet details
            foreach ($request->details as $index => $detail) {
                $detailData = [
                    'checksheet_record_id' => $record->id,
                    'checksheet_item_id' => $detail['checksheet_item_id'],
                    'check_status' => $detail['check_status'] ?? null,
                    'check_value' => $detail['check_value'] ?? null,
                    'remarks' => $detail['remarks'] ?? null,
                ];

                // Handle image upload
                if (isset($detail['image'])) {
                    $image = $request->file("details.{$index}.image");
                    $path = $image->store('checksheet/images', 'public');
                    $detailData['image_path'] = $path;
                }

                ChecksheetDetail::create($detailData);
            }

            DB::commit();

            $record->load(['machine', 'checksheetType', 'details.item']);

            return response()->json([
                'success' => true,
                'message' => 'Checksheet record created successfully',
                'data' => new ChecksheetRecordResource($record)
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create checksheet record',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified checksheet record
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'check_date' => 'nullable|date',
            'work_hours' => 'nullable|numeric|min:0',
            'technician_notes' => 'nullable|string',
            'details' => 'nullable|array',
            'details.*.id' => 'nullable|exists:checksheet_details,id',
            'details.*.checksheet_item_id' => 'required|exists:checksheet_items,id',
            'details.*.check_status' => 'nullable|in:ok,attention,abnormal',
            'details.*.check_value' => 'nullable|string|max:255',
            'details.*.remarks' => 'nullable|string',
            'details.*.image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $record = ChecksheetRecord::findOrFail($id);

            // Check if user has permission to update
            if ($record->user_id !== auth()->id() && !auth()->user()->hasRole(['Admin', 'EHS'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to update this checksheet'
                ], 403);
            }

            // Only allow update if status is draft
            if ($record->status !== 'draft') {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot update checksheet that is not in draft status'
                ], 400);
            }

            // Update record
            $record->update($request->only(['check_date', 'work_hours', 'technician_notes']));

            // Update details if provided
            if ($request->has('details')) {
                foreach ($request->details as $index => $detail) {
                    $detailData = [
                        'checksheet_item_id' => $detail['checksheet_item_id'],
                        'check_status' => $detail['check_status'] ?? null,
                        'check_value' => $detail['check_value'] ?? null,
                        'remarks' => $detail['remarks'] ?? null,
                    ];

                    // Handle image upload
                    if (isset($detail['image'])) {
                        $image = $request->file("details.{$index}.image");
                        $path = $image->store('checksheet/images', 'public');
                        $detailData['image_path'] = $path;
                    }

                    if (isset($detail['id'])) {
                        // Update existing detail
                        $existingDetail = ChecksheetDetail::findOrFail($detail['id']);
                        
                        // Delete old image if new image uploaded
                        if (isset($detailData['image_path']) && $existingDetail->image_path) {
                            Storage::disk('public')->delete($existingDetail->image_path);
                        }
                        
                        $existingDetail->update($detailData);
                    } else {
                        // Create new detail
                        $detailData['checksheet_record_id'] = $record->id;
                        ChecksheetDetail::create($detailData);
                    }
                }
            }

            DB::commit();

            $record->load(['machine', 'checksheetType', 'details.item']);

            return response()->json([
                'success' => true,
                'message' => 'Checksheet record updated successfully',
                'data' => new ChecksheetRecordResource($record)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update checksheet record',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Submit checksheet for approval
     */
    public function submit($id)
    {
        DB::beginTransaction();
        try {
            $record = ChecksheetRecord::findOrFail($id);

            // Check permission
            if ($record->user_id !== auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to submit this checksheet'
                ], 403);
            }

            // Check status
            if ($record->status !== 'draft') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only draft checksheet can be submitted'
                ], 400);
            }

            // Update status
            $record->update([
                'status' => 'submitted',
                'submitted_at' => now(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Checksheet submitted successfully',
                'data' => new ChecksheetRecordResource($record)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit checksheet',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Approve checksheet
     */
    public function approve(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required|in:leader,foreman,supervisor',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $record = ChecksheetRecord::findOrFail($id);

            // Update approval based on role
            $roleField = $request->role . '_id';
            $record->update([
                $roleField => auth()->id(),
                'notes' => $request->notes,
            ]);

            // If supervisor approved, change status to approved
            if ($request->role === 'supervisor') {
                $record->update([
                    'status' => 'approved',
                    'approved_at' => now(),
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Checksheet approved successfully',
                'data' => new ChecksheetRecordResource($record)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to approve checksheet',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reject checksheet
     */
    public function reject(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'notes' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $record = ChecksheetRecord::findOrFail($id);

            $record->update([
                'status' => 'rejected',
                'notes' => $request->notes,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Checksheet rejected',
                'data' => new ChecksheetRecordResource($record)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to reject checksheet',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete checksheet record
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $record = ChecksheetRecord::findOrFail($id);

            // Check permission
            if ($record->user_id !== auth()->id() && !auth()->user()->hasRole(['Admin', 'EHS'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to delete this checksheet'
                ], 403);
            }

            // Only allow delete if status is draft or rejected
            if (!in_array($record->status, ['draft', 'rejected'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete checksheet that is not in draft or rejected status'
                ], 400);
            }

            // Delete images
            foreach ($record->details as $detail) {
                if ($detail->image_path) {
                    Storage::disk('public')->delete($detail->image_path);
                }
            }

            $record->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Checksheet deleted successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete checksheet',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get checksheet history for a machine
     */
    public function history($machineId, Request $request)
    {
        try {
            $year = $request->input('year', date('Y'));
            $typeId = $request->input('type_id');
            $perPage = $request->input('per_page', 15);

            $query = ChecksheetRecord::with(['checksheetType', 'user', 'leader'])
                                     ->byMachine($machineId)
                                     ->byPeriod($year);

            if ($typeId) {
                $query->byType($typeId);
            }

            $records = $query->orderBy('check_date', 'desc')
                           ->paginate($perPage);

            return ChecksheetRecordResource::collection($records);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve checksheet history',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get my checksheets
     */
    public function myChecksheets(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 15);
            $status = $request->input('status');

            $query = ChecksheetRecord::with(['machine', 'checksheetType'])
                                     ->byUser(auth()->id());

            if ($status) {
                $query->byStatus($status);
            }

            $records = $query->orderBy('check_date', 'desc')
                           ->paginate($perPage);

            return ChecksheetRecordResource::collection($records);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve checksheets',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}