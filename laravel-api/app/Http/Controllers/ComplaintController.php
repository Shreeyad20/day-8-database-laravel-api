<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index()
    {
        return response()->json(
            Complaint::with('facility')->get()
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'facility_id' => 'required|exists:facilities,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'nullable|string|max:255',
        ]);

        $complaint = Complaint::create($validated);

        return response()->json($complaint, 201);
    }

    public function show(string $id)
    {
        $complaint = Complaint::with('facility')->findOrFail($id);

        return response()->json($complaint);
    }

    public function update(Request $request, string $id)
    {
        $complaint = Complaint::findOrFail($id);

        $validated = $request->validate([
            'facility_id' => 'sometimes|required|exists:facilities,id',
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'status' => 'sometimes|string|max:255',
        ]);

        $complaint->update($validated);

        return response()->json($complaint);
    }

    public function destroy(string $id)
    {
        $complaint = Complaint::findOrFail($id);
        $complaint->delete();

        return response()->json([
            'message' => 'Complaint deleted successfully'
        ]);
    }
}