<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MembershipType;
use App\Models\MemberMembership;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Exports\FamilyMemberExport;
use App\Exports\MemberMembershipExport;
use Maatwebsite\Excel\Facades\Excel;


class MemberMembershipController extends Controller
{
    // List all member memberships
public function index(Request $request)
{
    $search = $request->input('search');
    $sortBy = $request->input('sort_by', 'members.full_name'); // default sort
    $sortDirection = $request->input('sort_direction', 'asc');

    $validSorts = [
        'members.full_name',
        'membership_types.type_name',
        'status'
    ];

    if (!in_array($sortBy, $validSorts)) {
        $sortBy = 'members.full_name';
    }

    $today = now()->toDateString();

    $memberMemberships = \App\Models\MemberMembership::with(['member', 'membershipType'])
        ->where('hide', '<>', 1) // exclude hidden memberships
        ->join('members', 'member_membership.member_id', '=', 'members.member_id')
        ->leftJoin('membership_types', 'member_membership.type_id', '=', 'membership_types.type_id')
        ->select('member_membership.*')
        ->selectRaw("
            CASE
                WHEN member_membership.is_active = 1 
                     AND (member_membership.end_date IS NULL OR member_membership.end_date >= ?) THEN 'Active'
                WHEN member_membership.end_date < ? THEN 'Expired'
                ELSE 'Inactive'
            END AS status
        ", [$today, $today])
        ->when($search, function ($query, $search) use ($today) {
            $query->where(function ($q) use ($search, $today) {
                $q->whereHas('member', fn($q2) => $q2->where('full_name', 'like', "%{$search}%"))
                  ->orWhereHas('membershipType', fn($q2) => $q2->where('type_name', 'like', "%{$search}%"))
                  ->orWhereRaw("
                    CASE
                        WHEN member_membership.is_active = 1 AND (member_membership.end_date IS NULL OR member_membership.end_date >= ?) THEN 'Active'
                        WHEN member_membership.end_date < ? THEN 'Expired'
                        ELSE 'Inactive'
                    END LIKE ?
                  ", [$today, $today, "%{$search}%"]);
            });
        });

    // Sort
    if ($sortBy === 'status') {
        $memberMemberships = $memberMemberships->orderByRaw("
            CASE
                WHEN member_membership.is_active = 1 AND (member_membership.end_date IS NULL OR member_membership.end_date >= ?) THEN 1
                WHEN member_membership.end_date < ? THEN 2
                ELSE 3
            END {$sortDirection}
        ", [$today, $today])
        ->orderBy('members.full_name', 'asc'); // tie-breaker
    } else {
        $memberMemberships = $memberMemberships->orderBy($sortBy, $sortDirection);
    }

    $memberMemberships = $memberMemberships->paginate(10)
        ->appends([
            'search' => $search,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
        ]);

    return view('member_memberships.index', compact('memberMemberships', 'search', 'sortBy', 'sortDirection'));
}


    // Show form to create new membership assignment
public function create()
{
    // 🔹 Get members who do NOT have any membership
    $members = \App\Models\Member::whereDoesntHave('memberMemberships')->orderBy('full_name', 'asc')->get();

    // 🔹 Get membership types
    $membershipTypes = \App\Models\MembershipType::orderBy('type_name', 'asc')->get();

    return view('member_memberships.create', compact('members', 'membershipTypes'));
}


    // Store new membership assignment
    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,member_id',
            'type_id' => 'required|exists:membership_types,type_id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'boolean',
        ]);

        MemberMembership::create($validated);

        return redirect()->route('member_memberships.index')->with('success', 'Membership assigned successfully!');
    }

    // Edit an existing assignment
    public function edit(MemberMembership $memberMembership)
    {
        $members = Member::all();
        $membershipTypes = MembershipType::all();
        return view('member_memberships.edit', compact('memberMembership', 'members', 'membershipTypes'));
    }

    // Update record
    public function update(Request $request, MemberMembership $memberMembership)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,member_id',
            'type_id' => 'required|exists:membership_types,type_id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'boolean',
        ]);

        $memberMembership->update($validated);

        return redirect()->route('member_memberships.index')->with('success', 'Membership updated successfully!');
    }

    // Delete record
    public function destroy(MemberMembership $memberMembership)
    {
        $memberMembership->delete();
        return redirect()->route('member_memberships.index')->with('success', 'Membership deleted successfully!');
    }

    public function print(Request $request)
{
    $search = $request->input('search');
    $sortBy = $request->input('sort_by', 'members.full_name');
    $sortDirection = $request->input('sort_direction', 'asc');

    $today = now()->toDateString();

    $memberMemberships = \App\Models\MemberMembership::with(['member', 'membershipType'])
        ->join('members', 'member_membership.member_id', '=', 'members.member_id')
        ->leftJoin('membership_types', 'member_membership.type_id', '=', 'membership_types.type_id')
        ->select('member_membership.*')
        ->selectRaw("
            CASE
                WHEN member_membership.is_active = 1 
                     AND (member_membership.end_date IS NULL OR member_membership.end_date >= ?) THEN 'Active'
                WHEN member_membership.end_date < ? THEN 'Expired'
                ELSE 'Inactive'
            END AS status
        ", [$today, $today])
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('member', function ($q2) use ($search) {
                    $q2->where('full_name', 'like', "%{$search}%");
                })
                ->orWhereHas('membershipType', function ($q2) use ($search) {
                    $q2->where('type_name', 'like', "%{$search}%");
                })
                ->orWhereRaw("
                    CASE
                        WHEN member_membership.is_active = 1 
                             AND (member_membership.end_date IS NULL OR member_membership.end_date >= CURDATE()) THEN 'Active'
                        WHEN member_membership.end_date < CURDATE() THEN 'Expired'
                        ELSE 'Inactive'
                    END LIKE ?
                ", ["%{$search}%"]);
            });
        })
        ->orderByRaw("
            CASE 
                WHEN ? = 'status' THEN 
                    CASE status
                        WHEN 'Active' THEN 1
                        WHEN 'Expired' THEN 2
                        WHEN 'Inactive' THEN 3
                        ELSE 4
                    END
                ELSE 0
            END {$sortDirection}
        ", [$sortBy])
        ->orderBy($sortBy === 'status' ? 'members.full_name' : $sortBy, $sortDirection)
        ->get();

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('member_memberships.pdf', compact('memberMemberships', 'search', 'sortBy', 'sortDirection'))
        ->setPaper('a4', 'portrait');

    return $pdf->stream('member_memberships.pdf');
}

public function renew(Request $request, $memberId)
{
    $validated = $request->validate([
        'start_date' => 'required|date',
        'type_id' => 'required|exists:membership_types,type_id',
    ]);

    // 🕒 Find the latest membership to calculate renew number
    $latestMembership = MemberMembership::where('member_id', $memberId)
        ->orderByDesc('start_date')
        ->first();

    if (!$latestMembership) {
        $renewNo = null;
    } elseif (is_null($latestMembership->renew_no)) {
        $renewNo = 1;
    } else {
        $renewNo = $latestMembership->renew_no + 1;
    }

    // 🔸 Mark all previous memberships inactive AND hidden
    MemberMembership::where('member_id', $memberId)
        ->update([
            'is_active' => 0,
            'hide' => 1, // 👈 Hide old records
        ]);

    // 🗓 Calculate new membership dates
    $start = \Carbon\Carbon::parse($validated['start_date']);
    $end = $start->copy()->addYear()->subDay();

    // 🆕 Create the new active membership
    MemberMembership::create([
        'member_id'  => $memberId,
        'type_id'    => $validated['type_id'],
        'start_date' => $start,
        'end_date'   => $end,
        'is_active'  => 1,
        'hide'       => 0, // 👈 Visible
        'renew_no'   => $renewNo,
    ]);

    return redirect()->route('member_memberships.index')
        ->with('success', "Membership renewed successfully" . 
            ($renewNo ? " (Renew #{$renewNo})" : "") . 
            " until {$end->format('d/m/Y')}");
}

public function history($memberId)
{
    $histories = MemberMembership::with(['membershipType'])
        ->where('member_id', $memberId)
        ->orderBy('start_date', 'desc')
        ->get();

    return view('member_memberships.history', compact('histories'));
}



    public function exportMemberMemberships($member_id = null)
    {
        return Excel::download(new MemberMembershipExport($member_id), 'member_memberships.xlsx');
    }


}
