<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">Add Event Participant</h2>
    </x-slot>

    <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
        <form action="{{ route('event_participants.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="block text-sm font-semibold mb-1">Event</label>
                <select name="event_id" id="event_id" class="w-full border p-2 rounded text-sm text-gray-900" required>
                    <option value="">-- Select Event --</option>
                    @foreach($events as $event)
                        <option value="{{ $event->event_id }}">{{ $event->event_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-semibold mb-1">Member</label>
                <select name="member_id" id="member_id" class="w-full border p-2 rounded text-sm text-gray-900" required>
                    <option value="">-- Select Member --</option>
                    {{-- Members will be loaded via AJAX --}}
                </select>
            </div>

            <div class="mb-3">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="attended" value="1" class="mr-2"> Attended
                </label>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
        </form>
    </div>

    {{-- AJAX script --}}
    <script>
        document.getElementById('event_id').addEventListener('change', function() {
            const eventId = this.value;
            const memberSelect = document.getElementById('member_id');

            memberSelect.innerHTML = '<option>Loading...</option>';

            fetch(`/event_participants/members/${eventId}`)
                .then(res => res.json())
                .then(data => {
                    memberSelect.innerHTML = '<option value="">-- Select Member --</option>';
                    data.forEach(m => {
                        memberSelect.innerHTML += `<option value="${m.member_id}">${m.full_name}</option>`;
                    });
                })
                .catch(err => {
                    console.error(err);
                    memberSelect.innerHTML = '<option>Error loading members</option>';
                });
        });
    </script>
</x-app-layout>
