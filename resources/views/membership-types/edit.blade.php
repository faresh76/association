<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            Edit Membership Type
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            
            {{-- Back Button --}}
            <div class="mb-4">
                <a href="{{ route('membership-types.index') }}" 
                   class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white underline">
                    ← Back to Membership Types
                </a>
            </div>

            <form action="{{ route('membership-types.update', $membershipType->type_id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('membership-types._form', ['buttonText' => 'Update'])
            </form>
        </div>
    </div>
</x-app-layout>
