<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Membership Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }
        h2 { text-align: center; margin-bottom: 10px; }
        .text-center { text-align: center; }
        .expired { color: red; font-weight: bold; }
        .active { color: green; font-weight: bold; }
    </style>
</head>
<body>
    <h2>Membership List</h2>
    @if($search)
        <p><strong>Filtered by:</strong> "{{ $search }}"</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Member</th>
                <th>Membership Type</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($memberMemberships as $index => $m)
                @php
                    $today = \Carbon\Carbon::today();
                    $endDate = $m->end_date ? \Carbon\Carbon::parse($m->end_date) : null;
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $m->member->full_name ?? '-' }}</td>
                    <td>{{ $m->membershipType->type_name ?? '-' }}</td>
                    <td>{{ $m->start_date ? \Carbon\Carbon::parse($m->start_date)->format('d/m/Y') : '-' }}</td>
                    <td>{{ $m->end_date ? \Carbon\Carbon::parse($m->end_date)->format('d/m/Y') : '-' }}</td>
                    <td class="text-center">
                        @if($endDate && $endDate->lt($today))
                            <span class="expired">Expired</span>
                        @elseif($m->is_active)
                            <span class="active">Active</span>
                        @else
                            <span>Inactive</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
