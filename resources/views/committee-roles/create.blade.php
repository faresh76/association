<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            Create Committee Role
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <form action="{{ route('committee-roles.store') }}" method="POST">
                @csrf
                @include('committee-roles._form', ['buttonText' => 'Create'])
            </form>
        </div>
    </div>
</x-app-layout>
