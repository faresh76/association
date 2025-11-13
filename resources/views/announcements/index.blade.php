<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">📢 Announcements</h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">

            @if(session('success'))
                <div class="mb-4 text-green-700 bg-green-100 border border-green-300 px-4 py-2 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-between items-center mb-4">
                <a href="{{ route('announcements.create') }}" 
                   class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-xs">
                    + Add Announcement
                </a>

                <form method="GET" action="{{ route('announcements.index') }}" class="flex items-center space-x-2">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search..." class="px-3 py-1 border rounded text-xs">
                    <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700">
                        Search
                    </button>
                    <a href="{{ route('announcements.index') }}" 
                       class="bg-gray-300 text-gray-700 px-3 py-1 rounded text-xs hover:bg-gray-400">
                        Clear
                    </a>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-xs border border-gray-300">
                    <thead class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                        <tr>
                            <th class="p-2 border border-gray-300">Title</th>
                            <th class="p-2 border border-gray-300">Created By</th>
                            <th class="p-2 border border-gray-300">Start Date</th>
                            <th class="p-2 border border-gray-300">End Date</th>
                            <th class="p-2 border border-gray-300">Status</th>
                            <th class="p-2 border border-gray-300 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($announcements as $a)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="p-2 border border-gray-300">{{ $a->title }}</td>
                                <td class="p-2 border border-gray-300">{{ $a->creator->name ?? '-' }}</td>
                                <td class="p-2 border border-gray-300">
                                    {{ $a->start_date ? \Carbon\Carbon::parse($a->start_date)->format('d M Y') : '-' }}
                                </td>
                                <td class="p-2 border border-gray-300">
                                    {{ $a->end_date ? \Carbon\Carbon::parse($a->end_date)->format('d M Y') : '-' }}
                                </td>
   <td class="p-2 border border-gray-300 text-center">
    <span class="{{ $a->is_active ? 'text-green-600 font-semibold' : 'text-red-600 font-semibold' }}">
        {{ $a->is_active ? 'Active' : 'Inactive' }}
    </span>
</td>


                                <td class="p-2 border border-gray-300 text-right space-x-2">
                                    <a href="{{ route('announcements.show', $a->announcement_id) }}" 
                                       class="text-blue-600 hover:underline">View</a>
                                    <a href="{{ route('announcements.edit', $a->announcement_id) }}" 
                                       class="text-yellow-600 hover:underline">Edit</a>
                                    <form action="{{ route('announcements.destroy', $a->announcement_id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete this announcement?')" class="text-red-600 hover:underline">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4 flex justify-between items-center">
                {{ $announcements->links() }}
                <a href="{{ route('announcements.printPdf', request()->query()) }}" target="_blank" class="bg-blue-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs">
                    🖨️ Print PDF
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
