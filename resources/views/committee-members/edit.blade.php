<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Committee Role Assignment
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <form action="{{ route('committee-members.update', $committeeMember->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-200 text-sm font-medium mb-1">Member</label>
                    <select name="member_id" class="w-full border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                        <option value="">-- Select Member --</option>
                        @foreach($members as $member)
                            <option value="{{ $member->member_id }}" 
                                {{ $committeeMember->member_id == $member->member_id ? 'selected' : '' }}>
                                {{ $member->full_name }} ({{ $member->member_no }})
                            </option>
                        @endforeach
                    </select>
                    @error('member_id') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-200 text-sm font-medium mb-1">Role</label>
                    <select name="role_id" class="w-full border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                        <option value="">-- Select Role --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->role_id }}" 
                                {{ $committeeMember->role_id == $role->role_id ? 'selected' : '' }}>
                                {{ $role->role_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4 flex gap-2">
                    <div class="flex-1">
                        <label class="block text-gray-700 dark:text-gray-200 text-sm font-medium mb-1">Term Start</label>
                        <input type="date" name="term_start" value="{{ $committeeMember->term_start }}" class="w-full border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                        @error('term_start') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex-1">
                        <label class="block text-gray-700 dark:text-gray-200 text-sm font-medium mb-1">Term End</label>
                        <input type="date" name="term_end" value="{{ $committeeMember->term_end }}" class="w-full border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                        @error('term_end') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('committee-members.index') }}" class="px-4 py-2 rounded bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-200 hover:bg-gray-400">Cancel</a>
                    <button type="submit" class="px-4 py-2 rounded bg-cyan-600 hover:bg-cyan-700 text-white">Update Assignment</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
