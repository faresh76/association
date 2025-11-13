<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            View Family Member
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 text-xs">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-4">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Member Info -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Member</label>
                    <input type="text" value="{{ $family_member->member->full_name ?? '-' }}" 
                        class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs bg-gray-100 cursor-not-allowed" readonly>
                </div>

                <!-- Full Name -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Family Member Name</label>
                    <input type="text" value="{{ $family_member->name }}" 
                        class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs bg-gray-100 cursor-not-allowed" readonly>
                </div>

                <!-- Relationship Type -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Relationship Type</label>
                    <input type="text" value="{{ $family_member->relationshipType->name ?? '-' }}" 
                        class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs bg-gray-100 cursor-not-allowed" readonly>
                </div>

                <!-- IC -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">IC No</label>
                    <input type="text" value="{{ $family_member->ic_no ?? '-' }}" 
                        class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs bg-gray-100 cursor-not-allowed" readonly>
                </div>

                <!-- Date of Birth -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Date of Birth</label>
                    <input type="text" 
                        value="{{ $family_member->date_of_birth ? \Carbon\Carbon::parse($family_member->date_of_birth)->format('d/m/Y') : '-' }}" 
                        class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs bg-gray-100 cursor-not-allowed" readonly>
                </div>

                <!-- Contact No -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Contact No</label>
                    <input type="text" value="{{ $family_member->contact_no ?? '-' }}" 
                        class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs bg-gray-100 cursor-not-allowed" readonly>
                </div>

                                <!-- Emel -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Email </label>
                    <input type="text" value="{{ $family_member->email?? '-' }}" 
                        class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs bg-gray-100 cursor-not-allowed" readonly>
                </div>

                <!-- Occupation -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Occupation</label>
                    <input type="text" value="{{ $family_member->occupation ?? '-' }}" 
                        class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs bg-gray-100 cursor-not-allowed" readonly>
                </div>

                {{-- Only show if relationship_type_id == 2 --}}
                @if ($family_member->relationship_type_id == 2)
                    <!-- No of sibling -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">No Of Sibling</label>
                        <input type="text" value="{{ $family_member->child_no_of_sibling ?? '-' }}" 
                            class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs bg-gray-100 cursor-not-allowed" readonly>
                    </div>

                    <!-- Diagnose -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">Diagnose</label>
                        <input type="text" value="{{ $family_member->child_diagnose ?? '-' }}" 
                            class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs bg-gray-100 cursor-not-allowed" readonly>
                    </div>

                    <!-- Right Ear Hearing Level -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">Right Ear Hearing Level</label>
                        <input type="text" value="{{ $family_member->child_right_ear_hearing_level ?? '-' }}" 
                            class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs bg-gray-100 cursor-not-allowed" readonly>
                    </div>

                    <!-- Left Ear Hearing Level -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">Left Ear Hearing Level</label>
                        <input type="text" value="{{ $family_member->child_left_ear_hearing_level ?? '-' }}" 
                            class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs bg-gray-100 cursor-not-allowed" readonly>
                    </div>

                    <!-- Right Ear Hearing Tool -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">Right Ear Hearing Tool</label>
                        <input type="text" value="{{ $family_member->child_right_ear_hearing_tool ?? '-' }}" 
                            class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs bg-gray-100 cursor-not-allowed" readonly>
                    </div>

                    <!-- Left Ear Hearing Tool -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">Left Ear Hearing Tool</label>
                        <input type="text" value="{{ $family_member->child_left_ear_hearing_tool ?? '-' }}" 
                            class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs bg-gray-100 cursor-not-allowed" readonly>
                    </div>

                    <!-- Right Ear Hearing Brand -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">Right Ear Hearing Brand</label>
                        <input type="text" value="{{ $family_member->child_right_ear_hearing_tool_brand ?? '-' }}" 
                            class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs bg-gray-100 cursor-not-allowed" readonly>
                    </div>

                    <!-- Left Ear Hearing Brand -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">Left Ear Hearing Brand</label>
                        <input type="text" value="{{ $family_member->child_left_ear_hearing_tool_brand ?? '-' }}" 
                            class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs bg-gray-100 cursor-not-allowed" readonly>
                    </div>

                    <!-- Using Right Ear Hearing From -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">Using Right Ear Hearing From</label>
                        <input type="text" value="{{ $family_member->child_right_ear_hearing_tool_from ?? '-' }}" 
                            class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs bg-gray-100 cursor-not-allowed" readonly>
                    </div>

                    <!-- Using Left Ear Hearing From -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">Using Left Ear Hearing From</label>
                        <input type="text" value="{{ $family_member->child_left_ear_hearing_tool_from ?? '-' }}" 
                            class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs bg-gray-100 cursor-not-allowed" readonly>
                    </div>

                    <!-- Reference Hospital -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">Reference Hospital</label>
                        <input type="text" value="{{ $family_member->child_reference_hospital ?? '-' }}" 
                            class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs bg-gray-100 cursor-not-allowed" readonly>
                    </div>

                    <!-- School Name -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">School Name</label>
                        <input type="text" value="{{ $family_member->child_school_name ?? '-' }}" 
                            class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs bg-gray-100 cursor-not-allowed" readonly>
                    </div>

                    <!-- Education Level -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">Level Of Education</label>
                        <input type="text" value="{{ $family_member->child_education_level ?? '-' }}" 
                            class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs bg-gray-100 cursor-not-allowed" readonly>
                    </div>

                    <!-- OKU Status -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">OKU Status</label>
                        <input type="text" value="{{ $family_member->child_oku_status ?? '-' }}" 
                            class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs bg-gray-100 cursor-not-allowed" readonly>
                    </div>
                @endif

                <!-- Created At -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Created At</label>
                    <input type="text" value="{{ optional($family_member->created_at)->format('d/m/Y H:i') ?? '-' }}" 
                        class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs bg-gray-100 cursor-not-allowed" readonly>
                </div>

                <!-- Updated At -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Updated At</label>
                    <input type="text" value="{{ optional($family_member->updated_at)->format('d/m/Y H:i') ?? '-' }}" 
                        class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs bg-gray-100 cursor-not-allowed" readonly>
                </div>
            </div>

                     <!-- Address -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">Address</label>
                        <input type="text" value="{{ $family_member->address ?? '-' }}" 
                            class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs bg-gray-100 cursor-not-allowed" readonly>
                    </div>

                    <!-- Back and Print Buttons -->
<div class="flex justify-end mt-4 space-x-2">
    <a href="{{ route('family-members.index') }}" 
       class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1.5 rounded text-xs">
       Back
    </a>

        <a href="{{ route('family-members.print2', $family_member->family_id) }}" 
           target="_blank"
           class="bg-blue-600 hover:bg-green-700 text-white px-3 py-1.5 rounded text-xs inline-block">
           🖨 Print PDF
        </a>


</div>

        </div>
    </div>
</x-app-layout>
