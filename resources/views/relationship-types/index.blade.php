<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            Relationship Types
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 text-xs">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-4">
            <a href="{{ route('relationship-types.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded mb-3 inline-block text-xs">
               + Add Relationship Type
            </a>

                        <table class="min-w-full border border-gray-300 dark:border-gray-700 text-xs">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                    <tr>
                        <th class="p-2 text-left">#</th>
                        <th class="p-2 text-left">Name</th>
                        <th class="p-2 text-left">Description</th>
                        <th class="p-2 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($relationshipTypes as $type)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="p-2">{{ $loop->iteration }}</td>
                        <td class="p-2">{{ $type->name }}</td>
                        <td class="p-2">{{ $type->description ?? '-' }}</td>
                        <td class="p-2 text-right">
                            <a href="{{ route('relationship-types.edit', $type) }}" class="text-yellow-600 hover:underline">Edit</a>
                            <form action="{{ route('relationship-types.destroy', $type) }}" method="POST" class="inline" onsubmit="return confirm('Delete this relationship type?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center p-3 text-gray-500">No relationship types found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
</x-app-layout>
