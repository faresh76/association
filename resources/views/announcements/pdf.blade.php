<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Announcements PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>📢 Announcements</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Content</th>
                <th>Created By</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($announcements as $i => $announcement)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $announcement->title }}</td>
                    <td>{{ $announcement->content }}</td>
                    <td>{{ $announcement->creator->name ?? 'Unknown' }}</td>
                    <td>{{ \Carbon\Carbon::parse($announcement->created_at)->format('d M Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
