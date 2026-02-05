<nav x-data="{ open: false, scrolled: false }"
    @scroll.window="scrolled = window.scrollY > 20"
    class="sticky top-0 z-40 transition-all duration-300"
    :class="scrolled ? 'backdrop-blur-xl bg-white/80 dark:bg-gray-900/80 shadow-lg shadow-gray-200/50 dark:shadow-gray-900/50' : 'backdrop-blur-md bg-white/60 dark:bg-gray-900/60'">

    <!-- Gradient line at top -->
    <div class="absolute top-0 left-0 right-0 h-0.5 bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- Left: Logo + Brand -->
            <div class="flex items-center space-x-3">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                    <!-- Logo -->
                    <div class="relative">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-cyan-500 p-0.5 shadow-lg group-hover:shadow-emerald-500/30 transition-all duration-300 group-hover:scale-105">
                            <div class="w-full h-full rounded-[10px] bg-white dark:bg-gray-900 flex items-center justify-center overflow-hidden">
                                <img src="{{ asset('images/logo.PNG') }}" alt="KAP Logo" class="w-7 h-7 object-contain">
                            </div>
                        </div>
                        <!-- Pulse dot -->
                        <div class="absolute -top-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-500 rounded-full border-2 border-white dark:border-gray-900 animate-pulse"></div>
                    </div>

                    <!-- Brand text (hidden on mobile) -->
                    <div class="hidden md:block">
                        <h1 class="text-sm font-bold text-gray-800 dark:text-gray-100 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                            Budiandru & Rekan
                        </h1>
                        <p class="text-[10px] text-gray-500 dark:text-gray-400">Administrator System</p>
                    </div>
                </a>
            </div>

            <!-- Center: Navigation Links -->
            <div class="hidden sm:flex items-center space-x-1">
                <a href="{{ route('dashboard') }}"
                    class="relative px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200 group
                    {{ request()->routeIs('dashboard') ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-600 dark:text-gray-300 hover:text-emerald-600 dark:hover:text-emerald-400' }}">
                    <span class="relative z-10 flex items-center gap-2">
                        <i class="fa-solid fa-home text-xs"></i>
                        Dashboard
                    </span>
                    @if(request()->routeIs('dashboard'))
                        <span class="absolute inset-0 bg-emerald-500/10 dark:bg-emerald-500/20 rounded-xl"></span>
                    @else
                        <span class="absolute inset-0 bg-gray-500/0 group-hover:bg-gray-500/10 dark:group-hover:bg-gray-500/20 rounded-xl transition-colors"></span>
                    @endif
                </a>

                <a href="{{ route('legal-documents.index') }}"
                    class="relative px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200 group
                    {{ request()->routeIs('legal-documents.*') ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-600 dark:text-gray-300 hover:text-emerald-600 dark:hover:text-emerald-400' }}">
                    <span class="relative z-10 flex items-center gap-2">
                        <i class="fa-solid fa-folder-tree text-xs"></i>
                        Documents
                    </span>
                    @if(request()->routeIs('legal-documents.*'))
                        <span class="absolute inset-0 bg-emerald-500/10 dark:bg-emerald-500/20 rounded-xl"></span>
                    @else
                        <span class="absolute inset-0 bg-gray-500/0 group-hover:bg-gray-500/10 dark:group-hover:bg-gray-500/20 rounded-xl transition-colors"></span>
                    @endif
                </a>

                <a href="{{ route('profile.edit') }}"
                    class="relative px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200 group
                    {{ request()->routeIs('profile.*') ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-600 dark:text-gray-300 hover:text-emerald-600 dark:hover:text-emerald-400' }}">
                    <span class="relative z-10 flex items-center gap-2">
                        <i class="fa-solid fa-user text-xs"></i>
                        Profile
                    </span>
                    @if(request()->routeIs('profile.*'))
                        <span class="absolute inset-0 bg-emerald-500/10 dark:bg-emerald-500/20 rounded-xl"></span>
                    @else
                        <span class="absolute inset-0 bg-gray-500/0 group-hover:bg-gray-500/10 dark:group-hover:bg-gray-500/20 rounded-xl transition-colors"></span>
                    @endif
                </a>
            </div>

            <!-- Right: Dark Mode Toggle + User Dropdown -->
            <div class="hidden sm:flex items-center space-x-3">
                <!-- Dark Mode Toggle -->
                <button @click="darkMode = !darkMode"
                    class="relative w-10 h-10 rounded-xl flex items-center justify-center text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-200 group">
                    <i x-show="!darkMode" class="fa-solid fa-moon text-lg group-hover:text-emerald-600 transition-colors"></i>
                    <i x-show="darkMode" class="fa-solid fa-sun text-lg text-yellow-500 group-hover:text-yellow-400 transition-colors"></i>
                </button>

                <!-- Notification Bell (optional) -->
                <button class="relative w-10 h-10 rounded-xl flex items-center justify-center text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-200 group">
                    <i class="fa-solid fa-bell text-lg group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors"></i>
                    <!-- Badge -->
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>

                <!-- User Dropdown -->
                <x-dropdown align="right" width="56">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-3 px-3 py-1.5 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-200 group">
                            <!-- Avatar -->
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-500 to-cyan-500 p-0.5 group-hover:shadow-lg group-hover:shadow-emerald-500/30 transition-all">
                                <div class="w-full h-full rounded-[10px] bg-white dark:bg-gray-800 flex items-center justify-center">
                                    <span class="text-sm font-bold text-emerald-600 dark:text-emerald-400">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Name & Role -->
                            <div class="hidden lg:block text-left">
                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-100 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                                    {{ Auth::user()->name }}
                                </p>
                                <p class="text-[10px] text-gray-500 dark:text-gray-400">Administrator</p>
                            </div>

                            <!-- Chevron -->
                            <i class="fa-solid fa-chevron-down text-xs text-gray-400 group-hover:text-emerald-500 transition-colors"></i>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- User info header -->
                        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ Auth::user()->email }}</p>
                        </div>

                        <div class="py-1">
                            <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                <i class="fa-solid fa-user-gear text-gray-400 w-5"></i>
                                <span>{{ __('Profile Settings') }}</span>
                            </x-dropdown-link>

                            <x-dropdown-link href="#" class="flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                <i class="fa-solid fa-shield-halved text-gray-400 w-5"></i>
                                <span>{{ __('Security') }}</span>
                            </x-dropdown-link>
                        </div>

                        <div class="border-t border-gray-200 dark:border-gray-700 py-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="flex items-center gap-3 px-4 py-2.5 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                                    <i class="fa-solid fa-right-from-bracket w-5"></i>
                                    <span>{{ __('Log Out') }}</span>
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile menu button -->
            <div class="sm:hidden flex items-center gap-2">
                <!-- Dark Mode Toggle Mobile -->
                <button @click="darkMode = !darkMode"
                    class="w-10 h-10 rounded-xl flex items-center justify-center text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
                    <i x-show="!darkMode" class="fa-solid fa-moon"></i>
                    <i x-show="darkMode" class="fa-solid fa-sun text-yellow-500"></i>
                </button>

                <!-- Hamburger -->
                <button @click="open = !open"
                    class="w-10 h-10 rounded-xl flex items-center justify-center text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
                    <i x-show="!open" class="fa-solid fa-bars text-lg"></i>
                    <i x-show="open" class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div x-show="open" x-collapse
        class="sm:hidden border-t border-gray-200 dark:border-gray-700 bg-white/95 dark:bg-gray-900/95 backdrop-blur-xl">
        <div class="px-4 py-3 space-y-1">
            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all
                {{ request()->routeIs('dashboard') ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                <i class="fa-solid fa-home w-5"></i>
                Dashboard
            </a>

            <a href="{{ route('legal-documents.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all
                {{ request()->routeIs('legal-documents.*') ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                <i class="fa-solid fa-folder-tree w-5"></i>
                Documents
            </a>

            <a href="{{ route('profile.edit') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all
                {{ request()->routeIs('profile.*') ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                <i class="fa-solid fa-user w-5"></i>
                Profile
            </a>
        </div>

        <!-- User section -->
        <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3 px-4 py-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-cyan-500 p-0.5">
                    <div class="w-full h-full rounded-[10px] bg-white dark:bg-gray-800 flex items-center justify-center">
                        <span class="text-sm font-bold text-emerald-600">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all">
                    <i class="fa-solid fa-right-from-bracket w-5"></i>
                    Log Out
                </button>
            </form>
        </div>
    </div>
</nav>
