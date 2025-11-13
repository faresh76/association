<table class="w-full text-xs border border-gray-200">
    <thead class="bg-gray-100">
        <tr>
            <th class="border p-2">#</th>
            <th class="border p-2">Membership Type</th>
            <th class="border p-2">Start Date</th>
            <th class="border p-2">End Date</th>
            <th class="border p-2">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($histories as $h)
            <tr>
                <td class="border p-2 text-center">{{ $loop->iteration }}</td>
                <td class="border p-2">{{ $h->membershipType->type_name ?? '-' }}</td>
                <td class="border p-2">{{ $h->start_date ? \Carbon\Carbon::parse($h->start_date)->format('d/m/Y') : '-' }}</td>
                <td class="border p-2">{{ $h->end_date ? \Carbon\Carbon::parse($h->end_date)->format('d/m/Y') : '-' }}</td>
                <td class="border p-2 text-center">
                    @php
                        $today = \Carbon\Carbon::today();
                        $endDate = $h->end_date ? \Carbon\Carbon::parse($h->end_date) : null;
                    @endphp

                    @if($endDate && $endDate->lt($today))
                        <span class="text-red-600 font-semibold">Expired</span>
                    @elseif($h->is_active)
                        <span class="text-green-600 font-semibold">Active</span>
                    @else
                        <span class="text-gray-500">Inactive</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center p-2 text-gray-500">No history found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
