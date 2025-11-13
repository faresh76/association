<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            Committee Members
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 text-xs">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-4">

            <a href="{{ route('committee-members.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded mb-3 inline-block text-xs">
               + Assign Role to Member
            </a>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-2 rounded mb-3 text-xs">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-300 dark:border-gray-700 text-xs">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 ">
                        <tr>
                            <th class="p-2 text-left">#</th>
                            <th class="p-2 text-left">Member</th>
                            <th class="p-2 text-left">Role</th>
                            <th class="p-2 text-left">Term Start</th>
                            <th class="p-2 text-left">Term End</th>
                            <th class="p-2 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($committeeMembers as $assignment)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="p-2">{{ $loop->iteration }}</td>
                                <td class="p-2">{{ $assignment->member->full_name }}</td>
                                <td class="p-2">{{ $assignment->role->role_name }}</td>
                                <td class="p-2">{{ $assignment->term_start ?? '-' }}</td>
                                <td class="p-2">{{ $assignment->term_end ?? '-' }}</td>
                                <td class="p-2 text-right">
                                    <div class="flex justify-end items-center space-x-1">
                                        <a href="{{ route('committee-members.edit', $assignment) }}" 
                                           class="text-yellow-600 hover:underline">Edit</a>
                                        <span class="text-gray-400">|</span>
                                        <form action="{{ route('committee-members.destroy', $assignment) }}" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirm('Delete this assignment?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center p-3 text-gray-500">
                                    No committee assignments found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3 text-sm">
                {{ $committeeMembers->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
