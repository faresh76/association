<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt #{{ $payment->payment_id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; margin: 20px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 20px; }
        .header p { font-size: 12px; margin: 4px 0; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { text-align: left; padding: 8px; }
        th { background-color: #f3f3f3; }
        .amount { font-weight: bold; font-size: 16px; }
        .footer { text-align: center; margin-top: 40px; font-size: 12px; color: #777; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Association Fee Payment Receipt</h1>
        <p>Receipt No: <strong>#{{ $payment->payment_id }}</strong></p>
        <p>Date Issued: {{ \Carbon\Carbon::now()->format('d M Y, h:i A') }}</p>
    </div>

    <h3>Member Information</h3>
    <table border="1">
        <tr>
            <th>Name</th>
            <td>{{ $payment->member->full_name }}</td>
        </tr>
        <tr>
            <th>Member ID</th>
            <td>{{ $payment->member->member_id }}</td>
        </tr>
    </table>

    <h3 style="margin-top:20px;">Payment Details</h3>
    <table border="1">
        <tr>
            <th>Amount Paid</th>
            <td class="amount">RM {{ number_format($payment->amount, 2) }}</td>
        </tr>
        <tr>
            <th>Payment Date</th>
            <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y, h:i A') }}</td>
        </tr>
        <tr>
            <th>Payment Method</th>
            <td>{{ $payment->payment_method ?? '-' }}</td>
        </tr>
        <tr>
            <th>Reference No</th>
            <td>{{ $payment->reference_no ?? '-' }}</td>
        </tr>
        @if($payment->remarks)
        <tr>
            <th>Remarks</th>
            <td>{{ $payment->remarks }}</td>
        </tr>
        @endif
    </table>

    <div class="footer">
        <p>Thank you for your payment! This is a computer-generated receipt.</p>
        <p>&copy; {{ date('Y') }} Your Association Name</p>
    </div>

</body>
</html>
