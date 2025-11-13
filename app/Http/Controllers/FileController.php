<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\File;
use Illuminate\Http\Request;

class FileController extends Controller
{

    public function index()
    {
        $folders = Folder::all(); // load all folders
        $files = File::with('folder')->get(); // load all files with their folder relationship

        return view('files.index', compact('folders', 'files'));
    }


    public function store(Request $request) {
        $request->validate([
            'folder_id' => 'required|exists:folders,id',
            'file' => 'required|file|max:10240' // max 10MB
        ]);

        $file = $request->file('file');
        $path = $file->store('uploads', 'public');

        File::create([
            'folder_id' => $request->folder_id,
            'user_id' => auth()->id(),
            'name' => $file->getClientOriginalName(),
            'path' => $path,
            'type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
        ]);

        return back()->with('success', 'File uploaded.');
    }

    public function destroy(File $file)
    {
        // Optional: if you want to check authorization
        // $this->authorize('delete', $file);

        // Delete the file from storage
        if (file_exists(storage_path('app/public/' . $file->path))) {
            unlink(storage_path('app/public/' . $file->path));
        }

        $file->delete();

        return redirect()->route('files.index')->with('success', 'File deleted successfully.');
    }
}
