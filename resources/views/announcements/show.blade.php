<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            📢 Announcement Details
        </h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">

            <!-- 🏷️ Title -->
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">
                {{ $announcement->title }}
            </h3>

            <!-- 📄 Content -->
            <div class="mb-6 text-gray-700 dark:text-gray-300 leading-relaxed border border-gray-300 dark:border-gray-600 rounded-lg p-4">
                {!! nl2br(e($announcement->content)) !!}
            </div>

            <!-- 📅 Metadata Table -->
            <div class="mb-8">
                <strong class="block text-gray-700 dark:text-gray-200 mb-2">Announcement Information:</strong>
                <table class="w-full border border-gray-300 dark:border-gray-600 text-xs">
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        <tr>
                            <th class="border border-gray-300 dark:border-gray-600 px-3 py-2 text-left bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 w-1/3">Start Date</th>
                            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 text-left text-gray-700 dark:text-gray-300">{{ $announcement->start_date ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="border border-gray-300 dark:border-gray-600 px-3 py-2 text-left bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">End Date</th>
                            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 text-gray-700 dark:text-gray-300">{{ $announcement->end_date ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="border border-gray-300 dark:border-gray-600 px-3 py-2 text-left bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">Status</th>
                            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2">
                                <span class="{{ $announcement->is_active ? 'text-green-600 font-semibold' : 'text-red-600 font-semibold' }}">
                                    {{ $announcement->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th class="border border-gray-300 dark:border-gray-600 px-3 py-2 text-left bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">Created By</th>
                            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 text-gray-700 dark:text-gray-300">{{ $announcement->creator->name ?? 'Unknown' }}</td>
                        </tr>
                        <tr>
                            <th class="border border-gray-300 dark:border-gray-600 px-3 py-2 text-left bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">Created At</th>
                            <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 text-gray-700 dark:text-gray-300">{{ \Carbon\Carbon::parse($announcement->created_at)->format('d M Y, h:i A') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- 📎 Attachments Table -->
            @php
                $attachments = json_decode($announcement->attachments ?? '[]', true);
            @endphp

            <div class="mb-8">
                <strong class="block text-gray-700 dark:text-gray-200 mb-2">Attachments:</strong>

                @if (is_array($attachments) && count($attachments) > 0)
                    <table class="w-full border border-gray-300 dark:border-gray-600 text-xs">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="border border-gray-300 dark:border-gray-600 px-3 py-2 text-left text-gray-700 dark:text-gray-200 w-12">#</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-3 py-2 text-left text-gray-700 dark:text-gray-200">File Name</th>
                                <th class="border border-gray-300 dark:border-gray-600 px-3 py-2 text-left text-gray-700 dark:text-gray-200 w-28">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attachments as $index => $file)
                                @php
                                    $filePath = $file['path'] ?? null;
                                    $originalName = $file['original_name'] ?? basename($filePath);
                                    $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                                @endphp

                                @if ($filePath)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 text-gray-700 dark:text-gray-300">{{ $index + 1 }}</td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 text-gray-800 dark:text-gray-100">
                                            {{ $originalName }} <br>
                                            @if (in_array($ext, ['jpg', 'jpeg', 'png']))
                                                <a href="{{ asset('storage/' . $filePath) }}" target="_blank" class="text-blue-600 text-xs hover:underline">View Image</a>
                                            @elseif ($ext === 'pdf')
                                                <a href="{{ asset('storage/' . $filePath) }}" target="_blank" class="text-blue-600 text-xs hover:underline">Open PDF</a>
                                            @else
                                                <a href="{{ asset('storage/' . $filePath) }}" target="_blank" class="text-blue-600 text-xs hover:underline">Download File</a>
                                            @endif
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 text-center">
                                            <form action="{{ route('announcements.removeAttachment', $announcement->announcement_id) }}" method="POST" onsubmit="return confirm('Remove this attachment?');">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="path" value="{{ $filePath }}">
                                                <button type="submit" class="text-red-600 hover:text-red-700 text-sm font-medium">
                                                    🗑 Remove
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-sm text-gray-500 dark:text-gray-400 italic">
                        No attachments uploaded for this announcement.
                    </div>
                @endif
            </div>

            <!-- 💬 Note -->
            <div class="mb-4 text-sm text-gray-500 dark:text-gray-400 italic">
                Note: Start and End Dates define the validity period of this announcement.
            </div>

            <!-- 🔘 Action Buttons -->
            <div class="flex justify-end space-x-2 mt-6">
                <a href="{{ route('announcements.index') }}"
                   class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500 transition">Back</a>

                <a href="{{ route('announcements.edit', $announcement->announcement_id) }}"
                   class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">Edit</a>
            </div>

        </div>
    </div>
</x-app-layout>
