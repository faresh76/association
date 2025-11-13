<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Member
        </h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto sm:px-6 lg:px-8 text-xs">

    
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">

            <form action="{{ route('members.update', $member->member_id) }}" method="POST" class="text-xs">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium mb-1 text-xs">Member No</label>
                        <input type="text" name="member_no"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-md p-2 text-xs focus:ring-blue-500 focus:border-blue-500"
                            value="{{ old('member_no', $member->member_no) }}">
                    </div>

                    <div>
                        <label class="block font-medium mb-1 text-xs">Full Name</label>
                        <input type="text" name="full_name"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-md p-2 text-xs focus:ring-blue-500 focus:border-blue-500"
                            value="{{ old('full_name', $member->full_name) }}">
                    </div>

                    <div>
                        <label class="block font-medium mb-1 text-xs">IC No</label>
                        <input type="text" name="ic_no"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-md p-2 text-xs focus:ring-blue-500 focus:border-blue-500"
                            value="{{ old('ic_no', $member->ic_no) }}">
                    </div>

                    <div>
                        <label class="block font-medium mb-1 text-xs">Gender</label>
                        <select name="gender"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-md p-2 text-xs focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Select --</option>
                            <option value="Male" {{ old('gender', $member->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender', $member->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-medium mb-1 text-xs">Date of Birth</label>
                        <input type="date" name="date_of_birth"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-md p-2 text-xs focus:ring-blue-500 focus:border-blue-500"
                            value="{{ old('date_of_birth', optional($member->date_of_birth)->format('Y-m-d')) }}">
                    </div>

                    <div>
                        <label class="block font-medium mb-1 text-xs">Phone</label>
                        <input type="text" name="phone"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-md p-2 text-xs focus:ring-blue-500 focus:border-blue-500"
                            value="{{ old('phone', $member->phone) }}">
                    </div>

                    <div>
                        <label class="block font-medium mb-1 text-xs">Email</label>
                        <input type="email" name="email"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-md p-2 text-xs focus:ring-blue-500 focus:border-blue-500"
                            value="{{ old('email', $member->email) }}">
                    </div>

                    <div>
                        <label class="block font-medium mb-1 text-xs">Occupation</label>
                        <input type="text" name="occupation"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-md p-2 text-xs focus:ring-blue-500 focus:border-blue-500"
                            value="{{ old('occupation', $member->occupation) }}">
                    </div>

                    <div>
                        <label class="block font-medium mb-1 text-xs">Join Date</label>
                        <input type="date" name="join_date"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-md p-2 text-xs focus:ring-blue-500 focus:border-blue-500"
                            value="{{ old('join_date', optional($member->join_date)->format('Y-m-d')) }}">
                    </div>

                    <div>
                        <label class="block font-medium mb-1 text-xs">Status</label>
                        <select name="status"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-md p-2 text-xs focus:ring-blue-500 focus:border-blue-500">
                            <option value="Active" {{ old('status', $member->status) == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ old('status', $member->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="Suspended" {{ old('status', $member->status) == 'Suspended' ? 'selected' : '' }}>Suspended</option>
                            <option value="Deceased" {{ old('status', $member->status) == 'Deceased' ? 'selected' : '' }}>Deceased</option>
                        </select>
                    </div>

                    <div class="col-span-2">
                        <label class="block font-medium mb-1 text-xs">Address</label>
                        <textarea name="address" rows="3"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-md p-2 text-xs focus:ring-blue-500 focus:border-blue-500">{{ old('address', $member->address) }}</textarea>
                    </div>
                </div>

                <div class="mt-6 flex justify-between items-center text-xs">
                    <a href="{{ route('members.index') }}" class="text-gray-600 hover:underline">
                        ← Back to list
                    </a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded text-xs">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
