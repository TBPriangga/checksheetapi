<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MachineResource;
use App\Models\Machine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MachineApiController extends Controller
{
    /**
     * Display a listing of machines
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 15);
            $search = $request->input('search');
            $status = $request->input('status');
            $location = $request->input('location');
            $department = $request->input('department');

            $query = Machine::query();

            // Filter pencarian
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('machine_name', 'like', "%{$search}%")
                      ->orWhere('machine_number', 'like', "%{$search}%")
                      ->orWhere('registration_number', 'like', "%{$search}%");
                });
            }

            // Filter status
            if ($status) {
                $query->where('status', $status);
            }

            // Filter location
            if ($location) {
                $query->byLocation($location);
            }

            // Filter department
            if ($department) {
                $query->byDepartment($department);
            }

            $machines = $query->with('latestChecksheet')
                              ->orderBy('machine_number')
                              ->paginate($perPage);

            return MachineResource::collection($machines);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve machines',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified machine
     */
    public function show($id)
    {
        try {
            $machine = Machine::with(['latestChecksheet', 'checksheetRecords' => function($q) {
                $q->orderBy('check_date', 'desc')->limit(10);
            }])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => new MachineResource($machine)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Machine not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Store a newly created machine
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'machine_number' => 'required|string|unique:machines,machine_number|max:100',
            'machine_name' => 'required|string|max:255',
            'registration_number' => 'nullable|string|max:100',
            'department' => 'nullable|string|max:100',
            'production_engineering' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:100',
            'type' => 'nullable|string|max:100',
            'room' => 'nullable|string|max:100',
            'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'status' => 'nullable|in:active,inactive,maintenance',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $machine = Machine::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Machine created successfully',
                'data' => new MachineResource($machine)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create machine',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified machine
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'machine_number' => 'required|string|max:100|unique:machines,machine_number,' . $id,
            'machine_name' => 'required|string|max:255',
            'registration_number' => 'nullable|string|max:100',
            'department' => 'nullable|string|max:100',
            'production_engineering' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:100',
            'type' => 'nullable|string|max:100',
            'room' => 'nullable|string|max:100',
            'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'status' => 'nullable|in:active,inactive,maintenance',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $machine = Machine::findOrFail($id);
            $machine->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Machine updated successfully',
                'data' => new MachineResource($machine)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update machine',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified machine
     */
    public function destroy($id)
    {
        try {
            $machine = Machine::findOrFail($id);
            $machine->delete();

            return response()->json([
                'success' => true,
                'message' => 'Machine deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete machine',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get machines by location
     */
    public function byLocation($location)
    {
        try {
            $machines = Machine::byLocation($location)
                              ->active()
                              ->orderBy('machine_number')
                              ->get();

            return response()->json([
                'success' => true,
                'data' => MachineResource::collection($machines)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve machines',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}