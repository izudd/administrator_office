<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="appLayout()"
    x-init="init()"
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
        body { font-family: 'Inter', sans-serif; }

        /* Hide content before Alpine loads */
        [x-cloak] { display: none !important; }

        /* ========== CINEMATIC LOADING SCREEN ========== */

        /* Orb Animations */
        .loading-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            animation: orb-drift 20s ease-in-out infinite;
        }
        .orb-1 {
            width: 400px; height: 400px;
            background: linear-gradient(135deg, #10b981, #06b6d4);
            top: -100px; left: -100px;
            animation-delay: 0s;
        }
        .orb-2 {
            width: 350px; height: 350px;
            background: linear-gradient(135deg, #8b5cf6, #6366f1);
            bottom: -80px; right: -80px;
            animation-delay: -7s;
        }
        .orb-3 {
            width: 300px; height: 300px;
            background: linear-gradient(135deg, #06b6d4, #0ea5e9);
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: -14s;
        }

        @keyframes orb-drift {
            0%, 100% { transform: translate(0, 0) scale(1); opacity: 0.4; }
            33% { transform: translate(30px, -30px) scale(1.1); opacity: 0.6; }
            66% { transform: translate(-20px, 20px) scale(0.9); opacity: 0.5; }
        }

        /* Logo Pulse Ring */
        .logo-ring {
            position: absolute;
            border-radius: 50%;
            border: 2px solid rgba(16, 185, 129, 0.3);
            animation: ring-expand 2s cubic-bezier(0.4, 0, 0.2, 1) infinite;
        }
        .ring-1 { animation-delay: 0s; }
        .ring-2 { animation-delay: 0.5s; }
        .ring-3 { animation-delay: 1s; }

        @keyframes ring-expand {
            0% { width: 80px; height: 80px; opacity: 1; }
            100% { width: 200px; height: 200px; opacity: 0; }
        }

        /* Progress Bar Glow */
        .progress-glow {
            box-shadow:
                0 0 10px rgba(16, 185, 129, 0.5),
                0 0 20px rgba(16, 185, 129, 0.3),
                0 0 30px rgba(16, 185, 129, 0.2);
        }

        /* Shimmer Effect */
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        .animate-shimmer { animation: shimmer 1.5s ease-in-out infinite; }

        /* Gradient Animation */
        @keyframes gradient-flow {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient-flow 2s ease infinite;
        }

        /* Floating Animation */
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(3deg); }
        }
        .animate-float { animation: float 4s ease-in-out infinite; }

        /* Fade Slide Up */
        @keyframes fade-slide-up {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-slide-up {
            opacity: 0;
            animation: fade-slide-up 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* Counter Animation */
        @keyframes count-up {
            from { opacity: 0; transform: scale(0.8); }
            to { opacity: 1; transform: scale(1); }
        }

        /* Particle Rising */
        .particle {
            position: absolute;
            width: 3px;
            height: 3px;
            background: linear-gradient(135deg, #10b981, #06b6d4);
            border-radius: 50%;
            animation: particle-rise linear infinite;
        }
        @keyframes particle-rise {
            0% { transform: translateY(0) scale(1); opacity: 0; }
            10% { opacity: 0.8; }
            90% { opacity: 0.8; }
            100% { transform: translateY(-100vh) scale(0); opacity: 0; }
        }

        /* Text Reveal */
        @keyframes text-reveal {
            0% { clip-path: inset(0 100% 0 0); }
            100% { clip-path: inset(0 0 0 0); }
        }
        .animate-text-reveal {
            animation: text-reveal 1s cubic-bezier(0.77, 0, 0.175, 1) forwards;
        }

        /* Spin Slow */
        @keyframes spin-slow {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .animate-spin-slow { animation: spin-slow 20s linear infinite; }

        /* Page Enter Animation */
        @keyframes page-enter {
            0% { opacity: 0; transform: scale(0.98) translateY(20px); }
            100% { opacity: 1; transform: scale(1) translateY(0); }
        }
        .animate-page-enter {
            animation: page-enter 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* Grid Pattern */
        .grid-pattern {
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        /* Status Indicators */
        .status-dot {
            animation: status-pulse 2s ease-in-out infinite;
        }
        @keyframes status-pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.2); }
        }

        /* Loading Text Dots */
        .loading-dots::after {
            content: '';
            animation: dots 1.5s steps(4, end) infinite;
        }
        @keyframes dots {
            0% { content: ''; }
            25% { content: '.'; }
            50% { content: '..'; }
            75% { content: '...'; }
        }
    </style>
</head>

<body class="font-sans antialiased min-h-screen transition-colors duration-500"
    :class="darkMode ? 'bg-[#030712]' : 'bg-gradient-to-br from-gray-50 via-white to-gray-100'">

    <!-- ========== CINEMATIC LOADING SCREEN ========== -->
    <div x-show="loading"
        x-transition:leave="transition ease-in duration-700"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden"
        :class="darkMode ? 'bg-[#030712]' : 'bg-white'">

        <!-- Animated Background -->
        <div class="absolute inset-0 overflow-hidden">
            <!-- Orbs -->
            <div class="loading-orb orb-1" :class="darkMode ? 'opacity-30' : 'opacity-20'"></div>
            <div class="loading-orb orb-2" :class="darkMode ? 'opacity-30' : 'opacity-20'"></div>
            <div class="loading-orb orb-3" :class="darkMode ? 'opacity-20' : 'opacity-10'"></div>

            <!-- Grid Pattern -->
            <div class="absolute inset-0 grid-pattern" :class="darkMode ? 'opacity-100' : 'opacity-50'"></div>

            <!-- Particles -->
            <template x-for="i in 20" :key="i">
                <div class="particle"
                    :style="`left: ${Math.random() * 100}%; bottom: -10px; animation-duration: ${10 + Math.random() * 20}s; animation-delay: ${Math.random() * 10}s;`">
                </div>
            </template>
        </div>

        <!-- Vignette -->
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,transparent_0%,rgba(0,0,0,0.3)_100%)]"></div>

        <!-- Content -->
        <div class="relative z-10 flex flex-col items-center px-4">

            <!-- Logo Section -->
            <div class="relative mb-10">
                <!-- Pulse Rings -->
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="logo-ring ring-1"></div>
                    <div class="logo-ring ring-2"></div>
                    <div class="logo-ring ring-3"></div>
                </div>

                <!-- Logo Container -->
                <div class="relative animate-float">
                    <!-- Outer Glow -->
                    <div class="absolute -inset-2 bg-gradient-to-r from-emerald-500 via-cyan-500 to-violet-500 rounded-3xl blur-xl opacity-40 animate-gradient"></div>

                    <!-- Logo Box -->
                    <div class="relative w-24 h-24 rounded-2xl bg-gradient-to-br from-emerald-500 to-cyan-500 p-[2px] shadow-2xl">
                        <div class="w-full h-full rounded-[14px] flex items-center justify-center overflow-hidden"
                            :class="darkMode ? 'bg-gray-900' : 'bg-white'">
                            @if(config('app.loading_logo'))
                                <img src="{{ config('app.loading_logo') }}" alt="Logo" class="w-16 h-16 object-contain">
                            @else
                                <span class="text-3xl font-black bg-gradient-to-r from-emerald-500 to-cyan-500 bg-clip-text text-transparent">KAP</span>
                            @endif
                        </div>
                    </div>

                    <!-- Status Dot -->
                    <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 rounded-full border-3 flex items-center justify-center"
                        :class="darkMode ? 'border-gray-900' : 'border-white'">
                        <div class="w-2 h-2 bg-white rounded-full status-dot"></div>
                    </div>
                </div>
            </div>

            <!-- Brand Text -->
            <div class="text-center mb-10 animate-fade-slide-up" style="animation-delay: 0.2s">
                <h1 class="text-3xl font-bold mb-2 tracking-tight">
                    <span class="bg-gradient-to-r from-emerald-500 via-cyan-500 to-violet-500 bg-clip-text text-transparent animate-text-reveal">
                        KAP Budiandru & Rekan
                    </span>
                </h1>
                <p class="text-sm flex items-center justify-center gap-2"
                    :class="darkMode ? 'text-gray-500' : 'text-gray-400'">
                    <i class="fa-solid fa-shield-halved text-emerald-500 text-xs"></i>
                    Administrator System
                </p>
            </div>

            <!-- Progress Section -->
            <div class="w-72 animate-fade-slide-up" style="animation-delay: 0.4s">
                <!-- Progress Bar -->
                <div class="relative h-1.5 rounded-full overflow-hidden mb-4"
                    :class="darkMode ? 'bg-gray-800' : 'bg-gray-200'">
                    <!-- Shimmer -->
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent animate-shimmer"></div>

                    <!-- Fill -->
                    <div class="h-full bg-gradient-to-r from-emerald-500 via-cyan-500 to-emerald-500 rounded-full progress-glow animate-gradient transition-all duration-300"
                        :style="'width: ' + progress + '%'">
                    </div>
                </div>

                <!-- Progress Info -->
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <div class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></div>
                        <span class="text-xs loading-dots"
                            :class="darkMode ? 'text-gray-500' : 'text-gray-400'"
                            x-text="loadingText"></span>
                    </div>
                    <span class="text-sm font-bold tabular-nums"
                        :class="progress >= 100 ? 'text-emerald-500' : (darkMode ? 'text-gray-400' : 'text-gray-600')"
                        x-text="Math.round(progress) + '%'"></span>
                </div>
            </div>

            <!-- Loading Steps -->
            <div class="mt-8 flex items-center gap-6 animate-fade-slide-up" style="animation-delay: 0.6s">
                <template x-for="(step, index) in loadingSteps" :key="index">
                    <div class="flex items-center gap-2 text-xs"
                        :class="progress > step.threshold ? 'text-emerald-500' : (darkMode ? 'text-gray-600' : 'text-gray-400')">
                        <i :class="step.icon + ' ' + (progress > step.threshold ? 'animate-bounce' : '')"></i>
                        <span x-text="step.label" class="hidden sm:inline"></span>
                    </div>
                </template>
            </div>
        </div>

        <!-- Footer -->
        <div class="absolute bottom-6 text-center animate-fade-slide-up" style="animation-delay: 0.8s">
            <p class="text-xs" :class="darkMode ? 'text-gray-700' : 'text-gray-400'">
                &copy; {{ date('Y') }} KAP Budiandru & Rekan
            </p>
        </div>
    </div>

    <!-- ========== MAIN LAYOUT ========== -->
    <div x-show="!loading"
        x-transition:enter="transition ease-out duration-700"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        class="min-h-screen animate-page-enter">

        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="backdrop-blur-xl border-b transition-all duration-300"
                :class="darkMode ? 'bg-gray-900/60 border-gray-800/50' : 'bg-white/70 border-gray-200/50'">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <div :class="darkMode ? 'text-gray-100' : 'text-gray-800'">
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
        class="fixed inset-0 z-[90] pointer-events-none opacity-0 transition-all duration-500 flex items-center justify-center"
        :class="darkMode ? 'bg-[#030712]' : 'bg-white'">
        <div class="relative">
            <div class="w-16 h-16 border-4 border-emerald-500/20 border-t-emerald-500 rounded-full animate-spin"></div>
            <div class="absolute inset-0 w-16 h-16 border-4 border-cyan-500/20 border-b-cyan-500 rounded-full animate-spin" style="animation-direction: reverse; animation-duration: 1.5s;"></div>
        </div>
    </div>

    <script>
        function appLayout() {
            return {
                darkMode: localStorage.getItem('theme') === 'dark',
                loading: true,
                progress: 0,
                loadingText: 'Initializing',
                loadingSteps: [
                    { icon: 'fa-solid fa-server', label: 'Server', threshold: 25 },
                    { icon: 'fa-solid fa-database', label: 'Database', threshold: 50 },
                    { icon: 'fa-solid fa-shield-halved', label: 'Security', threshold: 75 },
                    { icon: 'fa-solid fa-check-circle', label: 'Ready', threshold: 100 }
                ],

                init() {
                    // Watch dark mode
                    this.$watch('darkMode', val => {
                        localStorage.setItem('theme', val ? 'dark' : 'light');
                        document.documentElement.classList.toggle('dark', val);
                    });
                    document.documentElement.classList.toggle('dark', this.darkMode);

                    // Simulate loading with realistic progress
                    this.simulateLoading();

                    // Setup page transitions
                    this.setupPageTransitions();
                },

                simulateLoading() {
                    const texts = ['Initializing', 'Loading assets', 'Connecting', 'Preparing dashboard', 'Almost ready'];
                    let textIndex = 0;

                    const interval = setInterval(() => {
                        // Non-linear progress for more realistic feel
                        const remaining = 100 - this.progress;
                        const increment = Math.random() * (remaining * 0.3) + 2;
                        this.progress = Math.min(this.progress + increment, 100);

                        // Update loading text
                        const newTextIndex = Math.floor(this.progress / 25);
                        if (newTextIndex !== textIndex && newTextIndex < texts.length) {
                            textIndex = newTextIndex;
                            this.loadingText = texts[textIndex];
                        }

                        // Complete loading
                        if (this.progress >= 100) {
                            clearInterval(interval);
                            this.loadingText = 'Welcome!';
                            setTimeout(() => {
                                this.loading = false;
                            }, 500);
                        }
                    }, 150);
                },

                setupPageTransitions() {
                    document.addEventListener("DOMContentLoaded", () => {
                        const transition = document.querySelector("#page-transition");

                        document.querySelectorAll("a").forEach(link => {
                            link.addEventListener("click", e => {
                                const href = link.getAttribute('href');

                                if (!href || href.startsWith("#") || href.startsWith("javascript:") || link.target === "_blank" || link.hasAttribute('download')) {
                                    return;
                                }

                                e.preventDefault();
                                transition.classList.remove('pointer-events-none', 'opacity-0');
                                transition.classList.add('opacity-100');

                                setTimeout(() => {
                                    window.location.href = href;
                                }, 400);
                            });
                        });
                    });
                }
            }
        }
    </script>
</body>

</html>
