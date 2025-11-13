<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Association Member Portal</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col justify-center items-center bg-gray-50 dark:bg-gray-900">

    <!-- Logo + Title -->
    <div class="text-center mb-6">
        <img src="{{ asset('images/associate.png') }}" 
             alt="Logo" 
             class="h-20 w-20 rounded-full border-2 border-gray-300 dark:border-gray-600 shadow-md mx-auto mb-3">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
            Association Member Portal
        </h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
            Please sign in to continue
        </p>
    </div>

    <!-- Login Card -->
    <div class="w-full max-w-md bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" 
                              class="block mt-1 w-full" 
                              type="email" 
                              name="email" 
                              :value="old('email')" 
                              required autofocus 
                              autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" 
                              class="block mt-1 w-full" 
                              type="password" 
                              name="password" 
                              required 
                              autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mb-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" 
                           class="rounded border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500" 
                           name="remember">
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Remember me') }}
                    </span>
                </label>
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-between mt-6">
                @if (Route::has('password.request'))
                    <a class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline"
                       href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif

                <x-primary-button class="ms-3">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <p class="mt-6 text-xs text-gray-500 dark:text-gray-400">
        © {{ date('Y') }} Association Management System. All rights reserved.
    </p>

</body>
</html>
