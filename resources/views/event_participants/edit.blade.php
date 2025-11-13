<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xs font-bold">Edit Event Participant</h2>
    </x-slot>

    <div class="max-w-md mx-auto bg-white p-6 rounded shadow">


        <form action="{{ route('event_participants.update', $event_participant->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="block text-sxsm font-semibold mb-1">Event</label>
                <select name="event_id" class="w-full border p-2 rounded text-xs text-gray-900" required>
                    @foreach($events as $event)
                        <option value="{{ $event->event_id }}" {{ $event->event_id == $event_participant->event_id ? 'selected' : '' }}>
                            {{ $event->event_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="block text-xs font-semibold mb-1">Member</label>
                <select name="member_id" class="w-full border p-2 rounded text-xs text-gray-900" required>
                    @foreach($members as $member)
                        <option value="{{ $member->member_id }}" {{ $member->member_id == $event_participant->member_id ? 'selected' : '' }}>
                            {{ $member->full_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="attended" value="1" {{ $event_participant->attended ? 'checked' : '' }}> 
                    <span class="ml-2">Attended</span>
                </label>
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Update
            </button>

                    <!-- ✅ Back Button -->
    
            <a href="{{ route('event_participants.index') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Cancel
            </a>
        </div>

        </form>
    </div>
</x-app-layout>
