<?php

namespace App\Http\Controllers;

use App\Models\RelationshipType;
use Illuminate\Http\Request;

class RelationshipTypeController extends Controller
{
    public function index()
    {
        $relationshipTypes = RelationshipType::orderBy('name')->get();
        return view('relationship-types.index', compact('relationshipTypes'));
    }

  public function create()
{
    $relationshipType = new \App\Models\RelationshipType(); // empty model
    return view('relationship-types.create', compact('relationshipType'));
}


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:relationship_types,name',
            'description' => 'nullable|string|max:255',
        ]);

        RelationshipType::create($validated);

        return redirect()->route('relationship-types.index')
            ->with('success', 'Relationship type added successfully.');
    }

    public function edit(RelationshipType $relationshipType)
    {
        return view('relationship-types.edit', compact('relationshipType'));
    }

    public function update(Request $request, RelationshipType $relationshipType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:relationship_types,name,' . $relationshipType->id,
             'description' => 'nullable|string|max:255',
        ]);

        $relationshipType->update($validated);

        return redirect()->route('relationship-types.index')
            ->with('success', 'Relationship type updated successfully.');
    }

    public function destroy(RelationshipType $relationshipType)
    {
        $relationshipType->delete();
        return redirect()->route('relationship-types.index')
            ->with('success', 'Relationship type deleted successfully.');
    }
}
