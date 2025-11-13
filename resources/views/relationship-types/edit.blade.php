<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Relationship Type
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 text-xs">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-4">

                            <form action="{{ $relationshipType->exists ? route('relationship-types.update', $relationshipType) : route('relationship-types.store') }}" method="POST">
                    @csrf
                    @if($relationshipType->exists)
                        @method('PUT')
                    @endif

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">Name</label>
                        <input type="text" name="name" value="{{ old('name', $relationshipType->name) }}" 
                            class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">Description</label>
                        <input type="text" name="description" value="{{ old('description', $relationshipType->description) }}" 
                            class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded text-xs">
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('relationship-types.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1.5 rounded text-xs">Cancel</a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs">
                            {{ $relationshipType->exists ? 'Update' : 'Add' }}
                        </button>
                    </div>
                </form>


        </div>
    </div>
</x-app-layout>
