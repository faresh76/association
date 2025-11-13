<?php

namespace App\Http\Controllers;

use App\Models\CommitteeRole;
use Illuminate\Http\Request;

class CommitteeRoleController extends Controller
{
    public function index()
    {
        $roles = CommitteeRole::orderBy('role_id')->paginate(10);
        return view('committee-roles.index', compact('roles'));
    }

    public function create()
    {
        return view('committee-roles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'role_name' => 'required|string|max:50|unique:committee_roles',
            'description' => 'nullable|string',
        ]);

        CommitteeRole::create($validated);

        return redirect()->route('committee-roles.index')
                         ->with('success', 'Committee role created successfully.');
    }

    public function edit(CommitteeRole $committeeRole)
    {
        return view('committee-roles.edit', compact('committeeRole'));
    }

    public function update(Request $request, CommitteeRole $committeeRole)
    {
        $validated = $request->validate([
            'role_name' => 'required|string|max:50|unique:committee_roles,role_name,' . $committeeRole->role_id . ',role_id',
            'description' => 'nullable|string',
        ]);

        $committeeRole->update($validated);

        return redirect()->route('committee-roles.index')
                         ->with('success', 'Committee role updated successfully.');
    }

    public function destroy(CommitteeRole $committeeRole)
    {
        $committeeRole->delete();
        return redirect()->route('committee-roles.index')
                         ->with('success', 'Committee role deleted successfully.');
    }
}
