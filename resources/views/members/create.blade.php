<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">Add Member</h2></x-slot>

    <div class="py-6 max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
            <form action="{{ route('members.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-2 gap-4">

                
                    <div>
                        <label class="block font-medium">Member No (Auto)</label>
                        <input type="text" name="member_no" class="w-full border rounded p-2 bg-gray-100" value="(Auto Generated)" readonly>
                    </div>


                    <div>
                        <label class="block font-medium">Full Name</label>
                        <input type="text" name="full_name" class="w-full border rounded p-2" value="{{ old('full_name') }}">
                    </div>

                    <div>
                        <label class="block font-medium">IC No</label>
                        <input type="text" name="ic_no" class="w-full border rounded p-2" value="{{ old('ic_no') }}">
                    </div>

                    <div>
                        <label class="block font-medium">Gender</label>
                        <select name="gender" class="w-full border rounded p-2">
                            <option value="">-- Select --</option>
                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-medium">Date of Birth</label>
                        <input type="date" name="date_of_birth" class="w-full border rounded p-2" value="{{ old('date_of_birth') }}">
                    </div>

                    <div>
                        <label class="block font-medium">Phone</label>
                        <input type="text" name="phone" class="w-full border rounded p-2" value="{{ old('phone') }}">
                    </div>

                    <div>
                        <label class="block font-medium">Email</label>
                        <input type="email" name="email" class="w-full border rounded p-2" value="{{ old('email') }}">
                    </div>

                    <div>
                        <label class="block font-medium">Occupation</label>
                        <input type="text" name="occupation" class="w-full border rounded p-2" value="{{ old('occupation') }}">
                    </div>

                    <div>
                        <label class="block font-medium">Join Date</label>
                        <input type="date" name="join_date" class="w-full border rounded p-2" value="{{ old('join_date') }}">
                    </div>

                    <div>
                        <label class="block font-medium">Status</label>
                        <select name="status" class="w-full border rounded p-2">
                            <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="col-span-2">
                        <label class="block font-medium">Address</label>
                        <textarea name="address" rows="3" class="w-full border rounded p-2">{{ old('address') }}</textarea>
                    </div>
                </div>

                <div class="mt-4 text-right">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Save</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
