<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Add Membership</h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <form method="POST" action="{{ route('member_memberships.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block">Member</label>
                <select name="member_id" class="w-full border p-2 rounded">
                    @foreach($members as $member)
                        <option value="{{ $member->member_id }}">{{ $member->full_name }}</option>
                    @endforeach
                </select>
            </div>

   <div>
    <label class="block">Membership Type</label>
    <select id="type_id" name="type_id" class="w-full border p-2 rounded">
        @foreach($membershipTypes as $type)
            <option value="{{ $type->type_id }}">{{ $type->type_name }}</option>
        @endforeach
    </select>
</div>

<div id="startDateWrapper">
    <label class="block">Start Date</label>
    <input type="date" id="start_date" name="start_date" class="w-full border p-2 rounded">
</div>

<div id="endDateWrapper">
    <label class="block">End Date</label>
    <input type="date" id="end_date" name="end_date" class="w-full border p-2 rounded">
</div>


            <div>
                <label><input type="checkbox" name="is_active" value="1" checked> Active</label>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
        </form>
    </div>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeSelect = document.getElementById('type_id');
    const startDateWrapper = document.getElementById('startDateWrapper');
    const endDateWrapper = document.getElementById('endDateWrapper');
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');

    function toggleDateFields() {
        const selectedText = typeSelect.options[typeSelect.selectedIndex].text;
        if (selectedText.toLowerCase() === 'lifetime') {
            startDateWrapper.style.display = 'none';
            endDateWrapper.style.display = 'none';
            startDateInput.value = '';
            endDateInput.value = '';
        } else {
            startDateWrapper.style.display = 'block';
            endDateWrapper.style.display = 'block';
        }
    }

    // Initial check
    toggleDateFields();

    // On change
    typeSelect.addEventListener('change', toggleDateFields);

    // Auto-calculate end date for non-lifetime types
    startDateInput.addEventListener('change', function () {
        if (this.value && typeSelect.options[typeSelect.selectedIndex].text.toLowerCase() !== 'lifetime') {
            const startDate = new Date(this.value);
            const endDate = new Date(startDate);
            endDate.setFullYear(endDate.getFullYear() + 1);
            endDate.setDate(endDate.getDate() - 1);

            const yyyy = endDate.getFullYear();
            const mm = String(endDate.getMonth() + 1).padStart(2, '0');
            const dd = String(endDate.getDate()).padStart(2, '0');
            endDateInput.value = `${yyyy}-${mm}-${dd}`;
        }
    });
});
</script>