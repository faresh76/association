<?php

namespace App\Http\Controllers;

use App\Models\MembershipType;
use Illuminate\Http\Request;

class MembershipTypeController extends Controller
{
    public function index()
    {
        $types = MembershipType::orderBy('annual_fee', 'asc')->paginate(10);
        return view('membership-types.index', compact('types'));
    }

    public function create()
    {
        return view('membership-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type_name'   => 'required|string|max:50|unique:membership_types',
            'description' => 'nullable|string',
            'annual_fee'  => 'nullable|numeric|min:0',
        ]);

        MembershipType::create($validated);

        return redirect()->route('membership-types.index')
                         ->with('success', 'Membership type created successfully.');
    }

    public function edit(MembershipType $membershipType)
    {
        return view('membership-types.edit', compact('membershipType'));
    }

    public function update(Request $request, MembershipType $membershipType)
    {
        $validated = $request->validate([
            'type_name'   => 'required|string|max:50|unique:membership_types,type_name,' . $membershipType->type_id . ',type_id',
            'description' => 'nullable|string',
            'annual_fee'  => 'nullable|numeric|min:0',
        ]);

        $membershipType->update($validated);

        return redirect()->route('membership-types.index')
                         ->with('success', 'Membership type updated successfully.');
    }

    public function destroy(MembershipType $membershipType)
    {
        $membershipType->delete();
        return redirect()->route('membership-types.index')
                         ->with('success', 'Membership type deleted successfully.');
    }
}
