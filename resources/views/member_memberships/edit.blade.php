<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Edit Membership</h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <form method="POST" action="{{ route('member_memberships.update', $memberMembership) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block">Member</label>
                <select name="member_id" class="w-full border p-2 rounded">
                    @foreach($members as $member)
                        <option value="{{ $member->member_id }}" {{ $memberMembership->member_id == $member->member_id ? 'selected' : '' }}>
                            {{ $member->full_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block">Membership Type</label>
                <select name="type_id" class="w-full border p-2 rounded">
                    @foreach($membershipTypes as $type)
                        <option value="{{ $type->type_id }}" {{ $memberMembership->type_id == $type->type_id ? 'selected' : '' }}>
                            {{ $type->type_name }}
                        </option>
                    @endforeach
                </select>
            </div>

<div>
    <label class="block">Start Date</label>
    <input type="date" name="start_date" 
           value="{{ $memberMembership->start_date ? \Carbon\Carbon::parse($memberMembership->start_date)->format('Y-m-d') : '' }}" 
           class="w-full border p-2 rounded">
</div>

<div>
    <label class="block">End Date</label>
    <input type="date" name="end_date" 
           value="{{ $memberMembership->end_date ? \Carbon\Carbon::parse($memberMembership->end_date)->format('Y-m-d') : '' }}" 
           class="w-full border p-2 rounded">
</div>


            <div>
                <label><input type="checkbox" name="is_active" value="1" {{ $memberMembership->is_active ? 'checked' : '' }}> Active</label>
            </div>

                  <div class="flex justify-end space-x-2">
                    <a href="{{ route('family-members.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1.5 rounded text-xs">Cancel</a>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
        </form>
    </div>

</x-app-layout>
