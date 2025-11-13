<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">Create Event</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
        <form action="{{ route('events.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="block text-sm font-semibold mb-1">Event Name</label>
                <input type="text" name="event_name" class="w-full border p-2 rounded text-sm" required>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-semibold mb-1">Event Date</label>
                <input type="date" name="event_date" class="w-full border p-2 rounded text-sm" required>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-semibold mb-1">Location</label>
                <input type="text" name="location" class="w-full border p-2 rounded text-sm" required>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-semibold mb-1">Organizer</label>
                <select name="organized_by" class="w-full border p-2 rounded text-sm" required>
                    <option value="">-- Select Organizer --</option>
                    @foreach($committeeMembers as $member)
                        <option value="{{ $member->id }}">{{ $member->full_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-semibold mb-1">Description</label>
                <textarea name="description" class="w-full border p-2 rounded text-sm" rows="3"></textarea>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
        </form>
    </div>
</x-app-layout>
