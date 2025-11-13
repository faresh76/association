<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Membership Assignments</h2>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-4">
        <div class="py-6 max-w-7xl mx-auto">

            <!-- Top Controls -->
 <div class="flex justify-between items-center mb-4">
    <!-- Left: Add Button -->
    <a href="{{ route('member_memberships.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
        + Add Membership
    </a>

    
            <!-- 🖨 Print PDF button -->
        <div class="flex items-center space-x-2">

         <a href="{{ route('member-membership.printExcelAll') }}" 
           target="_blank"
           class="bg-blue-600 hover:bg-green-700 text-white px-3 py-1.5 rounded text-xs inline-block">
           🖨  All Excel
        </a>


        <a href="{{ route('member_memberships.print', [
            'search' => request('search'),
            'sort_by' => request('sort_by'),
            'sort_direction' => request('sort_direction')
        ]) }}" 
           target="_blank"
           class="bg-blue-600 hover:bg-red-700 text-white px-4 py-2 rounded text-xs ">
            🖨 Print PDF
        </a>
    <!-- Right: Search + Clear + Print -->
    <form method="GET" action="{{ route('member_memberships.index') }}" class="flex space-x-2 items-center">
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
        <a href="{{ route('member_memberships.index') }}" 
           class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded text-xs">
            Clear
        </a>


    </form>
</div>
</div>
            <!-- Data Table -->
            <div class="overflow-x-auto">
                <table class="mt-4 w-full border border-gray-200 text-xs">
    <thead class="bg-gray-100 text-gray-700">
        <tr>
            <th class="border p-2">#</th>

            {{-- 🔹 Sortable Member --}}
            <th class="border p-2 text-left">
                <a href="{{ route('member_memberships.index', [
                    'search' => request('search'),
                    'sort_by' => 'members.full_name',
                    'sort_direction' => (request('sort_by') === 'members.full_name' && request('sort_direction') === 'asc') ? 'desc' : 'asc'
                ]) }}" class="hover:underline">
                    Member
                    @if(request('sort_by') === 'members.full_name')
                        {!! request('sort_direction') === 'asc' ? '&#9650;' : '&#9660;' !!}
                    @endif
                </a>
            </th>

            {{-- 🔹 Sortable Membership Type --}}
            <th class="border p-2 text-left">
                <a href="{{ route('member_memberships.index', [
                    'search' => request('search'),
                    'sort_by' => 'membership_types.type_name',
                    'sort_direction' => (request('sort_by') === 'membership_types.type_name' && request('sort_direction') === 'asc') ? 'desc' : 'asc'
                ]) }}" class="hover:underline">
                    Membership Type
                    @if(request('sort_by') === 'membership_types.type_name')
                        {!! request('sort_direction') === 'asc' ? '&#9650;' : '&#9660;' !!}
                    @endif
                </a>
            </th>

            <th class="border p-2 text-left">Start Date</th>
            <th class="border p-2 text-left">End Date</th>

            {{-- 🔹 Sortable Status --}}
            <th class="border p-2 text-center">
                <a href="{{ route('member_memberships.index', [
                    'search' => request('search'),
                    'sort_by' => 'status',
                    'sort_direction' => (request('sort_by') === 'status' && request('sort_direction') === 'asc') ? 'desc' : 'asc'
                ]) }}" class="hover:underline">
                    Status
                    @if(request('sort_by') === 'status')
                        {!! request('sort_direction') === 'asc' ? '&#9650;' : '&#9660;' !!}
                    @endif
                </a>
            </th>

            <th class="border p-2 text-left">Renew No</th>

            <th class="border p-2 text-center">Action</th>
        </tr>
    </thead>

   <tbody>
    @forelse($memberMemberships as $m)
        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
            <td class="border p-2 text-center">
                {{ $loop->iteration + ($memberMemberships->currentPage() - 1) * $memberMemberships->perPage() }}
            </td>

            <td class="border p-2">{{ $m->member->full_name ?? 'N/A' }}</td>
            <td class="border p-2">{{ $m->membershipType->type_name ?? 'N/A' }}</td>

            <td class="border p-2">
                {{ $m->start_date ? \Carbon\Carbon::parse($m->start_date)->format('d/m/Y') : '-' }}
            </td>
            <td class="border p-2">
                {{ $m->end_date ? \Carbon\Carbon::parse($m->end_date)->format('d/m/Y') : '-' }}
            </td>

            {{-- 🔹 Status --}}
            <td class="border p-2 text-center">
                @php
                    $today = \Carbon\Carbon::today();
                    $endDate = $m->end_date ? \Carbon\Carbon::parse($m->end_date) : null;
                    $isExpired = $endDate && $endDate->lt($today);
                @endphp

                @if($isExpired)
                    <span class="text-red-600 font-semibold blink">Expired</span>
                @elseif($m->is_active)
                    <span class="text-green-600 font-semibold">Active</span>
                @else
                    <span class="text-gray-500">Inactive</span>
                @endif
            </td>

            <td class="border p-2 text-center">
            <a href="javascript:void(0)" 
            onclick="showHistory({{ $m->member_id }}, {{ $m->renew_no ?? 0 }})" 
            class="text-blue-600 hover:underline">
                {{ $m->renew_no ?? '0' }}
            </a>
         </td>

 {{-- 🔹 Actions --}}
<td class="border p-2 text-center space-x-2">

    {{-- Only show Renew link if expired --}}
    @if($isExpired)
        <form action="{{ route('member_memberships.renew', $m->member_id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to renew this membership?')">
            @csrf
            <input type="hidden" name="type_id" value="{{ $m->type_id }}">
            <input type="hidden" name="start_date" value="{{ now()->format('Y-m-d') }}">
            <button type="submit" class="inline text-green-700 font-semibold hover:bg-green-100 rounded px-2 py-0.5 text-xs blink">
                Renew
            </button>
        </form>
    @endif

    <a href="{{ route('member_memberships.edit', $m) }}" class="inline text-blue-600 hover:underline text-xs px-1">
        Edit
    </a>

    <form action="{{ route('member_memberships.destroy', $m) }}" method="POST" class="inline">
        @csrf @method('DELETE')
        <button onclick="return confirm('Are you sure?')" class="inline text-red-600 hover:underline text-xs px-1">
            Delete
        </button>
    </form>

</td>

<style>
@keyframes blink { 
    50% { opacity: 0; } 
}
.blink { 
    animation: blink 1s step-start infinite; 
}
</style>




        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center p-4 text-gray-500">No memberships found.</td>
        </tr>
    @endforelse
</tbody>

</table>

<style>
@keyframes blink { 50% { opacity: 0; } }
.blink { animation: blink 1s step-start infinite; }
</style>
            </div>

            <!-- Pagination -->
            <div class="mt-4 text-xs" >
                {{ $memberMemberships->links() }}
            </div>
        </div>
    </div>
</x-app-layout>


<script>
function showHistory(memberId, renewNo) {
    // Create a unique modal id per member
    const modalId = `historyModal-${memberId}`;

    // If modal already exists, just show it
    if (document.getElementById(modalId)) {
        document.getElementById(modalId).classList.remove('hidden');
        return;
    }

    // Create modal container
    const modal = document.createElement('div');
    modal.id = modalId;
    modal.className = "fixed z-50 w-96 max-h-[80vh] overflow-y-auto bg-white dark:bg-gray-800 rounded shadow-lg";
    modal.style.top = '100px';
    modal.style.left = '30%';
    modal.style.position = 'absolute';
    modal.style.cursor = 'move';
    modal.innerHTML = `
        <div id="header-${memberId}" class="flex justify-between items-center bg-gray-200 dark:bg-gray-700 p-2 rounded-t">
            <h3 class="text-lg font-semibold">Membership History - Renew #${renewNo}</h3>
            <button onclick="document.getElementById('${modalId}').remove()" class="text-red-500 font-bold">&times;</button>
        </div>
        <div id="content-${memberId}" class="p-4 text-center text-gray-500">Loading...</div>
    `;
    document.body.appendChild(modal);

    const content = document.getElementById(`content-${memberId}`);

    // Fetch history
    fetch(`/member-memberships/${memberId}/history`)
        .then(response => response.text())
        .then(html => {
            content.innerHTML = html;
        })
        .catch(err => {
            content.innerHTML = '<p class="text-red-500 text-center">Failed to load history.</p>';
        });

    // Make draggable
    const header = document.getElementById(`header-${memberId}`);
    let isDragging = false, offsetX = 0, offsetY = 0;
    header.addEventListener('mousedown', (e) => {
        isDragging = true;
        offsetX = e.clientX - modal.offsetLeft;
        offsetY = e.clientY - modal.offsetTop;
    });
    document.addEventListener('mousemove', (e) => {
        if (isDragging) {
            modal.style.left = (e.clientX - offsetX) + 'px';
            modal.style.top = (e.clientY - offsetY) + 'px';
        }
    });
    document.addEventListener('mouseup', () => { isDragging = false; });
}
</script>


<!-- Membership History Modal -->
<div id="historyModal" class="fixed hidden z-50 w-96 max-h-[80vh] overflow-y-auto bg-white dark:bg-gray-800 rounded shadow-lg"
     style="top: 100px; left: 30%; position: absolute; cursor: move;">
    <div id="historyHeader" class="flex justify-between items-center bg-gray-200 dark:bg-gray-700 p-2 rounded-t">
        <h3 class="text-lg font-semibold">Membership History</h3>
        <button onclick="closeHistory()" class="text-red-500 font-bold">&times;</button>
    </div>
    <div id="historyContent" class="p-4">
        <p class="text-center text-gray-500">Loading...</p>
    </div>
</div>
