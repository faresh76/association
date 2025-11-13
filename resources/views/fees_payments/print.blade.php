<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Fee Payments Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 15px; }
        th, td { border: 1px solid #333; padding: 4px; text-align: left; }
        th { background-color: #f0f0f0; }
        .member-header { background-color: #dcdcdc; font-weight: bold; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Fee Payments Report</h2>
    <p>Generated on: {{ \Carbon\Carbon::now()->format('d M Y H:i') }}</p>

    @php $memberCounter = 1; @endphp

    @foreach($groupedPayments as $memberId => $payments)
        @php
            $member = $payments->first()->member;
            $total = $payments->sum('amount');
        @endphp

        {{-- Member Header --}}
        <table>
            <tr class="member-header">
       <!--         <td style="width: 30px;">#{{ $memberCounter }}</td>  -->
                <td style="width: 200px;">#{{ $memberCounter }} {{ $member->full_name ?? 'Unknown' }}({{ $member->member_no ?? '-' }})</td>
        <!--        <td style="width: 100px;">{{ $member->member_no ?? '-' }}</td>  -->
         <!--       remark
                <td style="width: 100px;">{{ $member->phone ?? '-' }}</td>
                <td style="width: 200px;">{{ $member->email ?? '-' }}</td>

-->
                <td class="text-right">Total: RM {{ number_format($total, 2) }}</td>
            </tr>
        </table>

        {{-- Payments Table --}}
        <table>
            <thead>
                <tr>
                    <th style="width: 80px;">Amount (RM)</th>
                    <th style="width: 100px;">Method</th>
                    <th style="width: 100px;">Date</th>
                    <th style="width: 120px;">Reference No</th>
                    <th style="width: 200px;">Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $p)
                    <tr>
                        <td class="text-right">{{ number_format($p->amount, 2) }}</td>
                        <td>{{ $p->payment_method }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->payment_date)->format('d M Y') }}</td>
                        <td>{{ $p->reference_no ?? '-' }}</td>
                        <td>{{ $p->remarks ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @php $memberCounter++; @endphp
    @endforeach

</body>
</html>
