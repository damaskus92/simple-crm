<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class EmployeeController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            'auth:api',
        ];
    }

    /**
     * Display a listing of records.
     */
    public function index(Request $request)
    {
        $data = Employee::with(['role'])
            ->where('name', 'like', '%' . $request->search . '%')
            ->orderBy($request->sortBy ?? 'id', $request->order ?? 'asc')
            ->paginate();

        return EmployeeResource::collection($data);
    }

    /**
     * Store a newly created record.
     */
    public function store(StoreEmployeeRequest $request)
    {
        try {
            $data = Employee::create($request->validated());

            return response()->json([
                'message' => 'Record successfully created.',
                'data' => new EmployeeResource($data->load(['role']))
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified record.
     */
    public function show(Employee $employee)
    {
        return response()->json([
            'message' => 'Successfully fetch record.',
            'data' => new EmployeeResource($employee->load(['role']))
        ], 200);
    }

    /**
     * Update the specified record.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        try {
            $employee->update($request->validated());

            return response()->json([
                'message' => 'Record successfully updated.',
                'data' => new EmployeeResource($employee->load(['role']))
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified record.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return response()->json([
            'message' => 'Record successfully deleted.',
        ], 200);
    }
}
