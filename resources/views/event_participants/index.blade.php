<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">Event Participants</h2>
    </x-slot>

    <div class="max-w-6xl mx-auto bg-white p-6 rounded shadow">
        <a href="{{ route('event_participants.create') }}" 
           class="bg-blue-600 text-white px-3 py-2 rounded text-xs mb-4 inline-block">
           + Add Participant
        </a>

        @forelse($participants->groupBy('event_id') as $eventId => $group)
            @php
                $event = $group->first()->event;
            @endphp

            <div class="mb-6 border border-gray-300 rounded shadow-sm">
                <div class="bg-gray-100 px-4 py-2 font-semibold text-gray-800 flex justify-between items-center">
                    <span>{{ $event->event_name ?? 'Unknown Event' }}</span>
                    <span class="text-xs text-gray-500">
                        {{ $group->count() }} participant{{ $group->count() > 1 ? 's' : '' }}
                    </span>
                </div>

                <table class="min-w-full border-t text-xs table-fixed">
                    <thead class="bg-gray-50">
                        <tr>
                    <th class="p-2 w-10 text-left">#</th>
                    <th class="p-2 w-1/2 text-left">Member Name</th>
                    <th class="p-2 w-1/4 text-left">Attended</th>
                    <th class="p-2 w-1/4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($group as $p)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="p-2 w-10">{{ $loop->iteration }}</td>
                                <td class="p-2">{{ $p->member->full_name ?? '-' }}</td>
                                <td class="p-2">
                                    @if($p->attended)
                                        <span class="text-green-600 font-semibold">✅ Yes</span>
                                    @else
                                        <span class="text-red-500">❌ No</span>
                                    @endif
                                </td>
                                <td class="p-2 text-right">
                                    <a href="{{ route('event_participants.edit', $p->id) }}" 
                                       class="text-blue-600 hover:underline">Edit</a>
                                    <form action="{{ route('event_participants.destroy', $p->id) }}" 
                                          method="POST" 
                                          class="inline"
                                          onsubmit="return confirm('Delete this participant?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @empty
            <div class="text-center text-gray-500 py-6">
                No participants found.
            </div>
        @endforelse
    </div>
</x-app-layout>
