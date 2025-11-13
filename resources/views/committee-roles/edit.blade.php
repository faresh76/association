<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            Edit Committee Role
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-cyan-50 dark:bg-cyan-900 shadow rounded-lg p-6">
            <form action="{{ route('committee-roles.update', $committeeRole->role_id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('committee-roles._form', ['buttonText' => 'Update'])
            </form>
        </div>
    </div>
</x-app-layout>
