<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Members List PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; }
        .status-active { background-color: #4CAF50; color: #fff; padding: 2px 4px; border-radius: 3px; }
        .status-inactive { background-color: #999; color: #fff; padding: 2px 4px; border-radius: 3px; }
        .status-suspended { background-color: #f0ad4e; color: #fff; padding: 2px 4px; border-radius: 3px; }
        .status-deceased { background-color: #000; color: #fff; padding: 2px 4px; border-radius: 3px; }
    </style>
</head>
<body>
    <h2>Members List</h2>
    @if(request('search'))
        <p>Filtered by: "{{ request('search') }}"</p>
    @endif
    @if(request('sort'))
        <p>Sorted by: "{{ request('sort') }}" ({{ request('direction') ?? 'asc' }})</p>
    @endif

   <table>
    <thead>
        <tr>
                <th>#</th>
                <th>Membership</th>
                <th>Member No</th>
                <th>Full Name</th>
                <th>IC No</th>
                <th>Phone</th>
                <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($members as $key => $member)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $member->membership_type_name ?? '-' }}</td>
            <td>{{ $member->member_no }}</td>
            <td>{{ $member->full_name }}</td>
            <td>{{ $member->ic_no }}</td>
            <td>{{ $member->phone ?? '-' }}</td>            
            <td>{{ $member->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>


 