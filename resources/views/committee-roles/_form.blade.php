<div class="mb-4">
    <x-input-label for="role_name" :value="__('Role Name')" />
    <x-text-input id="role_name" name="role_name" type="text" class="mt-1 block w-full"
                  :value="$committeeRole->role_name ?? old('role_name')" required />
    <x-input-error :messages="$errors->get('role_name')" class="mt-2" />
</div>

<div class="mb-4">
    <x-input-label for="description" :value="__('Description')" />
    <textarea id="description" name="description" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-gray-900 dark:text-gray-100"
              rows="3">{{ $committeeRole->description ?? old('description') }}</textarea>
    <x-input-error :messages="$errors->get('description')" class="mt-2" />
</div>

<div class="flex justify-end space-x-2">
    <a href="{{ route('committee-roles.index') }}" class="px-4 py-2 bg-gray-300 dark:bg-gray-700 rounded hover:bg-gray-400 dark:hover:bg-gray-600">
        Back
    </a>
    <x-primary-button>
        {{ $buttonText }}
    </x-primary-button>
</div>
