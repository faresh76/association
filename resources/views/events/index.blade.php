<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            Events
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 text-xs">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-4">

            <a href="{{ route('events.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded mb-3 inline-block text-xs">
               + Add Event
            </a>

            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-300 dark:border-gray-700 text-xs">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                        <tr>
                            <th class="p-2 text-left">#</th>
                            <th class="p-2 text-left">Event Name</th>
                            <th class="p-2 text-left">Date</th>
                            <th class="p-2 text-left">Location</th>
                            <th class="p-2 text-left">Description</th>
                            <th class="p-2 text-left">Organized By</th>
                            <th class="p-2 text-left">Participants</th>
                            <th class="p-2 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($events as $event)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="p-2">{{ $loop->iteration }}</td>
                                <td class="p-2">{{ $event->event_name }}</td>
                                <td class="p-2">{{ $event->event_date ?? '-' }}</td>
                                <td class="p-2">{{ $event->location ?? '-' }}</td>
                                <td class="p-2">{{ $event->description ?? '-' }}</td>
                                <td class="p-2">{{ $event->organizer?->member->full_name ?? '-' }}</td>

                                <!-- Participant section -->
                                <td class="p-2">
                                    <button type="button" 
                                            class="text-blue-600 hover:underline"
                                            onclick="toggleParticipants({{ $event->event_id }})">
                                        {{ $event->participants->count() }} participant(s)
                                    </button>

                                    <div id="participants-{{ $event->event_id }}" class="hidden mt-1 pl-3 text-gray-700 dark:text-gray-300">
                                        <ul class="list-disc text-xs">
                                            @forelse($event->participants as $p)
                                                <li>{{ $p->member->full_name ?? '-' }} 
                                                    @if($p->attended)
                                                        <span class="text-green-600">(Attended)</span>
                                                    @endif
                                                </li>
                                            @empty
                                                <li class="text-gray-500">No participants</li>
                                            @endforelse
                                        </ul>
                                    </div>
                                </td>

                                <td class="p-2 text-right">
                                    <div class="flex justify-end items-center space-x-1">
                                        <a href="{{ route('events.edit', $event->event_id) }}" class="text-yellow-600 hover:underline">Edit</a>
                                        <form action="{{ route('events.destroy', $event->event_id) }}" 
                                              method="POST"
                                              class="inline"
                                              onsubmit="return confirm('Delete this event?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center p-3 text-gray-500">
                                    No events found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <script>
        function toggleParticipants(eventId) {
            const el = document.getElementById('participants-' + eventId);
            el.classList.toggle('hidden');
        }
    </script>
</x-app-layout>
