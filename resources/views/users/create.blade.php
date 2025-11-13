<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            ➕ Add New User
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

            <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="text" name="name" placeholder="Name" required
                       class="w-full px-3 py-2 border rounded text-sm dark:bg-gray-700 dark:text-gray-100">
                <input type="email" name="email" placeholder="Email" required
                       class="w-full px-3 py-2 border rounded text-sm dark:bg-gray-700 dark:text-gray-100">
                <input type="password" name="password" placeholder="Password" required
                       class="w-full px-3 py-2 border rounded text-sm dark:bg-gray-700 dark:text-gray-100">
                <div class="flex justify-end space-x-2">
                    <a href="{{ route('users.index') }}"
                       class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded hover:bg-gray-400 dark:hover:bg-gray-700">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Save</button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
