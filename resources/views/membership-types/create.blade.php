<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            Add Membership Type
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <form action="{{ route('membership-types.store') }}" method="POST">
                @csrf
                @include('membership-types._form', ['buttonText' => 'Save'])
            </form>
        </div>
    </div>
</x-app-layout>
