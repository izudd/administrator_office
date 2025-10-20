<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('theme') === 'dark', loading: true }" x-init="$watch('darkMode', val => {
    localStorage.setItem('theme', val ? 'dark' : 'light');
    document.documentElement.classList.toggle('dark', val);
});
document.documentElement.classList.toggle('dark', darkMode);
setTimeout(() => loading = false, 2500);" x-cloak
    class="transition-colors duration-700 ease-in-out">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* 🌈 Animasi splash dan loading */
        @keyframes spin-slow {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .animate-spin-slow {
            animation: spin-slow 2.5s linear infinite;
        }

        @keyframes shimmer {
            0% {
                background-position: -500px 0;
            }

            100% {
                background-position: 500px 0;
            }
        }

        .skeleton {
            background: linear-gradient(90deg, #e0e0e0 25%, #f8f8f8 50%, #e0e0e0 75%);
            background-size: 1000px 100%;
            animation: shimmer 2s infinite;
        }

        .dark .skeleton {
            background: linear-gradient(90deg, #1f2937 25%, #374151 50%, #1f2937 75%);
            background-size: 1000px 100%;
        }

        /* Smooth fade-in */
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-[#0e1525] transition-colors duration-700">
    <!-- 🌟 Splash Screen -->
    <div x-show="loading" x-transition:enter="transition ease-out duration-700"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-700" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95" id="splash-screen"
        class="fixed inset-0 z-50 flex flex-col items-center justify-center bg-white dark:bg-[#0e1525] transition-all">

        <div class="flex flex-col items-center space-y-5">
            <img src="{{ config('app.loading_logo') }}" alt="Loading..." class="w-24 h-24 animate-spin-slow">



            <div class="w-48 h-2 rounded-full overflow-hidden bg-gray-200 dark:bg-gray-700">
                <div class="h-full bg-emerald-500 skeleton"></div>
            </div>

            <p class="text-gray-600 dark:text-gray-300 font-medium text-sm tracking-wide animate-pulse mt-2">
                Loading system...
            </p>
        </div>
    </div>

    <!-- 🌍 Main Layout -->
    <div x-show="!loading" x-transition.opacity.duration.700ms class="min-h-screen">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white/70 dark:bg-gray-900/60 backdrop-blur-md shadow transition">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-gray-800 dark:text-gray-100">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class="transition-all duration-700 ease-in-out">
            {{ $slot }}
        </main>
    </div>

    <!-- 🔁 Splash screen on page transitions -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const splash = document.querySelector("#splash-screen");
            document.querySelectorAll("a").forEach(link => {
                link.addEventListener("click", e => {
                    if (link.href && !link.href.startsWith("#") && !link.target) {
                        e.preventDefault();
                        splash.classList.remove("hidden");
                        splash.classList.add("flex");
                        setTimeout(() => window.location.href = link.href, 2500);
                    }
                });
            });
        });
    </script>
</body>

</html>
