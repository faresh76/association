<div class="grid grid-cols-2 gap-4">
    <div>
        <x-input-label for="type_name" :value="__('Type Name')" />
        <x-text-input id="type_name" name="type_name" type="text"
            class="mt-1 block w-full"
            value="{{ old('type_name', $membershipType->type_name ?? '') }}" required />
        <x-input-error :messages="$errors->get('type_name')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="annual_fee" :value="__('Annual Fee')" />
        <x-text-input id="annual_fee" name="annual_fee" type="number" step="0.01"
            class="mt-1 block w-full"
            value="{{ old('annual_fee', $membershipType->annual_fee ?? '') }}" />
        <x-input-error :messages="$errors->get('annual_fee')" class="mt-2" />
    </div>

    <div class="col-span-2">
        <x-input-label for="description" :value="__('Description')" />
        <textarea id="description" name="description"
            class="mt-1 block w-full border rounded p-2"
            rows="3">{{ old('description', $membershipType->description ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>
</div>

<div class="mt-4 text-right">
        <a href="{{ route('membership-types.index') }}" class="px-4 py-2 bg-gray-300 dark:bg-gray-700 rounded hover:bg-gray-400 dark:hover:bg-gray-600">
        Back
    </a>
    <x-primary-button>
        {{ $buttonText }}
    </x-primary-button>
</div>
