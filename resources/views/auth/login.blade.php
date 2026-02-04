<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center relative overflow-hidden">

        <!-- Animated Dark Gradient Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950"></div>

        <!-- Animated Mesh Gradient -->
        <div class="absolute inset-0 opacity-30">
            <div class="absolute top-0 -left-40 w-80 h-80 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl animate-blob"></div>
            <div class="absolute top-0 -right-40 w-80 h-80 bg-cyan-500 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-40 left-20 w-80 h-80 bg-emerald-500 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-4000"></div>
        </div>

        <!-- Grid Pattern Overlay -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGQ9Ik0wIDBoNjB2NjBIMHoiLz48cGF0aCBkPSJNMzYgMzRoLTJ2LTRoMnY0em0wLTZoLTJ2LTRoMnY0em0tNiA2aC0ydi00aDJ2NHptMC02aC0ydi00aDJ2NHptLTYgNmgtMnYtNGgydjR6bTAtNmgtMnYtNGgydjR6IiBmaWxsPSJyZ2JhKDI1NSwyNTUsMjU1LDAuMDIpIi8+PC9nPjwvc3ZnPg==')] opacity-40"></div>

        <!-- Floating Particles -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="particle particle-1"></div>
            <div class="particle particle-2"></div>
            <div class="particle particle-3"></div>
            <div class="particle particle-4"></div>
            <div class="particle particle-5"></div>
        </div>

        <!-- Login Card -->
        <div class="relative z-10 w-full max-w-md mx-4">
            <!-- Glow Effect Behind Card -->
            <div class="absolute -inset-1 bg-gradient-to-r from-emerald-500 via-cyan-500 to-purple-500 rounded-3xl blur-xl opacity-20 group-hover:opacity-30 transition duration-1000"></div>

            <div class="relative bg-slate-900/80 backdrop-blur-2xl rounded-3xl shadow-2xl border border-slate-700/50 overflow-hidden">
                <!-- Top Gradient Bar -->
                <div class="h-1 bg-gradient-to-r from-emerald-500 via-cyan-500 to-purple-500"></div>

                <div class="p-8 sm:p-10">
                    <!-- Logo & Title -->
                    <div class="text-center mb-8 animate-fade-in">
                        <div class="relative inline-block mb-6">
                            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500 to-cyan-500 rounded-2xl blur-lg opacity-50"></div>
                            <div class="relative w-20 h-20 bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl flex items-center justify-center border border-slate-700 shadow-xl">
                                <img src="{{ asset('images/logo.PNG') }}" alt="Logo" class="w-12 h-12 rounded-lg object-cover">
                            </div>
                        </div>
                        <h1 class="text-2xl font-bold text-white mb-2">KAP Budiandru & Rekan</h1>
                        <p class="text-slate-400 text-sm">Administrator Portal</p>
                    </div>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- Email -->
                        <div class="animate-fade-in animation-delay-200">
                            <label for="email" class="block text-sm font-medium text-slate-300 mb-2">
                                Email Address
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-envelope text-slate-500 group-focus-within:text-emerald-400 transition-colors"></i>
                                </div>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                    class="w-full pl-12 pr-4 py-3.5 bg-slate-800/50 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all duration-200"
                                    placeholder="name@company.com">
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="animate-fade-in animation-delay-400" x-data="{ show: false }">
                            <label for="password" class="block text-sm font-medium text-slate-300 mb-2">
                                Password
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-lock text-slate-500 group-focus-within:text-emerald-400 transition-colors"></i>
                                </div>
                                <input :type="show ? 'text' : 'password'" id="password" name="password" required autocomplete="current-password"
                                    class="w-full pl-12 pr-12 py-3.5 bg-slate-800/50 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all duration-200"
                                    placeholder="Enter your password">
                                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center">
                                    <i class="fa-solid text-slate-500 hover:text-slate-300 transition-colors" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Remember & Forgot -->
                        <div class="flex items-center justify-between animate-fade-in animation-delay-600">
                            <label for="remember_me" class="flex items-center cursor-pointer group">
                                <div class="relative">
                                    <input id="remember_me" type="checkbox" name="remember" class="sr-only peer">
                                    <div class="w-5 h-5 border-2 border-slate-600 rounded-md peer-checked:bg-emerald-500 peer-checked:border-emerald-500 transition-all"></div>
                                    <i class="fa-solid fa-check absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-white text-xs opacity-0 peer-checked:opacity-100 transition-opacity"></i>
                                </div>
                                <span class="ml-3 text-sm text-slate-400 group-hover:text-slate-300 transition-colors">Remember me</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm text-emerald-400 hover:text-emerald-300 transition-colors">
                                    Forgot password?
                                </a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <div class="animate-fade-in animation-delay-800">
                            <button type="submit" class="relative w-full group">
                                <div class="absolute -inset-0.5 bg-gradient-to-r from-emerald-500 to-cyan-500 rounded-xl blur opacity-60 group-hover:opacity-100 transition duration-200"></div>
                                <div class="relative w-full px-6 py-3.5 bg-gradient-to-r from-emerald-600 to-cyan-600 hover:from-emerald-500 hover:to-cyan-500 rounded-xl text-white font-semibold transition-all duration-200 flex items-center justify-center gap-2">
                                    <span>Sign In</span>
                                    <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                                </div>
                            </button>
                        </div>
                    </form>

                    <!-- Divider -->
                    <div class="relative my-8 animate-fade-in animation-delay-1000">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-slate-700"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-slate-900/80 text-slate-500">Secure Login</span>
                        </div>
                    </div>

                    <!-- Security Badge -->
                    <div class="flex items-center justify-center gap-3 text-slate-500 text-xs animate-fade-in animation-delay-1000">
                        <i class="fa-solid fa-shield-halved text-emerald-500"></i>
                        <span>256-bit SSL Encryption</span>
                        <span class="text-slate-700">•</span>
                        <i class="fa-solid fa-lock text-emerald-500"></i>
                        <span>Secure Connection</span>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <p class="text-center text-slate-600 text-xs mt-8 animate-fade-in animation-delay-1000">
                © {{ date('Y') }} KAP Budiandru & Rekan. All rights reserved.
            </p>
        </div>
    </div>

    <style>
        /* Blob Animation */
        @keyframes blob {
            0%, 100% { transform: translate(0px, 0px) scale(1); }
            25% { transform: translate(20px, -30px) scale(1.1); }
            50% { transform: translate(-20px, 20px) scale(0.9); }
            75% { transform: translate(30px, 10px) scale(1.05); }
        }
        .animate-blob { animation: blob 10s ease-in-out infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }

        /* Fade In Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            opacity: 0;
            animation: fadeIn 0.8s ease forwards;
        }
        .animation-delay-200 { animation-delay: 0.2s; }
        .animation-delay-400 { animation-delay: 0.4s; }
        .animation-delay-600 { animation-delay: 0.6s; }
        .animation-delay-800 { animation-delay: 0.8s; }
        .animation-delay-1000 { animation-delay: 1s; }

        /* Floating Particles */
        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(16, 185, 129, 0.6);
            border-radius: 50%;
            animation: float 15s infinite;
        }
        .particle-1 { left: 10%; top: 20%; animation-delay: 0s; }
        .particle-2 { left: 80%; top: 30%; animation-delay: 3s; }
        .particle-3 { left: 30%; top: 70%; animation-delay: 6s; }
        .particle-4 { left: 70%; top: 80%; animation-delay: 9s; }
        .particle-5 { left: 50%; top: 50%; animation-delay: 12s; }

        @keyframes float {
            0%, 100% { transform: translateY(0px) translateX(0px); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100vh) translateX(50px); opacity: 0; }
        }
    </style>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</x-guest-layout>
