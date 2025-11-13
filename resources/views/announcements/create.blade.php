<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">📢 Add Announcement</h2>
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

            <!-- ✅ Add enctype for file upload -->
            <form action="{{ route('announcements.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Title -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                           class="mt-1 block w-full border rounded px-3 py-2 text-xs dark:bg-gray-700 dark:text-gray-100">
                </div>

                <!-- Content -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Content</label>
                    <textarea name="content" rows="4"
                              class="mt-1 block w-full border rounded px-3 py-2 text-xs dark:bg-gray-700 dark:text-gray-100">{{ old('content') }}</textarea>
                </div>

                <div class="mb-4 text-sm text-gray-500 dark:text-gray-400">
                    <em>Note: Start Date and End Date define the validity period of the announcement.</em>
                </div>

                <!-- Start Date -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Start Date</label>
                    <input type="date" name="start_date" value="{{ old('start_date') }}"
                           class="mt-1 block w-full border rounded px-3 py-2 text-xs dark:bg-gray-700 dark:text-gray-100">
                </div>

                <!-- End Date -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">End Date</label>
                    <input type="date" name="end_date" value="{{ old('end_date') }}"
                           class="mt-1 block w-full border rounded px-3 py-2 text-xs dark:bg-gray-700 dark:text-gray-100">
                </div>

                <!-- ✅ Multiple Attachments -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                        Attachments (optional)
                    </label>
                    <input type="file" name="attachments[]" multiple
                           accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
                           class="mt-1 block w-full text-xs text-gray-700 dark:text-gray-100 border rounded px-3 py-2 dark:bg-gray-700">
                    <p class="text-xs text-gray-500 mt-1">
                        You can upload multiple files. Allowed types: JPG, PNG, PDF, DOC, DOCX (Max: 5MB each).
                    </p>
                </div>

                <!-- Active Checkbox -->
                <div class="mb-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_active" value="1"
                               {{ old('is_active', true) ? 'checked' : '' }}
                               class="form-checkbox text-blue-600">
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Active</span>
                    </label>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-2">
                    <a href="{{ route('announcements.index') }}"
                       class="px-4 py-2 text-xs bg-gray-300 hover:bg-gray-400 rounded text-gray-700">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-4 py-2 text-xs bg-blue-600 hover:bg-blue-700 rounded text-white">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
