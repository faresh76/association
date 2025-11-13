<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>My Association</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-blue-50 dark:bg-blue-900 text-xs">
    <div class="min-h-screen flex">

        {{-- SIDEBAR --}}
        <aside class="w-64 bg-blue-700 dark:bg-blue-800 text-white flex-shrink-0">
            <div class="p-4 border-b border-blue-600 flex items-center space-x-2">
                <img src="{{ asset('images/associate.png') }}" alt="Logo" class="h-10 w-10 rounded-full border-2 border-white shadow-sm">
                <span class="text-sm font-bold">{{ config('app.name', 'My Association') }}</span>
            </div>

            <nav class="mt-4 space-y-1">
                <a href="{{ route('dashboard') }}" 
                   class="block px-4 py-2 rounded hover:bg-blue-600 {{ request()->routeIs('dashboard') ? 'bg-blue-800 font-semibold' : '' }}">
                    🏠 Dashboard
                </a>

                            <!-- Manage Members Dropdown -->
                <div x-data="{ open: {{ request()->routeIs('members.*') || request()->routeIs('family-members.*') || request()->routeIs('member_memberships.*') || request()->routeIs('fees_payments.*') ? 'true' : 'false' }} }" class="mb-2">
                    <button 
                        @click="open = !open"
                        class="flex items-center justify-between w-full px-4 py-2 rounded hover:bg-blue-600 
                            {{ request()->routeIs('members.*') || request()->routeIs('family-members.*') || request()->routeIs('member_memberships.*') || request()->routeIs('fees_payments.*') ? 'bg-blue-800 font-semibold text-white' : '' }}">
                        <span>👥 Manage Members</span>
                        <svg :class="{'rotate-180': open}" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.06l3.71-3.83a.75.75 0 011.08 1.04l-4.25 4.4a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div x-show="open" x-transition class="pl-6 mt-1 space-y-1">
                        <a href="{{ route('members.index') }}" 
                        class="block px-3 py-1.5 rounded hover:bg-blue-600 
                        {{ request()->routeIs('members.*') ? 'bg-blue-700 text-white font-semibold' : 'text-gray-200' }}">
                            🧑 Members
                        </a>

                        <a href="{{ route('family-members.index') }}" 
                        class="block px-3 py-1.5 rounded hover:bg-blue-600 
                        {{ request()->routeIs('family-members.*') ? 'bg-blue-700 text-white font-semibold' : 'text-gray-200' }}">
                            👨‍👩‍👧 Family Members
                        </a>

                        <a href="{{ route('member_memberships.index') }}" 
                        class="block px-3 py-1.5 rounded hover:bg-blue-600 
                        {{ request()->routeIs('member_memberships.*') ? 'bg-blue-700 text-white font-semibold' : 'text-gray-200' }}">
                            🎫 Member Memberships
                        </a>

                        <a href="{{ route('fees_payments.index') }}" 
                        class="block px-3 py-1.5 rounded hover:bg-blue-600 
                        {{ request()->routeIs('fees_payments.*') ? 'bg-blue-700 text-white font-semibold' : 'text-gray-200' }}">
                            💰 Fee Payments
                        </a>
                    </div>
                </div>

      
                                <!-- Manage Event Dropdown -->
                                <div x-data="{ open: {{ request()->routeIs('events.*') || request()->routeIs('event_participants.*') ? 'true' : 'false' }} }" class="mb-2">
                                    <button 
                                        @click="open = !open"
                                        class="flex items-center justify-between w-full px-4 py-2 rounded hover:bg-blue-600 
                                            {{ request()->routeIs('events.*') || request()->routeIs('event_participants.*') ? 'bg-blue-800 font-semibold text-white' : '' }}">
                                        <span>📋 Manage Event</span>
                                        <svg :class="{'rotate-180': open}" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.06l3.71-3.83a.75.75 0 011.08 1.04l-4.25 4.4a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                        </svg>
                                    </button>

                                    <div x-show="open" x-transition class="pl-6 mt-1 space-y-1">
                                        <a href="{{ route('events.index') }}" 
                                        class="block px-3 py-1.5 rounded hover:bg-blue-600 
                                                {{ request()->routeIs('events.*') ? 'bg-blue-700 text-white font-semibold' : 'text-gray-200' }}">
                                            📅 Events
                                        </a>

                                        <a href="{{ route('event_participants.index') }}" 
                                        class="block px-3 py-1.5 rounded hover:bg-blue-600 
                                                {{ request()->routeIs('event_participants.*') ? 'bg-blue-700 text-white font-semibold' : 'text-gray-200' }}">
                                            👥 Event Participants
                                        </a>
                                    </div>
                                </div>


                            <a href="{{ route('announcements.index') }}" 
                            class="block px-4 py-2 rounded hover:bg-blue-600 
                                    {{ request()->routeIs('announcements.*') ? 'bg-blue-800 font-semibold' : '' }}">
                                📢 Announcements
                            </a>

                            <a href="{{ route('files.index') }}" 
                            class="block px-4 py-2 rounded hover:bg-blue-600 
                                    {{ request()->routeIs('announcements.*') ? 'bg-blue-800 font-semibold' : '' }}">
                                📁  File Management
                            </a>

                                                        <a href="{{ route('users.index') }}" 
                            class="block px-4 py-2 rounded hover:bg-blue-600 
                                    {{ request()->routeIs('users.*') ? 'bg-blue-800 font-semibold' : '' }}">
                                👤  Manage User
                            </a>


                          
                            <!-- Settings Menu with Submenu -->
                             <div x-data="{ open: {{ request()->routeIs('membership-types.*', 'committee-roles.*', 'committee-members.*', 'relationship-types.*') ? 'true' : 'false' }} }">
                            <button @click="open = !open"
                                    class="w-full flex justify-between items-center px-4 py-2 rounded text-gray-100 hover:bg-cyan-600">
                                ⚙️ Settings
                                <svg :class="{'rotate-180': open}" class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="open" class="ml-4 mt-1 space-y-1">
                                <a href="{{ route('membership-types.index') }}"
                                class="block px-4 py-2 rounded hover:bg-cyan-600 {{ request()->routeIs('membership-types.*') ? 'bg-cyan-800 font-semibold' : 'text-gray-100' }}">
                                    📝 Membership Types
                                </a>


                                <a href="{{ route('committee-roles.index') }}"
                                class="block px-4 py-2 rounded hover:bg-cyan-600 {{ request()->routeIs('committee-roles.*') ? 'bg-cyan-800 font-semibold' : 'text-gray-100' }}">
                                    🏛 Committee Roles
                                </a>

                                <a href="{{ route('committee-members.index') }}"
                                class="block px-4 py-2 rounded hover:bg-cyan-600 {{ request()->routeIs('committee-members.*') ? 'bg-cyan-800 font-semibold' : 'text-gray-100' }}">
                                    🧑‍💼 Committee Assignments
                                </a>

                                <a href="{{ route('relationship-types.index') }}"
                                class="block px-4 py-2 rounded hover:bg-cyan-600 {{ request()->routeIs('relationship-types.*') ? 'bg-cyan-800 font-semibold' : 'text-gray-100' }}">
                                    💍 Relationship Types
                                </a>


                            </div>
                        </div>


            </nav>
        </aside>

        {{-- MAIN AREA --}}
        <div class="flex-1 flex flex-col min-h-screen">

            {{-- Top Navbar --}}
            <header class="bg-blue-600 dark:bg-blue-700 shadow">
                <div class="max-w-7xl mx-auto py-4 px-6 flex justify-between items-center text-white">
                    <h1 class="text-lg font-semibold">{{ $header ?? 'Dashboard' }}</h1>
  <div>
    {{-- User Dropdown --}}
    <x-dropdown align="right">
        <x-slot name="trigger">
            <button class="flex items-center text-sm font-medium hover:text-gray-200">
                {{ Auth::user()->name }}
                <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
        </x-slot>

        <x-slot name="content">
            <!-- Profile Link -->
            <x-dropdown-link :href="route('profile.edit')">
                {{ __('My Profile') }}
            </x-dropdown-link>

            <!-- Divider -->
            <div class="border-t border-gray-200 my-1"></div>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-dropdown-link :href="route('logout')" 
                                 onclick="event.preventDefault(); this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-dropdown-link>
            </form>
        </x-slot>
    </x-dropdown>
</div>

                </div>
            </header>

            {{-- Page Content --}}
            <main class="flex-1 p-6 bg-blue-50 dark:bg-blue-900 text-gray-800 dark:text-white">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
