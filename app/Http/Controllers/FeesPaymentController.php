<?php

namespace App\Http\Controllers;

use App\Models\FeesPayment;
use App\Models\Member;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class FeesPaymentController extends Controller
{
public function index(Request $request)
{
    $search = $request->input('search');

    // Fetch payments with member relation
    $payments = \App\Models\FeesPayment::with('member')
        ->orderBy('payment_date', 'desc')
        ->get(); // get all to allow grouping

    // Filter by search if needed
    if ($search) {
        $payments = $payments->filter(function($p) use ($search) {
            return str_contains(strtolower($p->member->full_name ?? ''), strtolower($search));
        });
    }

    // Group by member_id
    $groupedPayments = $payments->groupBy('member_id');

    // Paginate by member (10 members per page)
    $currentPage = LengthAwarePaginator::resolveCurrentPage();
    $perPage = 5;

    $currentPageItems = $groupedPayments->slice(($currentPage - 1) * $perPage, $perPage);
    $paginatedGroupedPayments = new \Illuminate\Pagination\LengthAwarePaginator(
        $currentPageItems,
        $groupedPayments->count(),
        $perPage,
        $currentPage,
        ['path' => $request->url(), 'query' => $request->query()]
    );

    return view('fees_payments.index', [
        'groupedPayments' => $paginatedGroupedPayments,
        'search' => $search,
    ]);
}



    public function create()
    {
        $members = Member::orderBy('full_name')->get();
        return view('fees_payments.create', compact('members'));
    }

 public function store(Request $request)
{
    $request->validate([
        'member_id' => 'required|exists:members,member_id',
        'amount' => 'required|numeric|min:0',
        'payment_date' => 'required|date',
        'payment_method' => 'required|in:Cash,Online,Bank Transfer',
        'remarks' => 'nullable|string',
    ]);

    // Get the member (to access member_no)
    $member = Member::findOrFail($request->member_id);

    // Get the last payment for this member
    $lastPayment = FeesPayment::where('member_id', $member->member_id)
                    ->latest('payment_id')
                    ->first();

    // Determine the next 4-digit sequence
    $nextNumber = $lastPayment
        ? ((int)substr($lastPayment->reference_no, -4) + 1)
        : 1;

    // Pad to 4 digits (0001, 0002, etc.)
    $nextNumberPadded = str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

    // Generate Reference No: member_no + 4-digit sequence
    $reference_no = $member->member_no . $nextNumberPadded;

    // Save payment
    $payment = FeesPayment::create([
        'member_id' => $request->member_id,
        'amount' => $request->amount,
        'payment_date' => $request->payment_date,
        'payment_method' => $request->payment_method,
        'reference_no' => $reference_no,
        'remarks' => $request->remarks,
    ]);

    return redirect()->route('fees_payments.index')
        ->with('success', 'Payment saved successfully! Reference No: ' . $reference_no);
}



    public function edit(FeesPayment $fees_payment)
    {
        $members = Member::orderBy('full_name')->get();
        return view('fees_payments.edit', [
            'payment' => $fees_payment,
            'members' => $members,
        ]);
    }

    public function update(Request $request, FeesPayment $fees_payment)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,member_id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:Cash,Online,Bank Transfer',
            'reference_no' => 'nullable|string|max:50',
            'remarks' => 'nullable|string',
        ]);

        $fees_payment->update($validated);

        return redirect()->route('fees_payments.index')->with('success', 'Payment updated successfully.');
    }

    public function destroy(FeesPayment $fees_payment)
    {
        $fees_payment->delete();
        return redirect()->route('fees_payments.index')->with('success', 'Payment deleted.');
    }

    
public function show(FeesPayment $fees_payment)
{
    $fees_payment->load('member');

    $payment = $fees_payment; // assign to $payment

    return view('fees_payments.show', compact('payment'));
}

 // Existing: print single receipt
    public function print($id)
    {
        $payment = FeesPayment::with('member')->findOrFail($id);

        $pdf = Pdf::loadView('fees_payments.receipt', [
            'payment' => $payment,
        ]);

        $fileName = 'Receipt_' . $payment->payment_id . '.pdf';
        return $pdf->stream($fileName);
    }

    // New: print all filtered/grouped payments
    public function printAll(Request $request)
    {
        $search = $request->input('search');

        $paymentsQuery = FeesPayment::with('member')
            ->orderBy('payment_date', 'desc');

        if ($search) {
            $paymentsQuery->whereHas('member', function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%");
            });
        }

        $allPayments = $paymentsQuery->get();

        $grouped = $allPayments->groupBy('member_id');

        $pdf = Pdf::loadView('fees_payments.print', [
            'groupedPayments' => $grouped,
        ]);

        return $pdf->stream('Fee_Payments_Report.pdf');
    }
}
