<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            Committee Roles
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 text-xs">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-4">

                   
            <a href="{{ route('committee-roles.create') }}"
              class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded mb-3 inline-block text-xs">
               + Add Committee Role
            </a>
       

            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-xs">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                    <tr>
                        <th class="px-4 py-2 text-left">#</th>
                        <th class="px-4 py-2 text-left">Role Name</th>
                        <th class="px-4 py-2 text-left">Description</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($roles as $role)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-4 py-2">{{ $loop->iteration + ($roles->currentPage() - 1) * $roles->perPage() }}</td>
                            <td class="px-4 py-2">{{ $role->role_name }}</td>
                            <td class="px-4 py-2">{{ $role->description }}</td>
                            <td class="px-4 py-2 space-x-2">
                                <a href="{{ route('committee-roles.edit', $role->role_id) }}"
                                   class="text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('committee-roles.destroy', $role->role_id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline"
                                            onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @if($roles->isEmpty())
                        <tr>
                            <td colspan="4" class="px-4 py-2 text-center text-gray-500 dark:text-gray-400">
                                No roles found.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <div class="mt-4">
                {{ $roles->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
