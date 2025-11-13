<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Add Family Member
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8 text-xs">
        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">

            <form action="{{ route('family-members.store') }}" method="POST" class="text-xs">
                @csrf

                <!-- Member Selection -->
                <div class="mb-4">
                    @if(isset($member_id))
                        <input type="hidden" name="member_id" value="{{ $member_id }}">
                        <p class="text-gray-700 dark:text-gray-200 text-xs">
                            Member: {{ $members->where('member_id', $member_id)->first()->full_name }}
                        </p>
                    @else
                        <label for="member_id" class="block text-gray-700 dark:text-gray-200 text-xs font-medium mb-1">
                            Member
                        </label>
                        <select name="member_id" id="member_id"
                            class="w-full px-3 py-2 border rounded text-xs dark:bg-gray-700 dark:text-gray-200" required>
                            <option value="">Select Member</option>
                            @foreach($members as $member)
                                <option value="{{ $member->member_id }}" {{ old('member_id') == $member->member_id ? 'selected' : '' }}>
                                    {{ $member->full_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('member_id')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    @endif
                </div>

                <!-- Family Member Name -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 dark:text-gray-200 text-xs font-medium mb-1">
                        Family Member Name
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                           class="w-full px-3 py-2 border rounded text-xs dark:bg-gray-700 dark:text-gray-200" required>
                    @error('name')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Relationship Dropdown -->
                <div class="mb-4">
                    <label for="relationship_type_id" class="block text-gray-700 dark:text-gray-200 text-xs font-medium mb-1">
                        Relationship
                    </label>
                    <select name="relationship_type_id" id="relationship_type_id"
                            class="w-full px-3 py-2 border rounded text-xs dark:bg-gray-700 dark:text-gray-200" required>
                        <option value="">Select Relationship</option>
                        @foreach($relationshipTypes as $type)
                            <option value="{{ $type->id }}" {{ old('relationship_type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('relationship_type_id')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- IC -->
                <div class="mb-4">
                    <label for="ic_no" class="block text-gray-700 dark:text-gray-200 text-xs font-medium mb-1">
                        IC No
                    </label>
                    <input type="text" name="ic_no" id="ic_no" value="{{ old('ic_no') }}"
                           class="w-full px-3 py-2 border rounded text-xs dark:bg-gray-700 dark:text-gray-200">
                </div>

                <!-- Date of Birth -->
                <div class="mb-4">
                    <label for="date_of_birth" class="block text-gray-700 dark:text-gray-200 text-xs font-medium mb-1">
                        Date of Birth
                    </label>
                    <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}"
                           class="w-full px-3 py-2 border rounded text-xs dark:bg-gray-700 dark:text-gray-200">
                </div>

                <!-- Contact Number -->
                <div class="mb-4">
                    <label for="contact_no" class="block text-gray-700 dark:text-gray-200 text-xs font-medium mb-1">
                        Contact Number
                    </label>
                    <input type="text" name="contact_no" id="contact_no" value="{{ old('contact_no') }}"
                           class="w-full px-3 py-2 border rounded text-xs dark:bg-gray-700 dark:text-gray-200">
                </div>

                <!-- Buttons -->
                <div class="flex justify-end mt-6 text-xs">
                    <a href="{{ route('family-members.index') }}" 
                       class="px-4 py-2 bg-gray-400 hover:bg-gray-500 rounded text-white mr-2">Cancel</a>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded text-white">Save</button>
                </div>

                <!-- Note -->
                <div class="mt-6 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-3 rounded text-xs">
                    <strong>Note:</strong> Please add only the basic information for now.  
                    You can update other details later in the <span class="font-semibold">Edit</span> menu.
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
