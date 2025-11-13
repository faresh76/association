<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            Family Members
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 text-xs">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-4">
 <div class="flex justify-between items-center mb-4">
    <!-- Left side: Add Family Member -->
    <a href="{{ route('family-members.create') }}" 
       class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs inline-block">
       + Add Family Member
    </a>

    <!-- Right side: Print PDF + Search form -->
    <div class="flex items-center space-x-2">


        <a href="{{ route('family-members.printExcelAll') }}" 
           target="_blank"
           class="bg-blue-600 hover:bg-green-700 text-white px-3 py-1.5 rounded text-xs inline-block">
           🖨  All Excel
        </a>



        <!-- Print PDF -->
        <a href="{{ route('family-members.pdf', request()->all()) }}" 
           target="_blank"
           class="bg-blue-600 hover:bg-green-700 text-white px-3 py-1.5 rounded text-xs inline-block">
           🖨 Print PDF
        </a>

        <!-- Search Form -->
        <form method="GET" action="{{ route('family-members.index') }}" class="flex space-x-2">
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}" 
                placeholder="Search member name or family member" 
                class="px-3 py-2 border rounded text-xs"
            >
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-xs">
                Search
            </button>
            <a href="{{ route('family-members.index') }}" 
               class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded text-xs">
                Clear
            </a>
        </form>
    </div>
</div>


    
            <div class="overflow-x-auto">
                @forelse ($members as $member)

<table class="table-auto text-left text-xs mt-2 border border-gray-300">

    <tbody>

        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
            <td class="px-2 py-1 border border-gray-300">
                {{ $loop->iteration + ($members->currentPage() - 1) * $members->perPage() }}
            </td>
            <td class="px-2 py-1 border border-gray-300">
                {{ $member->full_name }}
            </td>
            <td class="px-2 py-1 border border-gray-300">
                {{ $member->member_no }}
            </td>
            <td class="px-2 py-1 border border-gray-300">
                <a href="{{ route('family-members.create', ['member_id' => $member->member_id]) }}" 
                   class="text-blue-600 hover:underline">
                   + Add Family
                </a>
            </td>
        </tr>
   
    </tbody>
</table>

            
                    <table class="min-w-full border border-gray-300 dark:border-gray-700 text-xs">
    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
        <tr>
            <th class="p-2 text-left w-8">#</th>
            <th class="p-2 text-left w-48">Family Member Name</th>
            <th class="p-2 text-left w-32">Relationship</th>
            <th class="p-2 text-left w-28">Date of Birth</th>
            <th class="p-2 text-left w-32">Contact No</th>
            <th class="p-2 text-right w-28">Actions</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
        @forelse ($member->familyMembers as $family)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                <td class="p-2">{{ $loop->iteration }}</td>
                <td class="p-2">{{ $family->name }}</td>
                <td class="p-2">{{ $family->relationship ?? '-' }}</td>
                <td class="p-2">
                {{ $family->date_of_birth ? \Carbon\Carbon::parse($family->date_of_birth)->format('d/m/Y') : '-' }}
                </td>

                <td class="p-2">{{ $family->contact_no ?? '-' }}</td>
                <td class="p-2 text-right">
                    <div class="flex justify-end items-center space-x-1">
                        <a href="{{ route('family-members.show', $family) }}"  class="text-blue-600 hover:underline">View</a>
                        <a href="{{ route('family-members.edit', $family) }}" class="text-yellow-600 hover:underline">Edit</a>
                        <span class="text-gray-400">|</span>
                        <form action="{{ route('family-members.destroy', $family) }}" 
                              method="POST" 
                              class="inline"
                              onsubmit="return confirm('Delete this family member?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center p-3 text-gray-500">
                    No family members found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

                @empty
                    <p class="text-gray-500">No members found.</p>
                @endforelse
            </div>

                        <div class="mt-4">
                {{ $members->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
