<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <!-- Grid Layout: 2 Columns -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Latest Active Announcements --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6" x-data="{ open: true }">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                        📢 Latest Active Announcements
                    </h3>
                    <button @click="open = !open"
                            class="text-sm text-blue-600 hover:underline focus:outline-none">
                        <span x-text="open ? 'Hide' : 'Show'"></span>
                    </button>
                </div>

                <div x-show="open" x-transition>
                    @if($latestAnnouncements->count())
                        <ul class="divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                            @foreach($latestAnnouncements as $announcement)
                                <li class="py-3 hover:bg-gray-50 dark:hover:bg-gray-700 px-2 rounded flex justify-between items-start">
                                    <div>
                                        <p class="font-medium text-gray-800 dark:text-gray-100">{{ $announcement->title }}</p>
                                        <p class="text-xs text-gray-500">
                                            Valid: {{ $announcement->start_date ?? '-' }} - {{ $announcement->end_date ?? '-' }}
                                        </p>
                                    </div>
                                    <a href="{{ route('announcements.show', $announcement->announcement_id) }}" 
                                       class="text-blue-600 text-xs hover:underline">View</a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500 dark:text-gray-400 text-sm">
                            No active announcements at the moment.
                        </p>
                    @endif
                </div>
            </div>

            {{-- Latest Expired Memberships --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6" x-data="{ open: true }">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                        ⚠️ Latest Expired Memberships
                    </h3>
                    <button @click="open = !open"
                            class="text-sm text-blue-600 hover:underline focus:outline-none">
                        <span x-text="open ? 'Hide' : 'Show'"></span>
                    </button>
                </div>

                <div x-show="open" x-transition>
                    @if($latestExpiredMemberships->count())
                        <ul class="divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                            @foreach($latestExpiredMemberships as $m)
                                <li class="py-3 hover:bg-gray-50 dark:hover:bg-gray-700 px-2 rounded flex justify-between items-start">
                                    <div>
                                        <p class="font-medium text-gray-800 dark:text-gray-100">{{ $m->member->full_name }}</p>
                                        <p class="text-xs text-gray-500">
                                            {{ $m->membershipType->type_name ?? '-' }} - Expired: {{ $m->end_date }}
                                        </p>
                                    </div>
                                    <span class="text-red-600 text-xs font-semibold">Expired</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500 dark:text-gray-400 text-sm">
                            No expired memberships.
                        </p>
                    @endif
                </div>
            </div>

            {{-- Upcoming Events Section --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6" x-data="{ open: true }">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                        📅 Upcoming Events
                    </h3>
                    <button @click="open = !open"
                            class="text-sm text-blue-600 hover:underline focus:outline-none">
                        <span x-text="open ? 'Hide' : 'Show'"></span>
                    </button>
                </div>

                <div x-show="open" x-transition>
                    @if($upcomingEvents->count())
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-300 dark:border-gray-700 text-xs">
                                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                    <tr>
                                        <th class="p-2 text-left">Event</th>
                                        <th class="p-2 text-left">Date</th>
                                        <th class="p-2 text-left">Location</th>
                                        <th class="p-2 text-left">Participants</th>
                                        <th class="p-2 text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($upcomingEvents as $event)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="p-2 font-medium">{{ $event->event_name }}</td>
                                            <td class="p-2">
                                                {{ $event->event_date ? \Carbon\Carbon::parse($event->event_date)->format('d M Y') : '-' }}
                                            </td>
                                            <td class="p-2">{{ $event->location ?? '-' }}</td>
                                            <td class="p-2">
                                                <span class="bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100 px-2 py-0.5 rounded text-xs">
                                                    {{ $event->participants_count }}
                                                </span>
                                            </td>
                                            <td class="p-2 text-right">
                                                <a href="{{ route('event_participants.index') }}?event={{ $event->event_id }}" 
                                                   class="text-blue-600 hover:underline">
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400 text-sm">
                            No upcoming events found.
                        </p>
                    @endif
                </div>
            </div>

            {{-- Newest Members --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3">👥 Newest Members</h3>

                @if($newestMembers->isEmpty())
                    <p class="text-gray-500 text-sm">No members have registered recently.</p>
                @else
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($newestMembers as $member)
                            <li class="py-3 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700 px-2 rounded">
                                <div>
                                    <p class="font-medium text-gray-800 dark:text-gray-100">{{ $member->full_name }}</p>
                                    <p class="text-xs text-gray-500">
                                        Joined {{ $member->created_at?->diffForHumans() ?? '-' }}
                                    </p>
                                </div>
                                <a href="{{ route('members.show', $member->member_id) }}" 
                                   class="text-blue-600 text-xs hover:underline">View</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
