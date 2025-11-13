<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">✏️ Edit Announcement</h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded border border-red-300">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('announcements.update', $announcement->announcement_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Title</label>
                    <input type="text" name="title" value="{{ old('title', $announcement->title) }}" required
                           class="mt-1 block w-full border rounded px-3 py-2 text-xs dark:bg-gray-700 dark:text-gray-100">
                </div>

                <!-- Content -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Content</label>
                    <textarea name="content" rows="4"
                              class="mt-1 block w-full border rounded px-3 py-2 text-xs dark:bg-gray-700 dark:text-gray-100">{{ old('content', $announcement->content) }}</textarea>
                </div>

                <!-- Dates -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Start Date</label>
                        <input type="date" name="start_date" value="{{ old('start_date', $announcement->start_date) }}"
                               class="mt-1 block w-full border rounded px-3 py-2 text-xs dark:bg-gray-700 dark:text-gray-100">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">End Date</label>
                        <input type="date" name="end_date" value="{{ old('end_date', $announcement->end_date) }}"
                               class="mt-1 block w-full border rounded px-3 py-2 text-xs dark:bg-gray-700 dark:text-gray-100">
                    </div>
                </div>

                {{-- 🗂 Existing Attachments --}}
                @php
                    $files = json_decode($announcement->attachments ?? '[]', true);
                @endphp

                @if (!empty($files))
                    <div class="mb-6">
                        <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">
                            Existing Attachments:
                        </label>

                        @foreach ($files as $file)
                            @php
                                $displayName = $file['original_name'] ?? basename($file['path']);
                            @endphp

                            <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-2 mb-2">
                                <div class="text-sm text-gray-800 dark:text-gray-100">
                                    📎
                                    <a href="{{ asset('storage/' . $file['path']) }}" target="_blank"
                                       class="text-blue-600 hover:underline">
                                        {{ $displayName }}
                                    </a>
                                </div>

                                <!-- ❌ Remove Button -->
                                <button type="button"
                                        onclick="removeAttachment('{{ $file['path'] }}')"
                                        class="text-xs text-red-600 hover:text-red-700">
                                    Remove
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- 📤 Upload New Attachments --}}
                <div class="mb-6">
                    <label for="attachments" class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">
                        Upload New Attachments (optional):
                    </label>
                    <input type="file" name="attachments[]" id="attachments" multiple
                           class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm w-full">
                    <p class="text-xs text-gray-500 mt-1">You can upload multiple files. Existing attachments will be kept.</p>
                </div>

                <!-- Active -->
                <div class="mb-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_active" value="1"
                               {{ old('is_active', $announcement->is_active) ? 'checked' : '' }}
                               class="form-checkbox text-blue-600">
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Active</span>
                    </label>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-2">
                    <a href="{{ route('announcements.index') }}"
                       class="px-4 py-2 text-xs bg-gray-300 hover:bg-gray-400 rounded text-gray-700">Back</a>
                    <button type="submit"
                            class="px-4 py-2 text-xs bg-blue-600 hover:bg-blue-700 rounded text-white">Update</button>
                </div>
            </form>
        </div>
    </div>

    {{-- 🗑️ Hidden Remove Form --}}
    <form id="removeAttachmentForm" action="{{ route('announcements.removeAttachment', $announcement->announcement_id) }}" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
        <input type="hidden" name="path" id="removePath">
    </form>

    <script>
        function removeAttachment(path) {
            if (confirm('Remove this attachment?')) {
                document.getElementById('removePath').value = path;
                document.getElementById('removeAttachmentForm').submit();
            }
        }
    </script>
</x-app-layout>
