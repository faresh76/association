<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
            Edit Event
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow text-xs">
        <form action="{{ route('events.update', $event->event_id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Event Name --}}
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-200 mb-1 font-semibold">Event Name</label>
                <input type="text" name="event_name" 
                       value="{{ old('event_name', $event->event_name) }}"
                       class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs 
                              bg-white text-gray-900 dark:bg-gray-700 dark:text-gray-100"
                       required>
                @error('event_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Event Date --}}
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-200 mb-1 font-semibold">Event Date</label>
                <input type="date" name="event_date" 
                       value="{{ old('event_date', $event->event_date) }}"
                       class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs 
                              bg-white text-gray-900 dark:bg-gray-700 dark:text-gray-100"
                       required>
                @error('event_date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Location --}}
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-200 mb-1 font-semibold">Location</label>
                <input type="text" name="location" 
                       value="{{ old('location', $event->location) }}"
                       class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs 
                              bg-white text-gray-900 dark:bg-gray-700 dark:text-gray-100"
                       required>
                @error('location')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Organizer --}}
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-200 mb-1 font-semibold">Organized By</label>
                <select name="organized_by"
                        class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs 
                               bg-white text-gray-900 dark:bg-white dark:text-gray-900 focus:ring-2 focus:ring-blue-500"
                        required>
                    <option value="">-- Select Organizer --</option>
                    @foreach($committeeMembers as $member)
                        <option value="{{ $member->id }}" 
                            {{ old('organized_by', $event->organized_by) == $member->id ? 'selected' : '' }}>
                            {{ $member->full_name }}
                        </option>
                    @endforeach
                </select>
                @error('organized_by')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-200 mb-1 font-semibold">Description</label>
                <textarea name="description" rows="3"
                          class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs 
                                 bg-white text-gray-900 dark:bg-gray-700 dark:text-gray-100">{{ old('description', $event->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Buttons --}}
            <div class="flex justify-end space-x-2">
                <a href="{{ route('events.index') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Update
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
