<x-app-layout>
    <div x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }" x-init="$watch('darkMode', val => {
        localStorage.setItem('theme', val ? 'dark' : 'light');
        document.documentElement.classList.toggle('dark', val);
    });
    document.documentElement.classList.toggle('dark', darkMode);"
        class="min-h-screen flex bg-gray-50 dark:bg-[#0f172a] transition-all duration-700 ease-in-out">

        <!-- Sidebar -->
        <aside
            class="w-64 bg-gradient-to-b from-emerald-600 to-emerald-800 dark:from-[#064e3b] dark:to-[#022c22] text-white flex flex-col shadow-xl transition-all duration-700 ease-in-out">
            <div class="p-6 flex items-center space-x-2 border-b border-emerald-700/50 dark:border-emerald-900/60">
                <img src="{{ asset('images/logo.PNG') }}" alt="Logo" class="w-10 h-auto rounded-md">
                <h2 class="text-lg font-bold leading-tight">KAP Budiandru</h2>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-3 text-sm transition-colors duration-500">
                <a href="#"
                    class="flex items-center space-x-3 px-3 py-2 rounded-lg bg-emerald-700/60 hover:bg-emerald-600 dark:bg-emerald-900/60 dark:hover:bg-emerald-800/80 transition-all">
                    <i class="fa-solid fa-house"></i><span>Dashboard</span>
                </a>
                <template
                    x-for="item in [
                    ['fa-folder-open', 'Legal Documents'],
                    ['fa-handshake', 'Partner Docs'],
                    ['fa-box-archive', 'Archive Records'],
                    ['fa-chalkboard-user', 'Training Material'],
                    ['fa-warehouse', 'Inventory'],
                    ['fa-chart-line', 'Financial Reports'],
                    ['fa-file-invoice-dollar', 'Finance & Tax Reports']
                    ]">
                    <a href="#"
                        class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-emerald-700/50 transition-all">
                        <i :class="`fa-solid ${item[0]} text-lg`"></i>
                        <span x-text="item[1]"></span>
                    </a>
                </template>
            </nav>

            <div
                class="p-4 border-t border-emerald-700/40 text-sm text-emerald-100 dark:text-emerald-200 transition-all duration-500">
                <p>Logged in as: <br><span class="font-semibold">{{ Auth::user()->name }}</span></p>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit"
                        class="w-full px-4 py-2 text-sm bg-emerald-700 hover:bg-emerald-600 dark:bg-emerald-800 dark:hover:bg-emerald-700 rounded-lg transition-all">Logout</button>
                </form>
            </div>
        </aside>

        <!-- Main -->
        <main
            class="flex-1 p-8 overflow-y-auto text-gray-800 dark:text-gray-100 transition-all duration-700 ease-in-out">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold tracking-tight">Administrator Office</h1>

                <!-- Dark Mode Toggle -->
                <button @click="darkMode = !darkMode"
                    class="flex items-center space-x-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 px-4 py-2 rounded-full transition-all duration-500 shadow-sm">
                    <template x-if="!darkMode">
                        <i class="fa-solid fa-moon text-gray-700 transition-transform duration-500"></i>
                    </template>
                    <template x-if="darkMode">
                        <i class="fa-solid fa-sun text-yellow-300 transition-transform duration-500"></i>
                    </template>
                    <span x-text="darkMode ? 'Light Mode' : 'Dark Mode'" class="text-sm font-medium"></span>
                </button>
            </div>

            <!-- Dashboard Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 fade-area transition-all duration-700">
                @php
                    $cards = [
                        [
                            'icon' => 'fa-folder-open',
                            'title' => 'Legal Document',
                            'color' => 'from-emerald-400 to-emerald-600 dark:from-emerald-800 dark:to-emerald-950',
                            'link' => route('legal-documents.index'),
                        ],
                        [
                            'icon' => 'fa-handshake',
                            'title' => 'Partner Doc',
                            'color' => 'from-sky-400 to-sky-600 dark:from-sky-800 dark:to-blue-950',
                        ],
                        [
                            'icon' => 'fa-box-archive',
                            'title' => 'Archive Record',
                            'color' => 'from-amber-400 to-amber-600 dark:from-amber-800 dark:to-orange-950',
                        ],
                        [
                            'icon' => 'fa-chalkboard-teacher',
                            'title' => 'Training Material',
                            'color' => 'from-indigo-400 to-indigo-600 dark:from-indigo-800 dark:to-indigo-950',
                        ],
                        [
                            'icon' => 'fa-warehouse',
                            'title' => 'Inventory',
                            'color' => 'from-fuchsia-400 to-fuchsia-600 dark:from-fuchsia-800 dark:to-purple-950',
                        ],
                        [
                            'icon' => 'fa-chart-line',
                            'title' => 'Financial Report',
                            'color' => 'from-teal-400 to-teal-600 dark:from-teal-800 dark:to-cyan-950',
                        ],
                        [
                            'icon' => 'fa-file-invoice-dollar',
                            'title' => 'Finance & Tax Report',
                            'color' => 'from-rose-400 to-rose-600 dark:from-rose-800 dark:to-rose-950',
                        ],
                    ];
                @endphp

                @foreach ($cards as $card)
                    <div
                        class="p-6 bg-gradient-to-br {{ $card['color'] }} rounded-xl text-white shadow-lg hover:scale-[1.02] hover:shadow-2xl transition-all duration-500 ease-in-out backdrop-blur-md dark:bg-opacity-90">
                        <div class="flex items-center justify-between">
                            <div>
                                <i class="fa-solid {{ $card['icon'] }} text-3xl mb-2 opacity-90"></i>
                                <h2 class="text-lg font-semibold tracking-wide">{{ $card['title'] }}</h2>
                            </div>
                            <a href="{{ $card['link'] ?? '#' }}"
                                class="text-white bg-white/20 hover:bg-white/30 px-3 py-2 rounded-lg text-sm transition-all">Open</a>

                        </div>
                    </div>
                @endforeach
            </div>

            <footer
                class="mt-10 text-gray-500 dark:text-gray-400 text-sm text-center border-t border-gray-200/30 dark:border-gray-700/30 pt-6 transition-all duration-700">
                © {{ date('Y') }} KAP Budiandru & Rekan — Administrator Office
            </footer>
        </main>
    </div>

    <style>
        .fade-area {
            transition: opacity 0.6s ease-in-out, background-color 0.6s ease-in-out;
        }

        html.dark .fade-area {
            opacity: 0.95;
        }

        body {
            transition: background-color 0.7s ease, color 0.7s ease;
        }
    </style>

    <!-- Font Awesome 6.5.0 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


</x-app-layout>
