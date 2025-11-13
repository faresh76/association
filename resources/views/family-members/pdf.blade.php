<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Family Members PDF</title>
    <style>
        body { font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h2>Family Members List</h2>
    @foreach ($members as $member)
        <h3>{{ $loop->iteration }}) {{ $member->full_name }} ({{ $member->member_no }})</h3>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Family Member Name</th>
                    <th>Relationship</th>
                    <th>Date of Birth</th>
                    <th>Contact No</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($member->familyMembers as $family)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $family->name }}</td>
                        <td>{{ $family->relationshipType->name ?? '-' }}</td>
                        <td>{{ $family->date_of_birth ?? '-' }}</td>
                        <td>{{ $family->contact_no ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</body>
</html>
