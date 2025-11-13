<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            Members List
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 text-xs">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-4">

    <div class="flex justify-between items-center mb-4">
    <!-- Left side: Add Member + Print PDF -->
   
        <a href="{{ route('members.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-xs">
           + Add Member
        </a>
 <div class="flex items-center space-x-2">

        <a href="{{ route('members.exportExcel') }}" 
        target="_blank"
        class="bg-blue-600 hover:bg-green-700 text-white px-4 py-2 rounded text-xs">
        🖨 Print Excell
        </a>
  

        <a href="{{ route('members.pdf', request()->all()) }}" 
        target="_blank"
        class="bg-blue-600 hover:bg-green-700 text-white px-4 py-2 rounded text-xs">
        🖨 Print PDF
        </a>
  

    <!-- Right side: Search + Clear -->
    <form method="GET" action="{{ route('members.index') }}" class="flex space-x-2">
        <input 
            type="text" 
            name="search" 
            value="{{ request('search') }}" 
            placeholder="Search member no, name or IC" 
            class="px-3 py-2 border rounded text-xs"
        >
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-xs">
            Search
        </button>
        <a href="{{ route('members.index') }}" 
           class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded text-xs">
            Clear
        </a>
    </form>
</div>
  </div>


            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-2 rounded mb-3 text-xs">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-xs">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                        <tr>
                            <th class="px-4 py-2 text-left">#</th>
                    <th class="px-4 py-2 text-left">
                        <a href="{{ route('members.index', array_merge(request()->all(), [
                            'sort' => 'membership_type_name',
                            'direction' => request('sort') === 'membership_type_name' && request('direction') === 'asc' ? 'desc' : 'asc'
                        ])) }}">
                            Membership
                            @if(request('sort') === 'membership_type_name')
                                @if(request('direction') === 'asc') &#9650; @else &#9660; @endif
                            @endif
                        </a>
                    </th>


                            <th class="px-4 py-2 text-left">
                            <a href="{{ route('members.index', array_merge(request()->all(), [
                                'sort' => 'member_no',
                                'direction' => request('sort') === 'member_no' && request('direction') === 'asc' ? 'desc' : 'asc'
                            ])) }}">
                                Member No
                                @if(request('sort') === 'member_no')
                                    @if(request('direction') === 'asc') &#9650; @else &#9660; @endif
                                @endif
                            </a>
                            </th>

                            <th class="px-4 py-2 text-left">
                            <a href="{{ route('members.index', array_merge(request()->all(), [
                                'sort' => 'full_name',
                                'direction' => request('sort') === 'full_name' && request('direction') === 'asc' ? 'desc' : 'asc'
                            ])) }}">
                                Full Name
                                @if(request('sort') === 'full_name')
                                    @if(request('direction') === 'asc') &#9650; @else &#9660; @endif
                                @endif
                            </a>
                            </th>
                            <th class="px-4 py-2 text-left">IC No</th>
                            <th class="px-4 py-2 text-left">Phone</th>
                            <th class="px-4 py-2 text-left">
                                                        <a href="{{ route('members.index', array_merge(request()->all(), [
                                'sort' => 'status',
                                'direction' => request('sort') === 'status' && request('direction') === 'asc' ? 'desc' : 'asc'
                            ])) }}">
                                Status
                                @if(request('sort') === 'status')
                                    @if(request('direction') === 'asc') &#9650; @else &#9660; @endif
                                @endif
                            </a>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($members as $member)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-4 py-2">{{ $loop->iteration + ($members->currentPage() - 1) * $members->perPage() }}</td>
                                <td class="px-4 py-2">{{ $member->membership_type_name ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $member->member_no }}</td>
                                <td class="px-4 py-2">{{ $member->full_name }}</td>
                                <td class="px-4 py-2">{{ $member->ic_no }}</td>
                                <td class="px-4 py-2">{{ $member->phone ?? '-' }}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 rounded text-white
                                        @if($member->status == 'Active')
                                            bg-green-600
                                        @elseif($member->status == 'Inactive')
                                            bg-gray-500
                                        @elseif($member->status == 'Suspended')
                                            bg-yellow-500
                                        @elseif($member->status == 'Deceased')
                                            bg-black
                                        @else
                                            bg-red-600
                                        @endif">
                                        {{ $member->status }}
                                    </span>
                                </td>

                                <td class="px-4 py-2 space-x-1">
                                    <a href="{{ route('members.show', $member) }}" 
                                       class="text-blue-600 hover:underline">View</a>
                                    <a href="{{ route('members.edit', $member) }}" 
                                       class="text-yellow-600 hover:underline">Edit</a>
                                    <form action="{{ route('members.destroy', $member) }}" method="POST" class="inline" onsubmit="return confirm('Delete this member?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">
                                    No members found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $members->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
