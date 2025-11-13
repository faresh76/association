<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            ✏️ Edit Fee Payment
        </h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
            <form action="{{ route('fees_payments.update', $payment->payment_id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Member --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Member</label>
                    <select name="member_id" required
                            class="w-full border-gray-300 rounded dark:bg-gray-700 dark:text-gray-100">
                        <option value="">Select member...</option>
                        @foreach($members as $m)
                            <option value="{{ $m->member_id }}" {{ $m->member_id == $payment->member_id ? 'selected' : '' }}>
                                {{ $m->full_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('member_id') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

                {{-- Amount and Payment Date --}}
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Amount (RM)</label>
                        <input type="number" step="0.01" name="amount" value="{{ old('amount', $payment->amount) }}"
                               class="w-full border-gray-300 rounded dark:bg-gray-700 dark:text-gray-100" required>
                        @error('amount') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Payment Date</label>
                        <input type="datetime-local" name="payment_date"
                               value="{{ old('payment_date', \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d\TH:i')) }}"
                               class="w-full border-gray-300 rounded dark:bg-gray-700 dark:text-gray-100" required>
                        @error('payment_date') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Payment Method --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Payment Method</label>
                    <select name="payment_method" class="w-full border-gray-300 rounded dark:bg-gray-700 dark:text-gray-100" required>
                        <option value="Cash" {{ $payment->payment_method == 'Cash' ? 'selected' : '' }}>Cash</option>
                        <option value="Online" {{ $payment->payment_method == 'Online' ? 'selected' : '' }}>Online</option>
                        <option value="Bank Transfer" {{ $payment->payment_method == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                    </select>
                </div>

                {{-- Reference No & Remarks --}}
                <div class="grid grid-cols-2 gap-4 mb-4">
                   <!--
                <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reference No</label>
                        <input type="text" name="reference_no" 
                               value="{{ old('reference_no', $payment->reference_no) }}"
                               class="w-full border-gray-300 rounded dark:bg-gray-700 dark:text-gray-100">
                    </div>-->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Remarks</label>
                        <input type="text" name="remarks" 
                               value="{{ old('remarks', $payment->remarks) }}"
                               class="w-full border-gray-300 rounded dark:bg-gray-700 dark:text-gray-100">
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="flex justify-end">
                    <a href="{{ route('fees_payments.index') }}" 
                       class="text-gray-600 hover:underline mr-4">← Back</a>
                    <button type="submit" 
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        💾 Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
