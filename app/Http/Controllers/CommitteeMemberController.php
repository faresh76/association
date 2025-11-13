<?php

namespace App\Http\Controllers;

use App\Models\CommitteeMember;
use App\Models\Member;
use App\Models\CommitteeRole;
use Illuminate\Http\Request;

class CommitteeMemberController extends Controller
{
    public function index()
    {
        $committeeMembers = CommitteeMember::with(['member', 'role'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('committee-members.index', compact('committeeMembers'));
    }

    public function create()
    {
        $members = Member::orderBy('full_name')->get();
        $roles = CommitteeRole::orderBy('role_name')->get();

        return view('committee-members.create', compact('members', 'roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,member_id',
            'role_id'   => 'required|exists:committee_roles,role_id',
            'term_start'=> 'nullable|date',
            'term_end'  => 'nullable|date|after_or_equal:term_start',
        ]);

        CommitteeMember::create($validated);

        return redirect()->route('committee-members.index')
                         ->with('success', 'Role assigned to member successfully.');
    }

    public function edit(CommitteeMember $committeeMember)
    {
        $members = Member::orderBy('full_name')->get();
        $roles = CommitteeRole::orderBy('role_name')->get();

        return view('committee-members.edit', compact('committeeMember', 'members', 'roles'));
    }

    public function update(Request $request, CommitteeMember $committeeMember)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,member_id',
            'role_id'   => 'required|exists:committee_roles,role_id',
            'term_start'=> 'nullable|date',
            'term_end'  => 'nullable|date|after_or_equal:term_start',
        ]);

        $committeeMember->update($validated);

        return redirect()->route('committee-members.index')
                         ->with('success', 'Assignment updated successfully.');
    }

    public function destroy(CommitteeMember $committeeMember)
    {
        $committeeMember->delete();

        return redirect()->route('committee-members.index')
                         ->with('success', 'Assignment deleted successfully.');
    }
}
