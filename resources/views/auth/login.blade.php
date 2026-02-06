<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center relative overflow-hidden" x-data="loginPage()" x-init="init()">

        <!-- Light Animated Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 via-sky-100 to-teal-50">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_#a7f3d0,_#93c5fd,_#ccfbf1)] opacity-40 animate-[pulse_10s_ease-in-out_infinite]"></div>
        </div>

        <!-- Soft Floating Blobs -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-emerald-200/40 rounded-full blur-3xl animate-blob"></div>
            <div class="absolute top-1/2 -left-40 w-[500px] h-[500px] bg-cyan-200/30 rounded-full blur-3xl animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-40 right-1/3 w-80 h-80 bg-teal-200/35 rounded-full blur-3xl animate-blob animation-delay-4000"></div>
        </div>

        <!-- Login Card -->
        <div class="relative z-10 w-full max-w-[420px] mx-4">
            <!-- Card -->
            <div class="relative bg-white/70 backdrop-blur-2xl rounded-3xl border border-white/50 overflow-hidden shadow-xl shadow-emerald-500/5">
                <!-- Top Gradient Bar -->
                <div class="h-1 bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500"></div>

                <div class="relative p-8 sm:p-10">
                    <!-- Logo Section -->
                    <div class="text-center mb-10 animate-fade-up">
                        <!-- Logo Container -->
                        <div class="relative inline-block mb-6 group cursor-pointer">
                            <!-- Logo Box -->
                            <div class="relative w-20 h-20 rounded-2xl bg-white border border-gray-200 flex items-center justify-center shadow-lg overflow-hidden group-hover:scale-105 transition-transform duration-500">
                                <!-- Inner Glow on Hover -->
                                <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 to-cyan-50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                                <!-- Logo Image -->
                                <img src="{{ asset('images/logo.PNG') }}" alt="Logo" class="w-12 h-12 rounded-lg object-cover relative z-10">

                                <!-- Shine Effect -->
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/40 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                            </div>

                            <!-- Status Dot -->
                            <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 rounded-full border-2 border-white flex items-center justify-center">
                                <div class="w-2 h-2 bg-emerald-400 rounded-full animate-ping"></div>
                            </div>
                        </div>

                        <!-- Title -->
                        <h1 class="text-2xl font-bold text-gray-800 mb-2 tracking-tight">
                            KAP Budiandru <span class="text-emerald-500">&</span> Rekan
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
                            <label for="email" class="block text-sm font-medium text-gray-600">
                                Email Address
                            </label>
                            <div class="relative group">
                                <div class="relative flex items-center">
                                    <div class="absolute left-4 text-gray-400 group-focus-within:text-emerald-500 transition-colors duration-300">
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
                                        class="w-full pl-12 pr-4 py-4 bg-white/80 border border-gray-200 rounded-xl text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-400 transition-all duration-300"
                                        placeholder="name@company.com"
                                    >
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password Field -->
                        <div class="space-y-2 animate-fade-up" style="animation-delay: 0.2s" x-data="{ showPassword: false }">
                            <label for="password" class="block text-sm font-medium text-gray-600">
                                Password
                            </label>
                            <div class="relative group">
                                <div class="relative flex items-center">
                                    <div class="absolute left-4 text-gray-400 group-focus-within:text-emerald-500 transition-colors duration-300">
                                        <i class="fa-solid fa-lock"></i>
                                    </div>
                                    <input
                                        :type="showPassword ? 'text' : 'password'"
                                        id="password"
                                        name="password"
                                        required
                                        autocomplete="current-password"
                                        class="w-full pl-12 pr-14 py-4 bg-white/80 border border-gray-200 rounded-xl text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-400 transition-all duration-300"
                                        placeholder="Enter your password"
                                    >
                                    <button
                                        type="button"
                                        @click="showPassword = !showPassword"
                                        class="absolute right-4 text-gray-400 hover:text-gray-600 transition-colors"
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
                                    <div class="w-5 h-5 bg-white border border-gray-300 rounded-md peer-checked:bg-emerald-500 peer-checked:border-emerald-500 transition-all duration-300 flex items-center justify-center">
                                        <i class="fa-solid fa-check text-white text-xs opacity-0 peer-checked:opacity-100 transition-opacity"></i>
                                    </div>
                                </div>
                                <span class="ml-3 text-sm text-gray-500 group-hover:text-gray-700 transition-colors">Remember me</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm text-emerald-600 hover:text-emerald-500 transition-colors flex items-center gap-1">
                                    <span>Forgot password?</span>
                                </a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <div class="animate-fade-up" style="animation-delay: 0.4s">
                            <button type="submit" class="relative w-full group overflow-hidden">
                                <!-- Button -->
                                <div class="relative w-full px-6 py-4 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-xl text-white font-semibold flex items-center justify-center gap-3 hover:from-emerald-600 hover:to-teal-600 transition-all duration-300 shadow-lg shadow-emerald-500/20 hover:shadow-xl hover:shadow-emerald-500/30 hover:-translate-y-0.5 overflow-hidden">
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
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center">
                            <span class="px-4 bg-white/70 text-gray-400 text-xs uppercase tracking-widest">Secure Access</span>
                        </div>
                    </div>

                    <!-- Security Features -->
                    <div class="grid grid-cols-3 gap-4 animate-fade-up" style="animation-delay: 0.6s">
                        <div class="text-center group cursor-pointer">
                            <div class="w-10 h-10 mx-auto mb-2 rounded-lg bg-emerald-50 border border-emerald-200 flex items-center justify-center group-hover:bg-emerald-100 transition-all duration-300">
                                <i class="fa-solid fa-shield-halved text-emerald-500 text-sm"></i>
                            </div>
                            <p class="text-[10px] text-gray-500 group-hover:text-gray-700 transition-colors">SSL 256-bit</p>
                        </div>
                        <div class="text-center group cursor-pointer">
                            <div class="w-10 h-10 mx-auto mb-2 rounded-lg bg-cyan-50 border border-cyan-200 flex items-center justify-center group-hover:bg-cyan-100 transition-all duration-300">
                                <i class="fa-solid fa-fingerprint text-cyan-500 text-sm"></i>
                            </div>
                            <p class="text-[10px] text-gray-500 group-hover:text-gray-700 transition-colors">Biometric</p>
                        </div>
                        <div class="text-center group cursor-pointer">
                            <div class="w-10 h-10 mx-auto mb-2 rounded-lg bg-violet-50 border border-violet-200 flex items-center justify-center group-hover:bg-violet-100 transition-all duration-300">
                                <i class="fa-solid fa-lock text-violet-500 text-sm"></i>
                            </div>
                            <p class="text-[10px] text-gray-500 group-hover:text-gray-700 transition-colors">Encrypted</p>
                        </div>
                    </div>
                </div>

                <!-- Card Footer -->
                <div class="px-8 py-4 bg-gray-50/50 border-t border-gray-100">
                    <p class="text-center text-gray-400 text-xs flex items-center justify-center gap-2">
                        <i class="fa-solid fa-clock text-gray-300"></i>
                        <span x-text="currentTime"></span>
                        <span class="text-gray-300">|</span>
                        <span>Session Timeout: 30 min</span>
                    </p>
                </div>
            </div>

            <!-- Footer -->
            <p class="text-center text-gray-400 text-xs mt-8 animate-fade-up" style="animation-delay: 0.7s">
                &copy; {{ date('Y') }} KAP Budiandru & Rekan. All rights reserved.
            </p>
        </div>
    </div>

    <style>
        /* Blob Animation */
        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(20px, -30px) scale(1.05); }
            50% { transform: translate(-15px, 15px) scale(0.95); }
            75% { transform: translate(25px, 10px) scale(1.02); }
        }
        .animate-blob { animation: blob 20s ease-in-out infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }

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
