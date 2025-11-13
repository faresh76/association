<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FamilyMember; // <- Add this line
use App\Models\Member;       // if you need member relationship
use App\Models\RelationshipType;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\FamilyMemberExport;
use Maatwebsite\Excel\Facades\Excel;

class FamilyMemberController extends Controller
{
public function index(Request $request)
{
    $query = Member::with('familyMembers.relationshipType');

    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where('full_name', 'like', "%{$search}%")
              ->orWhereHas('familyMembers', function ($q) use ($search) {
                  $q->where('full_name', 'like', "%{$search}%");
              });
    }

       $members = $query
                     ->orderBy('member_no', 'asc')
                     ->paginate(10)
                     ->withQueryString(); // keeps search term on pagination

        // Check if member_id is passed (e.g., from a "Add Family" button)
    $member_id = $request->query('member_id', null); // default null if not passed

    return view('family-members.index', compact('members', 'member_id'));
}



public function create(Request $request, $member_id = null)
{
    $members = Member::orderBy('full_name')->get();
    $relationshipTypes = RelationshipType::orderBy('name')->get();
    $member_id = $request->query('member_id'); 

    return view('family-members.create', compact('members', 'member_id', 'relationshipTypes'));
}



    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,member_id',
            'name' => 'required|string|max:100',
            'relationship_type_id' => 'required|exists:relationship_types,id',
            'date_of_birth' => 'nullable|date',
            'contact_no' => 'nullable|string|max:20',
            'email' => 'nullable|string|max:100',
            'ic_no' => 'nullable|string|max:20',
            'occupation' => 'nullable|string|max:100',
            'child_no_of_sibling' => 'nullable|string|max:2',
            'child_diagnose' => 'nullable|string|max:100',
            'child_right_ear_hearing_level' => 'nullable|string|max:100',
            'child_left_ear_hearing_level' => 'nullable|string|max:100',
            'child_right_ear_hearing_tool' => 'nullable|string|max:100',
            'child_left_ear_hearing_tool' => 'nullable|string|max:100',
            'child_right_ear_hearing_tool_brand' => 'nullable|string|max:100',
            'child_left_ear_hearing_tool_brand' => 'nullable|string|max:100',
            'child_right_ear_hearing_tool_from' => 'nullable|string|max:100',
            'child_left_ear_hearing_tool_from' => 'nullable|string|max:100',
            'child_reference_hospital' => 'nullable|string|max:100',
            'child_education_level' => 'nullable|string|max:100',
            'child_school_name' => 'nullable|string|max:100',
            'child_oku_status' => 'nullable|string|max:100',

        ]);

        FamilyMember::create($request->all());

        return redirect()->route('family-members.index')->with('success', 'Family member added.');
    }

public function edit(FamilyMember $familyMember)
{
    $members = Member::orderBy('full_name')->get();
    $relationshipTypes = RelationshipType::orderBy('name')->get();

    // Map camelCase to snake_case for Blade
    $family_member = $familyMember;

    return view('family-members.edit', compact('family_member', 'members', 'relationshipTypes'));
}


public function update(Request $request, FamilyMember $familyMember)
{
    $validated = $request->validate([
            'name' => 'required|string|max:255',
            'relationship_type_id' => 'nullable|exists:relationship_types,id',
            'date_of_birth' => 'nullable|date',
            'contact_no' => 'nullable|string|max:20',
            'email' => 'nullable|string|max:100',
            'ic_no' => 'nullable|string|max:20',
            'occupation' => 'nullable|string|max:100',
            'child_no_of_sibling' => 'nullable|string|max:2',
            'child_diagnose' => 'nullable|string|max:100',
            'child_right_ear_hearing_level' => 'nullable|string|max:100',
            'child_left_ear_hearing_level' => 'nullable|string|max:100',
            'child_right_ear_hearing_tool' => 'nullable|string|max:100',
            'child_left_ear_hearing_tool' => 'nullable|string|max:100',
            'child_right_ear_hearing_tool_brand' => 'nullable|string|max:100',
            'child_left_ear_hearing_tool_brand' => 'nullable|string|max:100',
            'child_right_ear_hearing_tool_from' => 'nullable|string|max:100',
            'child_left_ear_hearing_tool_from' => 'nullable|string|max:100',
            'child_reference_hospital' => 'nullable|string|max:100',
            'child_education_level' => 'nullable|string|max:100',
            'child_school_name' => 'nullable|string|max:100',
            'child_oku_status' => 'nullable|string|max:100',
    ]);

    $familyMember->update($validated);

    return redirect()->route('family-members.index')
        ->with('success', 'Family member updated successfully.');
}



    public function destroy(FamilyMember $familyMember)
    {
        $familyMember->delete();
        return redirect()->route('family-members.index')->with('success', 'Family member deleted.');
    }

        public function show(FamilyMember $family_member)
    {
        // Eager load relationships if needed
        $family_member->load('member', 'relationshipType');

        return view('family-members.show', compact('family_member'));
    }



public function pdf(Request $request)
{
    $query = \App\Models\Member::with(['familyMembers.relationshipType']);

    // Apply search filter if provided
    if ($search = $request->input('search')) {
        $query->where(function ($q) use ($search) {
            $q->where('full_name', 'like', "%{$search}%")
              ->orWhere('member_no', 'like', "%{$search}%")
              ->orWhere('ic_no', 'like', "%{$search}%")
              ->orWhere('status', 'like', "%{$search}%");
        });
    }

    $members = $query->get(); // no sorting, just filtered results

    $pdf = Pdf::loadView('family-members.pdf', compact('members'))
              ->setPaper('a4', 'portrait');

    return $pdf->stream('family-members.pdf');
}


public function print2($id)
{
    // Retrieve family member record using family_id
    $family_member = FamilyMember::with(['member', 'relationshipType'])
        ->where('family_id', $id)
        ->firstOrFail();

    // Load the PDF view located at: resources/views/family-members/pdf2.blade.php
    $pdf = Pdf::loadView('family-members.pdf2', compact('family_member'));

    // Stream the PDF directly to the browser
    return $pdf->stream('family_member_v2_' . $family_member->family_id . '.pdf');
}



public function printExcelAll()
{
    return Excel::download(new FamilyMemberExport(null), 'all_family_members.xlsx');
}


}
