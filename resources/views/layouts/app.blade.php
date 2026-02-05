<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="{
        darkMode: localStorage.getItem('theme') === 'dark',
        loading: true,
        progress: 0
    }"
    x-init="
        $watch('darkMode', val => {
            localStorage.setItem('theme', val ? 'dark' : 'light');
            document.documentElement.classList.toggle('dark', val);
        });
        document.documentElement.classList.toggle('dark', darkMode);

        // Animated progress bar
        let interval = setInterval(() => {
            progress += Math.random() * 15;
            if (progress >= 100) {
                progress = 100;
                clearInterval(interval);
                setTimeout(() => loading = false, 300);
            }
        }, 200);
    "
    x-cloak
    class="transition-colors duration-500 ease-out">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* Custom font */
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Hide content before Alpine loads */
        [x-cloak] {
            display: none !important;
        }

        /* Premium Loading Animation */
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        @keyframes pulse-ring {
            0% { transform: scale(0.8); opacity: 1; }
            100% { transform: scale(2); opacity: 0; }
        }

        @keyframes gradient-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        @keyframes fade-up {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        @keyframes spin-slow {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .animate-pulse-ring {
            animation: pulse-ring 1.5s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient-shift 3s ease infinite;
        }

        .animate-shimmer {
            animation: shimmer 2s infinite;
        }

        .animate-fade-up {
            animation: fade-up 0.6s ease-out forwards;
        }

        .animate-spin-slow {
            animation: spin-slow 3s linear infinite;
        }

        /* Glass morphism */
        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        .dark .glass {
            background: rgba(17, 24, 39, 0.4);
        }

        /* Progress bar glow */
        .progress-glow {
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.5), 0 0 40px rgba(16, 185, 129, 0.3);
        }

        /* Particle styles */
        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: linear-gradient(135deg, #10b981, #06b6d4);
            border-radius: 50%;
            pointer-events: none;
        }

        /* Page transition */
        .page-enter {
            animation: fade-up 0.4s ease-out;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gradient-to-br from-gray-50 via-white to-gray-100 dark:from-[#0a0f1a] dark:via-[#0e1525] dark:to-[#111827] min-h-screen transition-colors duration-500">

    <!-- Premium Splash Screen -->
    <div x-show="loading"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-500"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden"
        :class="darkMode ? 'bg-[#0a0f1a]' : 'bg-white'">

        <!-- Animated Background -->
        <div class="absolute inset-0 overflow-hidden">
            <!-- Gradient orbs -->
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-emerald-500/20 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-cyan-500/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 0.5s;"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-gradient-to-r from-emerald-500/10 to-cyan-500/10 rounded-full blur-3xl animate-spin-slow"></div>
        </div>

        <!-- Content -->
        <div class="relative z-10 flex flex-col items-center">

            <!-- Logo Container with Ring Effect -->
            <div class="relative mb-8">
                <!-- Pulse rings -->
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-32 h-32 rounded-full border-2 border-emerald-500/30 animate-pulse-ring"></div>
                </div>
                <div class="absolute inset-0 flex items-center justify-center" style="animation-delay: 0.5s;">
                    <div class="w-32 h-32 rounded-full border-2 border-cyan-500/30 animate-pulse-ring" style="animation-delay: 0.75s;"></div>
                </div>

                <!-- Logo -->
                <div class="relative w-28 h-28 rounded-2xl bg-gradient-to-br from-emerald-500 to-cyan-500 p-1 shadow-2xl animate-float">
                    <div class="w-full h-full rounded-xl bg-white dark:bg-gray-900 flex items-center justify-center overflow-hidden">
                        @if(config('app.loading_logo'))
                            <img src="{{ config('app.loading_logo') }}" alt="Logo" class="w-20 h-20 object-contain">
                        @else
                            <div class="text-4xl font-bold bg-gradient-to-r from-emerald-500 to-cyan-500 bg-clip-text text-transparent">
                                KAP
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Brand Text -->
            <div class="text-center mb-8 animate-fade-up" style="animation-delay: 0.2s;">
                <h1 class="text-2xl font-bold bg-gradient-to-r from-emerald-600 via-teal-500 to-cyan-500 bg-clip-text text-transparent mb-2">
                    KAP Budiandru & Rekan
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Administrator System
                </p>
            </div>

            <!-- Progress Bar -->
            <div class="w-64 animate-fade-up" style="animation-delay: 0.4s;">
                <!-- Progress container -->
                <div class="relative h-2 bg-gray-200 dark:bg-gray-800 rounded-full overflow-hidden">
                    <!-- Shimmer effect -->
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent animate-shimmer"></div>

                    <!-- Progress fill -->
                    <div class="h-full bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 rounded-full transition-all duration-300 ease-out progress-glow animate-gradient"
                        :style="'width: ' + progress + '%'">
                    </div>
                </div>

                <!-- Progress text -->
                <div class="flex justify-between items-center mt-3">
                    <span class="text-xs text-gray-500 dark:text-gray-400">Loading...</span>
                    <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400" x-text="Math.round(progress) + '%'"></span>
                </div>
            </div>

            <!-- Loading dots -->
            <div class="flex items-center gap-1.5 mt-6 animate-fade-up" style="animation-delay: 0.6s;">
                <div class="w-2 h-2 bg-emerald-500 rounded-full animate-bounce" style="animation-delay: 0s;"></div>
                <div class="w-2 h-2 bg-teal-500 rounded-full animate-bounce" style="animation-delay: 0.15s;"></div>
                <div class="w-2 h-2 bg-cyan-500 rounded-full animate-bounce" style="animation-delay: 0.3s;"></div>
            </div>
        </div>

        <!-- Footer -->
        <div class="absolute bottom-8 text-center animate-fade-up" style="animation-delay: 0.8s;">
            <p class="text-xs text-gray-400 dark:text-gray-600">
                &copy; {{ date('Y') }} KAP Budiandru & Rekan. All rights reserved.
            </p>
        </div>
    </div>

    <!-- Main Layout -->
    <div x-show="!loading"
        x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        class="min-h-screen page-enter">

        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white/70 dark:bg-gray-900/60 backdrop-blur-xl shadow-sm border-b border-gray-200/50 dark:border-gray-800/50 transition-all duration-300">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <div class="text-gray-800 dark:text-gray-100">
                        {{ $header }}
                    </div>
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class="transition-all duration-300 ease-out">
            {{ $slot }}
        </main>
    </div>

    <!-- Page Transition Overlay -->
    <div id="page-transition"
        class="fixed inset-0 z-[90] pointer-events-none opacity-0 transition-opacity duration-300"
        :class="darkMode ? 'bg-[#0a0f1a]' : 'bg-white'">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="w-12 h-12 border-4 border-emerald-500/30 border-t-emerald-500 rounded-full animate-spin"></div>
        </div>
    </div>

    <script>
        // Page transition on link clicks
        document.addEventListener("DOMContentLoaded", () => {
            const transition = document.querySelector("#page-transition");

            document.querySelectorAll("a").forEach(link => {
                link.addEventListener("click", e => {
                    const href = link.getAttribute('href');

                    // Skip for hash links, external links, or links with target
                    if (!href || href.startsWith("#") || href.startsWith("javascript:") || link.target === "_blank") {
                        return;
                    }

                    // Skip for download links
                    if (link.hasAttribute('download')) {
                        return;
                    }

                    e.preventDefault();

                    // Show transition
                    transition.classList.remove('pointer-events-none', 'opacity-0');
                    transition.classList.add('opacity-100');

                    // Navigate after animation
                    setTimeout(() => {
                        window.location.href = href;
                    }, 300);
                });
            });
        });
    </script>
</body>

</html>
