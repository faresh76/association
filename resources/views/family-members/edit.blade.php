<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Family Member
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 text-xs">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-6">

            <form action="{{ route('family-members.update', $family_member) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- Member (readonly) -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">Member</label>
                        <input type="text" value="{{ $family_member->member->full_name ?? '-' }}"
                            class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs bg-gray-100 cursor-not-allowed" readonly>
                    </div>

                    <!-- Full Name -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">Family Member Name</label>
                        <input type="text" name="name" value="{{ old('name', $family_member->name) }}"
                            class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Relationship Type -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">Relationship Type</label>
                        <select name="relationship_type_id"
                            class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs">
                            <option value="">-- Select Relationship --</option>
                            @foreach ($relationshipTypes as $type)
                                <option value="{{ $type->id }}"
                                    {{ old('relationship_type_id', $family_member->relationship_type_id) == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('relationship_type_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- IC No -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">IC No</label>
                        <input type="text" name="ic_no" value="{{ old('ic_no', $family_member->ic_no) }}"
                            class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs">
                        @error('ic_no')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date of Birth -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">Date of Birth</label>
                        <input type="date" name="date_of_birth"
                            value="{{ old('date_of_birth', $family_member->date_of_birth ? \Carbon\Carbon::parse($family_member->date_of_birth)->format('Y-m-d') : '') }}"
                            class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs">
                        @error('date_of_birth')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Contact No -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">Contact No</label>
                        <input type="text" name="contact_no" value="{{ old('contact_no', $family_member->contact_no) }}"
                            class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs">
                        @error('contact_no')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', $family_member->email) }}"
                            class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Occupation -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">Occupation</label>
                        <input type="text" name="occupation" value="{{ old('occupation', $family_member->occupation) }}"
                            class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs">
                        @error('occupation')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Conditional Section for Child --}}
                @if ($family_member->relationship_type_id == 2)
                    <hr class="my-6 border-gray-400 dark:border-gray-600">
                    <h3 class="text-sm font-semibold mb-3 text-gray-700 dark:text-gray-200">Child Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ([
                            'child_no_of_sibling' => 'No Of Sibling',
                            'child_diagnose' => 'Diagnose',
                            'child_right_ear_hearing_level' => 'Right Ear Hearing Level',
                            'child_left_ear_hearing_level' => 'Left Ear Hearing Level',
                            'child_right_ear_hearing_tool' => 'Right Ear Hearing Tool',
                            'child_left_ear_hearing_tool' => 'Left Ear Hearing Tool',
                            'child_right_ear_hearing_tool_brand' => 'Right Ear Hearing Tool Brand',
                            'child_left_ear_hearing_tool_brand' => 'Left Ear Hearing Tool Brand',
                            'child_right_ear_hearing_tool_from' => 'Using Right Ear Hearing Tool Brand From',
                            'child_left_ear_hearing_tool_from' => 'Using Left Ear Hearing Tool Brand From',
                            'child_reference_hospital' => 'Reference Hospital',
                            'child_education_level' => 'Education Level',
                            'child_school_name' => 'School Name',
                            'child_oku_status' => 'OKU Status'
                        ] as $field => $label)
                            <div>
                                <label class="block text-gray-700 dark:text-gray-200 mb-1">{{ $label }}</label>
                                <textarea name="{{ $field }}" rows="3"
                                    class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs">{{ old($field, $family_member->$field) }}</textarea>
                                @error($field)
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                @endif

                <hr class="my-6 border-gray-400 dark:border-gray-600">

                <!-- Address -->
                <div class="mb-6">
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Address</label>
                    <textarea name="address" rows="3"
                        class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs">{{ old('address', $family_member->address) }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('family-members.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1.5 rounded text-xs">Cancel</a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs">Update</button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
