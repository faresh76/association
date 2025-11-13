<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Member Details
        </h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8 text-xs">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 sm:p-8">

            {{-- Member Photo --}}
            @if($member->photo)
                <div class="flex justify-center mb-6">
                    <img src="{{ asset('storage/' . $member->photo) }}" 
                        class="h-28 w-28 rounded-full border-2 border-gray-300 dark:border-gray-600 object-cover shadow-sm" 
                        alt="{{ $member->full_name }}">
                </div>
            @else
                <div class="flex justify-center mb-6">
                    <div class="h-28 w-28 rounded-full bg-gray-300 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-300 text-sm font-medium">
                        No Photo
                    </div>
                </div>
            @endif

            {{-- Member Details Table --}}
            <table class="min-w-full border border-gray-300 dark:border-gray-700 text-xs rounded-md overflow-hidden">
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <tr>
                        <th class="bg-gray-100 dark:bg-gray-700 px-3 py-2 font-medium">Membership</th>
                        <td class="px-3 py-2">{{ $membership->type_name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="bg-gray-100 dark:bg-gray-700 px-3 py-2 w-1/3 font-medium">Member No</th>
                        <td class="px-3 py-2">{{ $member->member_no }}</td>
                    </tr>
                    <tr>
                        <th class="bg-gray-100 dark:bg-gray-700 px-3 py-2 font-medium">Full Name</th>
                        <td class="px-3 py-2">{{ $member->full_name }}</td>
                    </tr>
                    <tr>
                        <th class="bg-gray-100 dark:bg-gray-700 px-3 py-2 font-medium">IC No</th>
                        <td class="px-3 py-2">{{ $member->ic_no ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="bg-gray-100 dark:bg-gray-700 px-3 py-2 font-medium">Gender</th>
                        <td class="px-3 py-2">{{ $member->gender ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="bg-gray-100 dark:bg-gray-700 px-3 py-2 font-medium">Date of Birth</th>
                        <td class="px-3 py-2">{{ optional($member->date_of_birth)->format('d/m/Y') ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="bg-gray-100 dark:bg-gray-700 px-3 py-2 font-medium">Phone</th>
                        <td class="px-3 py-2">{{ $member->phone ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="bg-gray-100 dark:bg-gray-700 px-3 py-2 font-medium">Email</th>
                        <td class="px-3 py-2">{{ $member->email ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="bg-gray-100 dark:bg-gray-700 px-3 py-2 font-medium">Occupation</th>
                        <td class="px-3 py-2">{{ $member->occupation ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="bg-gray-100 dark:bg-gray-700 px-3 py-2 font-medium">Join Date</th>
                        <td class="px-3 py-2">{{ optional($member->join_date)->format('d/m/Y') ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="bg-gray-100 dark:bg-gray-700 px-3 py-2 font-medium">Address</th>
                        <td class="px-3 py-2">{{ $member->address ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="bg-gray-100 dark:bg-gray-700 px-3 py-2 font-medium">Status</th>
<td class="border p-2 ">
    @switch($member->status)
        @case('Active')
            <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Active</span>
            @break
        @case('Inactive')
            <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold">Inactive</span>
            @break
        @case('Suspended')
            <span class="px-2 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-semibold">Suspended</span>
            @break
        @case('Deceased')
            <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">Deceased</span>
            @break
        @default
            <span class="px-2 py-1 bg-gray-50 text-gray-600 rounded-full text-xs font-semibold">Unknown</span>
    @endswitch
</td>

                    </tr>
                    <tr>
                        <th class="bg-gray-100 dark:bg-gray-700 px-3 py-2 font-medium">Created At</th>
                        <td class="px-3 py-2">{{ optional($member->created_at)->format('d/m/Y H:i') ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="bg-gray-100 dark:bg-gray-700 px-3 py-2 font-medium">Updated At</th>
                        <td class="px-3 py-2">{{ optional($member->updated_at)->format('d/m/Y H:i') ?? '-' }}</td>
                    </tr>

                </tbody>
            </table>

            {{-- Back Button --}}
            <div class="mt-6 flex justify-start">
                <a href="{{ route('members.index') }}" 
                   class="text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white underline">
                    ← Back to list
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
