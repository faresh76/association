<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\MembersExport;
use Maatwebsite\Excel\Facades\Excel;


class MemberController extends Controller
{

public function index(Request $request)
{
    $query = Member::query()
        ->leftJoin('member_membership as mm', function ($join) {
            $join->on('members.member_id', '=', 'mm.member_id')
                 ->where('mm.is_active', 1);
        })
        ->leftJoin('membership_types as mt', 'mm.type_id', '=', 'mt.type_id')
        ->select('members.*', 'mt.type_name as membership_type_name');

    // Apply search filter if provided
    if ($search = $request->input('search')) {
        $query->where(function ($q) use ($search) {
        $q->where('member_no', 'like', "%{$search}%")
          ->orWhere('full_name', 'like', "%{$search}%")
          ->orWhere('ic_no', 'like', "%{$search}%")
          ->orWhere('status', 'like', "%{$search}%")
          ->orWhere('mt.type_name', 'like', "%{$search}%"); // membership search
        });
    }

    // Sorting
    $sortableColumns = ['member_no', 'full_name', 'status', 'membership_type_name'];
    $sort = in_array($request->input('sort'), $sortableColumns) ? $request->input('sort') : 'member_no';
    $direction = $request->input('direction') === 'desc' ? 'desc' : 'asc';

    $members = $query->orderBy($sort, $direction)
                     ->paginate(10)
                     ->withQueryString(); // keeps search term on pagination

    return view('members.index', compact('members'));
}



    public function create()
    {
        return view('members.create');
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'full_name' => 'required|string|max:100',
        'ic_no' => 'required|string|max:20|unique:members',
        'gender' => 'nullable|string',
        'date_of_birth' => 'nullable|date',
        'phone' => 'nullable|string|max:20',
        'email' => 'nullable|email',
        'address' => 'nullable|string',
        'occupation' => 'nullable|string',
        'join_date' => 'nullable|date',
        'status' => 'nullable|string',
    ]);

// ✅ Generate new member number starting from 1001
$lastMember = Member::orderBy('member_id', 'desc')->first();

// Get last 4 digits as integer
if ($lastMember) {
    $lastNumber = intval(substr($lastMember->member_no, 2)); // remove 'HM'
    $lastNumber = max($lastNumber, 1000); // ensure starting from 1001
} else {
    $lastNumber = 1000; // first member
}

$newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
$validated['member_no'] = 'HM' . $newNumber;


    // ✅ Save new member
    Member::create($validated);

    return redirect()->route('members.index')->with('success', 'Member created successfully.');
}


    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'member_no'     => 'required|max:20|unique:members,member_no,' . $member->member_id . ',member_id',
            'full_name'     => 'required|max:100',
            'ic_no'         => 'required|max:20|unique:members,ic_no,' . $member->member_id . ',member_id',
            'gender'        => 'nullable|in:Male,Female',
            'date_of_birth' => 'nullable|date',
            'phone'         => 'nullable|max:20',
            'email'         => 'nullable|email|max:100',
            'address'       => 'nullable|string',
            'occupation'    => 'nullable|max:100',
            'join_date'     => 'nullable|date',
            'status'        => 'required|in:Active,Inactive,Suspended,Deceased',
        ]);

        $member->update($validated);

        return redirect()->route('members.index')->with('success', 'Member updated successfully!');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('members.index')->with('success', 'Member deleted successfully!');
    }

public function show(Member $member)
{
    // Get the active membership for this member
    $membership = $member->memberships()
        ->join('membership_types', 'member_membership.type_id', '=', 'membership_types.type_id')
        ->select('membership_types.type_name')
        ->where('member_membership.is_active', 1)
        ->first();

    return view('members.show', compact('member', 'membership'));
}



public function pdf(Request $request)
{
    $query = Member::query()
        ->leftJoin('member_membership as mm', function ($join) {
            $join->on('members.member_id', '=', 'mm.member_id')
                 ->where('mm.is_active', 1);
        })
        ->leftJoin('membership_types as mt', 'mm.type_id', '=', 'mt.type_id')
        ->select('members.*', 'mt.type_name as membership_type_name');

    // Apply search filter
    if ($search = $request->input('search')) {
        $query->where(function ($q) use ($search) {
        $q->where('member_no', 'like', "%{$search}%")
          ->orWhere('full_name', 'like', "%{$search}%")
          ->orWhere('ic_no', 'like', "%{$search}%")
          ->orWhere('status', 'like', "%{$search}%")
          ->orWhere('mt.type_name', 'like', "%{$search}%"); // membership search
        });
    }

    // Sorting
    $sortableColumns = ['member_no', 'full_name', 'status', 'membership_type_name'];
    $sort = in_array($request->input('sort'), $sortableColumns) ? $request->input('sort') : 'member_no';
    $direction = $request->input('direction') === 'desc' ? 'desc' : 'asc';

    $members = $query->orderBy($sort, $direction)->get();

    $pdf = Pdf::loadView('members.pdf', compact('members', 'sort', 'direction'))
              ->setPaper('a4', 'portrait');

    return $pdf->stream('members.pdf');
}

public function exportMembers()
{
    return Excel::download(new MembersExport, 'members_by_membership.xlsx');
}

}
