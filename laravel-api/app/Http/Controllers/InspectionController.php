<?php

namespace App\Http\Controllers;

use App\Models\Inspection;
use Illuminate\Http\Request;

class InspectionController extends Controller
{
    public function index()
    {
        return response()->json(
            Inspection::with(['facility', 'employee'])->get()
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'facility_id' => 'required|exists:facilities,id',
            'employee_id' => 'required|exists:employees,id',
            'inspection_date' => 'required|date',
            'status' => 'required|string|max:255',
            'remarks' => 'nullable|string',
        ]);

        $inspection = Inspection::create($validated);

        return response()->json($inspection, 201);
    }

    public function show(string $id)
    {
        $inspection = Inspection::with(['facility', 'employee'])
            ->findOrFail($id);

        return response()->json($inspection);
    }

    public function update(Request $request, string $id)
    {
        $inspection = Inspection::findOrFail($id);

        $validated = $request->validate([
            'facility_id' => 'sometimes|required|exists:facilities,id',
            'employee_id' => 'sometimes|required|exists:employees,id',
            'inspection_date' => 'sometimes|required|date',
            'status' => 'sometimes|required|string|max:255',
            'remarks' => 'nullable|string',
        ]);

        $inspection->update($validated);

        return response()->json($inspection);
    }

    public function destroy(string $id)
    {
        $inspection = Inspection::findOrFail($id);
        $inspection->delete();

        return response()->json([
            'message' => 'Inspection deleted successfully'
        ]);
    }
}
