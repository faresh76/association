<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage; 

class AnnouncementController extends Controller
{
    // List with search & pagination
    public function index(Request $request)
    {
        // Auto-deactivate expired announcements
        Announcement::where('is_active', 1)
            ->whereNotNull('end_date')
            ->where('end_date', '<', now())
            ->update(['is_active' => 0]);

        $query = Announcement::with('creator')->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
        }

        $announcements = $query->paginate(10)->withQueryString();

        return view('announcements.index', compact('announcements'));
    }

    // Show form
    public function create()
    {
        return view('announcements.create');
    }

    // Store new announcement
public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:100',
        'content' => 'nullable|string',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'attachments.*' => 'nullable|file|max:2048', // each file ≤ 2MB
        'is_active' => 'nullable|boolean',
    ]);

    $attachments = [];

    if ($request->hasFile('attachments')) {
        foreach ($request->file('attachments') as $file) {
            $originalName = $file->getClientOriginalName();
            $path = $file->store('attachments', 'public');

            $attachments[] = [
                'path' => $path,
                'original_name' => $originalName,
            ];
        }
    }

    Announcement::create([
        'title' => $request->title,
        'content' => $request->content,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'is_active' => $request->has('is_active'),
        'created_by' => auth()->id(),
        'attachments' => json_encode($attachments), // 👈 important — store as JSON string
    ]);

    return redirect()->route('announcements.index')->with('success', 'Announcement created successfully!');
}




    // Show edit form
    public function edit(Announcement $announcement)
    {
        return view('announcements.edit', compact('announcement'));
    }

  public function update(Request $request, $id)
{
    $announcement = Announcement::findOrFail($id);

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'nullable|string',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date',
        'is_active' => 'nullable|boolean',
        'attachments.*' => 'file|max:5120', // optional file limit (5MB)
    ]);

    // ✅ Basic fields
    $announcement->title = $validated['title'];
    $announcement->content = $validated['content'] ?? '';
    $announcement->start_date = $validated['start_date'] ?? null;
    $announcement->end_date = $validated['end_date'] ?? null;
    $announcement->is_active = $request->has('is_active') ? 1 : 0;

    // ✅ Load current attachments (if any)
    $existingAttachments = json_decode($announcement->attachments ?? '[]', true);

    // ✅ Handle new uploads (append, not replace)
    if ($request->hasFile('attachments')) {
        foreach ($request->file('attachments') as $file) {
            $path = $file->store('announcements', 'public');

            $existingAttachments[] = [
                'original_name' => $file->getClientOriginalName(),
                'path' => $path,
            ];
        }
    }

    // ✅ Save back merged attachments
    $announcement->attachments = json_encode($existingAttachments);

    $announcement->save();

    return redirect()
        ->route('announcements.show', $announcement->announcement_id)
        ->with('success', 'Announcement updated successfully with attachments.');
}


    // Show announcement details
    public function show(Announcement $announcement)
    {
        // Auto-deactivate if end_date passed
        if ($announcement->is_active && $announcement->end_date && Carbon::parse($announcement->end_date)->lt(now())) {
            $announcement->update(['is_active' => false]);
        }

        return view('announcements.show', compact('announcement'));
    }

    // Delete
    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return redirect()->route('announcements.index')->with('success', 'Announcement deleted!');
    }

    // Print PDF
    public function printPdf(Request $request)
    {
        // Auto-deactivate expired announcements before printing
        Announcement::where('is_active', 1)
            ->whereNotNull('end_date')
            ->where('end_date', '<', now())
            ->update(['is_active' => 0]);

        $query = Announcement::with('creator')->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
        }

        $announcements = $query->get();

        $pdf = Pdf::loadView('announcements.pdf', compact('announcements'));
        return $pdf->stream('Announcements.pdf');
    }

    public function removeAttachment(Request $request, Announcement $announcement)
{
    $attachments = json_decode($announcement->attachments, true) ?? [];

    $pathToRemove = $request->input('path');
    $attachments = array_filter($attachments, fn($file) => $file['path'] !== $pathToRemove);

    // Delete file from storage
    if (Storage::exists('public/' . $pathToRemove)) {
        Storage::delete('public/' . $pathToRemove);
    }

    $announcement->attachments = json_encode(array_values($attachments));
    $announcement->save();

    return back()->with('success', 'Attachment removed successfully!');
}


}
