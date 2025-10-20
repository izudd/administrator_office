<nav x-data="{ open: false }"
    class="sticky top-0 z-40 backdrop-blur-md bg-white/80 dark:bg-[#111827]/80 border-b border-gray-200 dark:border-gray-800 shadow-sm transition-all duration-700 ease-in-out">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- Left: Logo + Page Title -->
            {{-- <div class="flex items-center space-x-3">
                <img src="{{ asset('images/logo.PNG') }}" alt="Logo" class="h-9 w-auto rounded-md">
                <h1 class="text-lg font-semibold text-gray-800 dark:text-gray-100 tracking-wide transition-all">
                    Administrator Dashboard
                </h1>
            </div> --}}

            <!-- Center: Navigation -->
            <div class="hidden sm:flex space-x-8">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-nav-link>
                <x-nav-link href="#">
                    {{ __('Profile') }}
                </x-nav-link>
                <x-nav-link href="#">
                    {{ __('Contact') }}
                </x-nav-link>
            </div>

            <!-- Right: User Dropdown -->
            <div class="hidden sm:flex items-center space-x-4">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-800 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white bg-transparent transition-all duration-300">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
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
    </div>
</nav>
