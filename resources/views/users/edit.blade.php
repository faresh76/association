<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            ✏️ Edit User
        </h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded border border-red-300">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <input type="text" name="name" value="{{ $user->name }}" required
                       class="w-full px-3 py-2 border rounded text-sm dark:bg-gray-700 dark:text-gray-100">
                <input type="email" name="email" value="{{ $user->email }}" required
                       class="w-full px-3 py-2 border rounded text-sm dark:bg-gray-700 dark:text-gray-100">
                <input type="password" name="password" placeholder="New Password (leave blank to keep)"
                       class="w-full px-3 py-2 border rounded text-sm dark:bg-gray-700 dark:text-gray-100">
                <div class="flex justify-end space-x-2">
                    <a href="{{ route('users.index') }}"
                       class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded hover:bg-gray-400 dark:hover:bg-gray-700">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
