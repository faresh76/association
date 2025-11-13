<div class="mb-4">
    <label class="block text-gray-700 dark:text-gray-200 mb-1">Event Name</label>
    <input type="text" name="event_name" value="{{ old('event_name', $event->event_name) }}"
           class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs">
    @error('event_name')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="block text-gray-700 dark:text-gray-200 mb-1">Date</label>
    <input type="date" name="event_date" value="{{ old('event_date', $event->event_date) }}"
           class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs">
    @error('event_date')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="block text-gray-700 dark:text-gray-200 mb-1">Location</label>
    <input type="text" name="location" value="{{ old('location', $event->location) }}"
           class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs">
    @error('location')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="block text-gray-700 dark:text-gray-200 mb-1">Description</label>
    <textarea name="description" rows="3"
              class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs">{{ old('description', $event->description) }}</textarea>
    @error('description')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="block text-gray-700 dark:text-gray-200 mb-1">Organized By</label>
    <select name="organized_by"
         class="w-full border border-gray-300 p-2 rounded text-sm 
           bg-white text-gray-900 dark:bg-white dark:text-gray-900 focus:ring-2 focus:ring-blue-500">
        <option value="">-- Select Organizer --</option>
        @foreach($committeeMembers as $member)
            <option value="{{ $member->id }}"
                {{ old('organized_by', $event->organized_by) == $member->id ? 'selected' : '' }}>
                {{ $member->member_name }}
            </option>
        @endforeach
    </select>
    @error('organized_by')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>

