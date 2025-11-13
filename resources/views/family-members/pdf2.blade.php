<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Family Member Details (Version 2)</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; line-height: 1.4; }
        h2 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #999; padding: 6px 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .section-title { margin-top: 25px; font-size: 14px; font-weight: bold; }
    </style>
</head>
<body>

    <h2>Family Member Details</h2>

    <table>
        <tr><th>Member</th><td>{{ $family_member->member->full_name ?? '-' }}</td></tr>
        <tr><th>Family Member Name</th><td>{{ $family_member->name ?? '-' }}</td></tr>
        <tr><th>Relationship</th><td>{{ $family_member->relationshipType->name ?? '-' }}</td></tr>
        <tr><th>IC No</th><td>{{ $family_member->ic_no ?? '-' }}</td></tr>
        <tr><th>Date of Birth</th><td>{{ $family_member->date_of_birth ? \Carbon\Carbon::parse($family_member->date_of_birth)->format('d/m/Y') : '-' }}</td></tr>
        <tr><th>Contact No</th><td>{{ $family_member->contact_no ?? '-' }}</td></tr>
        <tr><th>Email</th><td>{{ $family_member->email ?? '-' }}</td></tr>
        <tr><th>Occupation</th><td>{{ $family_member->occupation ?? '-' }}</td></tr>
        <tr><th>Address</th><td>{{ $family_member->address ?? '-' }}</td></tr>
    </table>

    @if ($family_member->relationship_type_id == 2)
        <div class="section-title">Child Details</div>
        <table>
            <tr><th>No. of Siblings</th><td>{{ $family_member->child_no_of_sibling ?? '-' }}</td></tr>
            <tr><th>Diagnose</th><td>{{ $family_member->child_diagnose ?? '-' }}</td></tr>
            <tr><th>Right Ear Hearing Level</th><td>{{ $family_member->child_right_ear_hearing_level ?? '-' }}</td></tr>
            <tr><th>Left Ear Hearing Level</th><td>{{ $family_member->child_left_ear_hearing_level ?? '-' }}</td></tr>
            <tr><th>Right Ear Hearing Tool</th><td>{{ $family_member->child_right_ear_hearing_tool ?? '-' }}</td></tr>
            <tr><th>Left Ear Hearing Tool</th><td>{{ $family_member->child_left_ear_hearing_tool ?? '-' }}</td></tr>
            <tr><th>Right Ear Brand</th><td>{{ $family_member->child_right_ear_hearing_tool_brand ?? '-' }}</td></tr>
            <tr><th>Left Ear Brand</th><td>{{ $family_member->child_left_ear_hearing_tool_brand ?? '-' }}</td></tr>
            <tr><th>Using Right Ear From</th><td>{{ $family_member->child_right_ear_hearing_tool_from ?? '-' }}</td></tr>
            <tr><th>Using Left Ear From</th><td>{{ $family_member->child_left_ear_hearing_tool_from ?? '-' }}</td></tr>
            <tr><th>Reference Hospital</th><td>{{ $family_member->child_reference_hospital ?? '-' }}</td></tr>
            <tr><th>School Name</th><td>{{ $family_member->child_school_name ?? '-' }}</td></tr>
            <tr><th>Level of Education</th><td>{{ $family_member->child_education_level ?? '-' }}</td></tr>
            <tr><th>OKU Status</th><td>{{ $family_member->child_oku_status ?? '-' }}</td></tr>
        </table>
    @endif

    <div class="section-title">System Info</div>
    <table>
        <tr><th>Created At</th><td>{{ optional($family_member->created_at)->format('d/m/Y H:i') ?? '-' }}</td></tr>
        <tr><th>Updated At</th><td>{{ optional($family_member->updated_at)->format('d/m/Y H:i') ?? '-' }}</td></tr>
    </table>

</body>
</html>
