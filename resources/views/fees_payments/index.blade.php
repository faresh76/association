<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            💰 Fee Payments
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto xs:px-6 lg:px-8">

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-4 text-green-700 bg-green-100 border border-green-300 px-4 py-2 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">

            <!-- Top Controls: Search + Add Payment -->
            <div class="flex justify-between items-center mb-4">
                
                <a href="{{ route('fees_payments.create') }}" 
                   class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-xs">
                    + Add Payment
                </a>
<div class="flex items-center space-x-2">
                <a href="{{ route('fees_payments.printAll', ['search' => request('search')]) }}" 
   target="_blank"
   class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-green-700 text-xs">
   🖨️ Print PDF
</a>

                <form method="GET" action="{{ route('fees_payments.index') }}" class="flex items-center space-x-2">
                    <input type="text" name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Search member..." 
                           class="px-3 py-1 border rounded text-xs">
                    <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700">
                        Search
                    </button>
                    <a href="{{ route('fees_payments.index') }}" 
                       class="bg-gray-300 text-gray-700 px-3 py-1 rounded text-xs hover:bg-gray-400">
                        Clear
                    </a>
                </form>
            </div>
               </div>

            <h3 class="font-semibold text-gray-800 dark:text-gray-100">Payments by Member</h3>

            <div class="overflow-x-auto">
                @php
                    $memberCounter = ($groupedPayments->currentPage() - 1) * $groupedPayments->perPage() + 1;
                @endphp

                @foreach($groupedPayments as $memberId => $memberPayments)
                    {{-- Member Header Table --}}
                    <table class="table-auto text-left text-xs mt-2 border border-gray-300">
                        <tbody>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-1 py-0.5 border border-gray-300 text-center w-8">
                                   {{ $memberCounter }}
                                </td>
                                <td class="px-1 py-0.5 border border-gray-300 w-48">
                                   {{ $memberPayments->first()->member->full_name ?? 'Unknown Member' }}
                                </td>
                                <td class="px-1 py-0.5 border border-gray-300 w-24">
                                    {{ $memberPayments->first()->member->member_no ?? '-' }}
                                </td>
                                <td class="px-1 py-0.5 border border-gray-300 w-24">
                                    {{ $memberPayments->first()->member->phone ?? '-' }}
                                </td>
                                <td class="px-1 py-0.5 border border-gray-300 w-24">
                                    {{ $memberPayments->first()->member->email ?? '-' }}
                                </td>
                                <td class="px-1 py-0.5 border border-gray-300 w-24">
                                    <a href="{{ route('fees_payments.create', ['member_id' => $memberPayments->first()->member->member_id]) }}" 
                                       class="text-blue-600 hover:underline">
                                       + Add Payment
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    {{-- Payments Table --}}
                    <table class="min-w-full text-xs mt-1 border border-gray-300">
                        <thead class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                            <tr>
                                <th class="p-2 text-left border border-gray-300 w-24">Amount</th>
                                <th class="p-2 text-left border border-gray-300 w-24">Method</th>
                                <th class="p-2 text-left border border-gray-300 w-28">Date</th>
                                <th class="p-2 text-left border border-gray-300 w-28">Ref No</th>
                                <th class="p-2 text-left border border-gray-300 w-48">Remarks</th>
                                <th class="p-2 text-right border border-gray-300 w-36">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($memberPayments as $p)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="p-2 border border-gray-300 w-24">RM {{ number_format($p->amount, 2) }}</td>
                                    <td class="p-2 border border-gray-300 w-24">{{ $p->payment_method }}</td>
                                    <td class="p-2 border border-gray-300 w-28">{{ \Carbon\Carbon::parse($p->payment_date)->format('d M Y') }}</td>
                                    <td class="p-2 border border-gray-300 w-28">{{ $p->reference_no ?? '-' }}</td>
                                    <td class="p-2 border border-gray-300 w-48 text-gray-600 dark:text-gray-400">{{ $p->remarks ?? '-' }}</td>
                                    <td class="p-2 border border-gray-300 w-36 text-right space-x-2">
                                        <a href="{{ route('fees_payments.show', $p->payment_id) }}" 
                                           class="text-blue-600 hover:underline">Show</a>
                                        <a href="{{ route('fees_payments.edit', $p->payment_id) }}" 
                                           class="text-green-600 hover:underline">Edit</a>
                                        <form action="{{ route('fees_payments.destroy', $p->payment_id) }}" 
                                              method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" 
                                                    onclick="return confirm('Delete this payment?')" 
                                                    class="text-red-600 hover:underline">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @php $memberCounter++; @endphp
                @endforeach
            </div>

            {{-- Pagination Links --}}
            <div class="mt-4">
                {{ $groupedPayments->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
