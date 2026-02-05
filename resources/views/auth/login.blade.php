<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center relative overflow-hidden" x-data="loginPage()" x-init="init()">

        <!-- Ultra Premium Animated Background -->
        <div class="absolute inset-0 bg-[#030712]">
            <!-- Gradient Mesh -->
            <div class="absolute inset-0">
                <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-violet-950/50 via-transparent to-cyan-950/50"></div>
                <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-tr from-emerald-950/30 via-transparent to-purple-950/30"></div>
            </div>

            <!-- Animated Orbs -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="orb orb-1"></div>
                <div class="orb orb-2"></div>
                <div class="orb orb-3"></div>
                <div class="orb orb-4"></div>
            </div>

            <!-- Grid Lines -->
            <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:50px_50px] [mask-image:radial-gradient(ellipse_at_center,black_20%,transparent_70%)]"></div>

            <!-- Floating Particles -->
            <div class="particles">
                <template x-for="i in 30" :key="i">
                    <div class="particle-dot" :style="`left: ${Math.random() * 100}%; animation-delay: ${Math.random() * 20}s; animation-duration: ${15 + Math.random() * 20}s`"></div>
                </template>
            </div>

            <!-- Aurora Effect -->
            <div class="absolute inset-0 opacity-30">
                <div class="aurora aurora-1"></div>
                <div class="aurora aurora-2"></div>
            </div>
        </div>

        <!-- Vignette Overlay -->
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,transparent_0%,rgba(0,0,0,0.4)_100%)]"></div>

        <!-- Login Card -->
        <div class="relative z-10 w-full max-w-[420px] mx-4">
            <!-- Card Glow -->
            <div class="absolute -inset-[2px] bg-gradient-to-r from-emerald-500 via-cyan-500 to-violet-500 rounded-[28px] opacity-20 blur-xl animate-glow"></div>
            <div class="absolute -inset-[1px] bg-gradient-to-r from-emerald-500 via-cyan-500 to-violet-500 rounded-[26px] opacity-40"></div>

            <!-- Card -->
            <div class="relative bg-gray-950/80 backdrop-blur-2xl rounded-3xl border border-white/10 overflow-hidden shadow-2xl">
                <!-- Animated Top Border -->
                <div class="h-[2px] bg-gradient-to-r from-transparent via-emerald-500 to-transparent animate-border-flow"></div>

                <!-- Noise Texture -->
                <div class="absolute inset-0 opacity-[0.015] bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMDAiIGhlaWdodD0iMzAwIj48ZmlsdGVyIGlkPSJhIiB4PSIwIiB5PSIwIj48ZmVUdXJidWxlbmNlIGJhc2VGcmVxdWVuY3k9Ii43NSIgc3RpdGNoVGlsZXM9InN0aXRjaCIgdHlwZT0iZnJhY3RhbE5vaXNlIi8+PC9maWx0ZXI+PHJlY3Qgd2lkdGg9IjMwMCIgaGVpZ2h0PSIzMDAiIGZpbHRlcj0idXJsKCNhKSIgb3BhY2l0eT0iMSIvPjwvc3ZnPg==')]"></div>

                <div class="relative p-8 sm:p-10">
                    <!-- Logo Section -->
                    <div class="text-center mb-10" :class="{ 'animate-fade-up': loaded }">
                        <!-- Logo Container -->
                        <div class="relative inline-block mb-6 group cursor-pointer" @mouseenter="logoHover = true" @mouseleave="logoHover = false">
                            <!-- Outer Ring -->
                            <div class="absolute -inset-3 rounded-2xl border border-emerald-500/20 animate-spin-slow"></div>

                            <!-- Glow Rings -->
                            <div class="absolute -inset-4 bg-gradient-to-r from-emerald-500/20 via-cyan-500/20 to-violet-500/20 rounded-3xl blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>

                            <!-- Logo Box -->
                            <div class="relative w-20 h-20 rounded-2xl bg-gradient-to-br from-gray-800 to-gray-900 border border-white/10 flex items-center justify-center shadow-2xl overflow-hidden group-hover:scale-105 transition-transform duration-500">
                                <!-- Inner Glow -->
                                <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/10 to-cyan-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                                <!-- Logo Image -->
                                <img src="{{ asset('images/logo.PNG') }}" alt="Logo" class="w-12 h-12 rounded-lg object-cover relative z-10">

                                <!-- Shine Effect -->
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                            </div>

                            <!-- Status Dot -->
                            <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 rounded-full border-2 border-gray-950 flex items-center justify-center">
                                <div class="w-2 h-2 bg-emerald-400 rounded-full animate-ping"></div>
                            </div>
                        </div>

                        <!-- Title -->
                        <h1 class="text-2xl font-bold text-white mb-2 tracking-tight">
                            <span class="bg-gradient-to-r from-white via-gray-200 to-gray-400 bg-clip-text text-transparent">KAP Budiandru</span>
                            <span class="text-emerald-400">&</span>
                            <span class="bg-gradient-to-r from-gray-400 via-gray-200 to-white bg-clip-text text-transparent">Rekan</span>
                        </h1>
                        <p class="text-gray-500 text-sm flex items-center justify-center gap-2">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                            Administrator Portal
                        </p>
                    </div>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <!-- Form -->
                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- Email Field -->
                        <div class="space-y-2 animate-fade-up" style="animation-delay: 0.1s">
                            <label for="email" class="block text-sm font-medium text-gray-400">
                                Email Address
                            </label>
                            <div class="relative group">
                                <!-- Input Glow -->
                                <div class="absolute -inset-[1px] bg-gradient-to-r from-emerald-500/50 to-cyan-500/50 rounded-xl opacity-0 group-focus-within:opacity-100 blur transition-opacity duration-300"></div>

                                <div class="relative flex items-center">
                                    <div class="absolute left-4 text-gray-500 group-focus-within:text-emerald-400 transition-colors duration-300">
                                        <i class="fa-solid fa-envelope"></i>
                                    </div>
                                    <input
                                        id="email"
                                        type="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        required
                                        autofocus
                                        autocomplete="username"
                                        class="w-full pl-12 pr-4 py-4 bg-gray-900/50 border border-white/10 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:border-emerald-500/50 focus:bg-gray-900/80 transition-all duration-300"
                                        placeholder="name@company.com"
                                    >
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password Field -->
                        <div class="space-y-2 animate-fade-up" style="animation-delay: 0.2s" x-data="{ showPassword: false }">
                            <label for="password" class="block text-sm font-medium text-gray-400">
                                Password
                            </label>
                            <div class="relative group">
                                <!-- Input Glow -->
                                <div class="absolute -inset-[1px] bg-gradient-to-r from-emerald-500/50 to-cyan-500/50 rounded-xl opacity-0 group-focus-within:opacity-100 blur transition-opacity duration-300"></div>

                                <div class="relative flex items-center">
                                    <div class="absolute left-4 text-gray-500 group-focus-within:text-emerald-400 transition-colors duration-300">
                                        <i class="fa-solid fa-lock"></i>
                                    </div>
                                    <input
                                        :type="showPassword ? 'text' : 'password'"
                                        id="password"
                                        name="password"
                                        required
                                        autocomplete="current-password"
                                        class="w-full pl-12 pr-14 py-4 bg-gray-900/50 border border-white/10 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:border-emerald-500/50 focus:bg-gray-900/80 transition-all duration-300"
                                        placeholder="Enter your password"
                                    >
                                    <button
                                        type="button"
                                        @click="showPassword = !showPassword"
                                        class="absolute right-4 text-gray-500 hover:text-gray-300 transition-colors"
                                    >
                                        <i :class="showPassword ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                                    </button>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Remember & Forgot -->
                        <div class="flex items-center justify-between animate-fade-up" style="animation-delay: 0.3s">
                            <label for="remember_me" class="flex items-center cursor-pointer group">
                                <div class="relative">
                                    <input id="remember_me" type="checkbox" name="remember" class="sr-only peer">
                                    <div class="w-5 h-5 bg-gray-900 border border-white/10 rounded-md peer-checked:bg-emerald-500 peer-checked:border-emerald-500 transition-all duration-300 flex items-center justify-center">
                                        <i class="fa-solid fa-check text-white text-xs opacity-0 peer-checked:opacity-100 transition-opacity"></i>
                                    </div>
                                </div>
                                <span class="ml-3 text-sm text-gray-500 group-hover:text-gray-400 transition-colors">Remember me</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm text-emerald-500 hover:text-emerald-400 transition-colors flex items-center gap-1">
                                    <span>Forgot password?</span>
                                </a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <div class="animate-fade-up" style="animation-delay: 0.4s">
                            <button type="submit" class="relative w-full group overflow-hidden">
                                <!-- Button Glow -->
                                <div class="absolute -inset-1 bg-gradient-to-r from-emerald-600 via-cyan-600 to-emerald-600 rounded-xl blur opacity-40 group-hover:opacity-70 transition-opacity duration-500 animate-gradient-x"></div>

                                <!-- Button -->
                                <div class="relative w-full px-6 py-4 bg-gradient-to-r from-emerald-600 to-cyan-600 rounded-xl text-white font-semibold flex items-center justify-center gap-3 group-hover:from-emerald-500 group-hover:to-cyan-500 transition-all duration-300 overflow-hidden">
                                    <!-- Shine Effect -->
                                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>

                                    <span class="relative">Sign In</span>
                                    <i class="fa-solid fa-arrow-right relative group-hover:translate-x-1 transition-transform duration-300"></i>
                                </div>
                            </button>
                        </div>
                    </form>

                    <!-- Divider -->
                    <div class="relative my-8 animate-fade-up" style="animation-delay: 0.5s">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-white/5"></div>
                        </div>
                        <div class="relative flex justify-center">
                            <span class="px-4 bg-gray-950/80 text-gray-600 text-xs uppercase tracking-widest">Secure Access</span>
                        </div>
                    </div>

                    <!-- Security Features -->
                    <div class="grid grid-cols-3 gap-4 animate-fade-up" style="animation-delay: 0.6s">
                        <div class="text-center group cursor-pointer">
                            <div class="w-10 h-10 mx-auto mb-2 rounded-lg bg-gray-900/50 border border-white/5 flex items-center justify-center group-hover:border-emerald-500/30 group-hover:bg-emerald-500/5 transition-all duration-300">
                                <i class="fa-solid fa-shield-halved text-emerald-500 text-sm"></i>
                            </div>
                            <p class="text-[10px] text-gray-600 group-hover:text-gray-500 transition-colors">SSL 256-bit</p>
                        </div>
                        <div class="text-center group cursor-pointer">
                            <div class="w-10 h-10 mx-auto mb-2 rounded-lg bg-gray-900/50 border border-white/5 flex items-center justify-center group-hover:border-cyan-500/30 group-hover:bg-cyan-500/5 transition-all duration-300">
                                <i class="fa-solid fa-fingerprint text-cyan-500 text-sm"></i>
                            </div>
                            <p class="text-[10px] text-gray-600 group-hover:text-gray-500 transition-colors">Biometric</p>
                        </div>
                        <div class="text-center group cursor-pointer">
                            <div class="w-10 h-10 mx-auto mb-2 rounded-lg bg-gray-900/50 border border-white/5 flex items-center justify-center group-hover:border-violet-500/30 group-hover:bg-violet-500/5 transition-all duration-300">
                                <i class="fa-solid fa-lock text-violet-500 text-sm"></i>
                            </div>
                            <p class="text-[10px] text-gray-600 group-hover:text-gray-500 transition-colors">Encrypted</p>
                        </div>
                    </div>
                </div>

                <!-- Card Footer -->
                <div class="px-8 py-4 bg-gray-900/30 border-t border-white/5">
                    <p class="text-center text-gray-600 text-xs flex items-center justify-center gap-2">
                        <i class="fa-solid fa-clock text-gray-700"></i>
                        <span x-text="currentTime"></span>
                        <span class="text-gray-700">•</span>
                        <span>Session Timeout: 30 min</span>
                    </p>
                </div>
            </div>

            <!-- Footer -->
            <p class="text-center text-gray-700 text-xs mt-8 animate-fade-up" style="animation-delay: 0.7s">
                © {{ date('Y') }} KAP Budiandru & Rekan. All rights reserved.
            </p>
        </div>
    </div>

    <style>
        /* Orb Animations */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.5;
            animation: orb-float 20s ease-in-out infinite;
        }
        .orb-1 {
            width: 600px; height: 600px;
            background: linear-gradient(135deg, #10b981 0%, #06b6d4 100%);
            top: -200px; left: -200px;
            animation-delay: 0s;
        }
        .orb-2 {
            width: 500px; height: 500px;
            background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
            top: 50%; right: -150px;
            animation-delay: -5s;
        }
        .orb-3 {
            width: 400px; height: 400px;
            background: linear-gradient(135deg, #06b6d4 0%, #10b981 100%);
            bottom: -100px; left: 30%;
            animation-delay: -10s;
        }
        .orb-4 {
            width: 300px; height: 300px;
            background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);
            top: 30%; left: 20%;
            opacity: 0.2;
            animation-delay: -15s;
        }

        @keyframes orb-float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(50px, -50px) scale(1.1); }
            50% { transform: translate(-30px, 30px) scale(0.9); }
            75% { transform: translate(40px, 20px) scale(1.05); }
        }

        /* Aurora Effect */
        .aurora {
            position: absolute;
            width: 200%;
            height: 200%;
            background: linear-gradient(135deg,
                transparent 0%,
                rgba(16, 185, 129, 0.1) 25%,
                transparent 50%,
                rgba(6, 182, 212, 0.1) 75%,
                transparent 100%
            );
            animation: aurora-move 15s linear infinite;
        }
        .aurora-1 { top: -50%; left: -50%; }
        .aurora-2 { top: -50%; left: -50%; animation-delay: -7.5s; animation-direction: reverse; }

        @keyframes aurora-move {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Particle Dots */
        .particles { position: absolute; inset: 0; overflow: hidden; }
        .particle-dot {
            position: absolute;
            width: 2px; height: 2px;
            background: rgba(16, 185, 129, 0.6);
            border-radius: 50%;
            bottom: -10px;
            animation: particle-rise linear infinite;
        }
        @keyframes particle-rise {
            0% { transform: translateY(0) scale(1); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100vh) scale(0); opacity: 0; }
        }

        /* Glow Animation */
        @keyframes glow {
            0%, 100% { opacity: 0.2; }
            50% { opacity: 0.4; }
        }
        .animate-glow { animation: glow 3s ease-in-out infinite; }

        /* Border Flow */
        @keyframes border-flow {
            0% { background-position: 0% 50%; }
            100% { background-position: 200% 50%; }
        }
        .animate-border-flow {
            background-size: 200% 100%;
            animation: border-flow 3s linear infinite;
        }

        /* Gradient X */
        @keyframes gradient-x {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .animate-gradient-x {
            background-size: 200% 200%;
            animation: gradient-x 3s ease infinite;
        }

        /* Spin Slow */
        @keyframes spin-slow {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .animate-spin-slow { animation: spin-slow 20s linear infinite; }

        /* Fade Up */
        @keyframes fade-up {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-up {
            opacity: 0;
            animation: fade-up 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script>
        function loginPage() {
            return {
                loaded: false,
                logoHover: false,
                currentTime: '',
                init() {
                    this.loaded = true;
                    this.updateTime();
                    setInterval(() => this.updateTime(), 1000);
                },
                updateTime() {
                    const now = new Date();
                    this.currentTime = now.toLocaleTimeString('en-US', {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: true
                    });
                }
            }
        }
    </script>
</x-guest-layout>
