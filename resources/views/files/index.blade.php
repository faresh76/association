<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            📁 File Management
        </h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">

            {{-- Success/Error Messages --}}
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded border border-green-300">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded border border-red-300">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Create Folder --}}
            <form action="{{ route('folders.store') }}" method="POST" class="mb-6 flex space-x-2">
                @csrf
                <input type="text" name="name" placeholder="New Folder Name"
                       class="flex-1 px-3 py-2 border rounded text-xs dark:bg-gray-700 dark:text-gray-100">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs">Create Folder</button>
            </form>

            {{-- Upload File --}}
            <form action="{{ route('files.store') }}" method="POST" enctype="multipart/form-data" class="mb-6 flex items-center space-x-2">
                @csrf
                <select name="folder_id" required class="px-3 py-2 border rounded text-xs dark:bg-gray-700 dark:text-gray-100">
                    <option value="">Select Folder</option>
                    @foreach($folders as $folder)
                        <option value="{{ $folder->id }}">{{ $folder->name }}</option>
                    @endforeach
                </select>
                <input type="file" name="file" required class="px-3 py-2 border rounded text-xs dark:bg-gray-700 dark:text-gray-100">
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-xs">Upload File</button>
            </form>

            {{-- Files Grouped by Folder --}}
            @forelse($folders as $folder)
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mt-6 mb-2 flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h6l2 3h10v11H3V7z" />
                    </svg>
                    <span>{{ $folder->name }}</span>
                </h3>

                @if($folder->files->isEmpty())
                    <p class="text-gray-500 mb-4">No files in this folder.</p>
                @else
                    <table class="w-full border border-collapse text-xs mb-4">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="border px-3 py-2">#</th>
                                <th class="border px-3 py-2 text-left">File Name</th>
                                <th class="border px-3 py-2">Size</th>
                                <th class="border px-3 py-2 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($folder->files as $index => $file)
                                <tr>
                                    <td class="border px-3 py-2">{{ $index + 1 }}</td>
                                    <td class="border px-3 py-2 flex items-center space-x-2">
                                        @php $ext = strtolower(pathinfo($file->name, PATHINFO_EXTENSION)) @endphp
                                        @if(in_array($ext, ['jpg','jpeg','png','gif']))
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h6l2 3h10v11H3V7z" />
                                            </svg>
                                        @elseif($ext === 'pdf')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 2a10 10 0 110 20 10 10 0 010-20z" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4h16v16H4V4z" />
                                            </svg>
                                        @endif
                                        <span>{{ $file->name }}</span>
                                    </td>
                                    <td class="border px-3 py-2">{{ number_format($file->size / 1024, 2) }} KB</td>
                                    <td class="border px-3 py-2 text-center space-x-1">
                                        <a href="{{ asset('storage/'.$file->path) }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-xs">Download</a>
                                        <form action="{{ route('files.destroy', $file->id) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Are you sure you want to delete this file?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-xs">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            @empty
                <p class="text-gray-500">No folders available.</p>
            @endforelse

        </div>
    </div>
</x-app-layout>
