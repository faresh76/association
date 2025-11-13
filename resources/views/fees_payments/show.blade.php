<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
            💳 Payment Receipt
        </h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-2xl p-8 border border-gray-200 dark:border-gray-700">

            {{-- Header --}}
            <div class="flex justify-between items-center mb-6 border-b border-gray-200 dark:border-gray-700 pb-4">
                <div>
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Receipt #{{ $payment->payment_id }}</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        Generated on {{ \Carbon\Carbon::parse($payment->created_at)->format('d M Y, h:i A') }}
                    </p>
                </div>
                <a href="{{ route('fees_payments.index') }}" 
                   class="text-gray-600 dark:text-gray-300 hover:underline text-sm">← Back to Payments</a>
            </div>

            {{-- Member Info Card --}}
            <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg border border-gray-200 dark:border-gray-700 mb-6">
                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">👤 Member Information</h4>
                <div class="flex justify-between">
                    <div>
                        <p class="text-gray-800 dark:text-gray-100 font-medium">{{ $payment->member->full_name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Member ID: {{ $payment->member->member_id }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Email: {{ $payment->member->email ?? '-' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-500 dark:text-gray-400">Phone: {{ $payment->member->phone ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Payment Details Card --}}
            <div class="bg-white dark:bg-gray-900 p-4 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">💰 Payment Details</h4>
                <div class="grid grid-cols-2 gap-y-2 text-sm text-gray-700 dark:text-gray-300">
                    <div class="flex justify-between">
                        <span class="font-medium">Amount:</span>
                        <span class="font-semibold text-gray-900 dark:text-gray-100">RM {{ number_format($payment->amount, 2) }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="font-medium">Payment Date:</span>
                        <span>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y, h:i A') }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="font-medium">Payment Method:</span>
                        <span>{{ $payment->payment_method ?? '-' }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="font-medium">Reference No:</span>
                        <span>{{ $payment->reference_no ?? '-' }}</span>
                    </div>

                    @if($payment->remarks)
                        <div class="col-span-2 mt-2">
                            <span class="font-medium block">📝 Remarks:</span>
                            <p class="mt-1 text-gray-800 dark:text-gray-100">{{ $payment->remarks }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('fees_payments.print', $payment->payment_id) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow">
                    🖨️ Print Receipt
                </a>
                <a href="{{ route('fees_payments.edit', $payment->payment_id) }}" 
                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-lg shadow">
                    ✏️ Edit
                </a>
                <form action="{{ route('fees_payments.destroy', $payment->payment_id) }}" method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this payment?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg shadow">
                        🗑️ Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
