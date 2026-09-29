<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    // Get all facilities
    public function index()
    {
        return response()->json(Facility::all());
    }

    // Create a new facility
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $facility = Facility::create($validated);

        return response()->json($facility, 201);
    }

    // Get one facility
    public function show(string $id)
    {
        $facility = Facility::findOrFail($id);

        return response()->json($facility);
    }

    // Update a facility
    public function update(Request $request, string $id)
    {
        $facility = Facility::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'location' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $facility->update($validated);

        return response()->json($facility);
    }

    // Delete a facility
    public function destroy(string $id)
    {
        $facility = Facility::findOrFail($id);
        $facility->delete();

        return response()->json([
            'message' => 'Facility deleted successfully'
        ]);
    }
}