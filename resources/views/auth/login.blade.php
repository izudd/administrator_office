<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-emerald-50 via-sky-100 to-amber-50 relative overflow-hidden">

        <!-- Animated background -->
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_#a7f3d0,_#93c5fd,_#fef9c3)] opacity-50 animate-[pulse_10s_ease-in-out_infinite]"></div>

        <!-- Glass Card -->
        <div class="relative z-10 w-full max-w-md px-8 py-10 glass rounded-2xl shadow-xl border border-white/40 fade-in">
            <div class="text-center mb-8 fade-in" style="animation-delay: 0.2s;">
                <img src="{{ asset('images/logo.PNG') }}" alt="Logo"
                    class="w-20 h-auto mx-auto mb-4 rounded-lg drop-shadow-md">
                <h1 class="text-2xl font-semibold text-gray-800">KAP Budiandru & Rekan</h1>
                <p class="text-sm text-gray-600">Administrator Login Portal</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5 fade-in" style="animation-delay: 0.4s;">
                @csrf

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-gray-700" />
                    <x-text-input id="email" type="email" name="email"
                        class="mt-1 w-full bg-white/80 border border-gray-300 rounded-lg text-gray-700 placeholder-gray-400 focus:ring-emerald-400 focus:border-emerald-400 transition-all"
                        :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" class="text-gray-700" />
                    <x-text-input id="password" type="password" name="password" required autocomplete="current-password"
                        class="mt-1 w-full bg-white/80 border border-gray-300 rounded-lg text-gray-700 placeholder-gray-400 focus:ring-emerald-400 focus:border-emerald-400 transition-all" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
                </div>

                <!-- Remember Me + Forgot -->
                <div class="flex items-center justify-between text-sm fade-in" style="animation-delay: 0.6s;">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                            class="rounded border-gray-300 text-emerald-500 shadow-sm focus:ring-emerald-400"
                            name="remember">
                        <span class="ml-2 text-gray-700">{{ __('Remember me') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-emerald-600 hover:text-emerald-700 font-medium"
                            href="{{ route('password.request') }}">
                            {{ __('Forgot Password?') }}
                        </a>
                    @endif
                </div>

                <!-- Button -->
                <div class="pt-4 fade-in" style="animation-delay: 0.8s;">
                    <x-primary-button
                        class="w-full justify-center bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-3 rounded-xl transition-all hover:shadow-lg hover:shadow-emerald-400/40 transform hover:-translate-y-0.5">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>

            <!-- Register -->
            @if (Route::has('register'))
                <p class="mt-6 text-center text-sm text-gray-600 fade-in" style="animation-delay: 1s;">
                    Don’t have an account?
                    <a href="{{ route('register') }}" class="text-emerald-600 hover:underline font-medium">Register here</a>
                </p>
            @endif
        </div>

        <style>
            .glass {
                background: rgba(255, 255, 255, 0.65);
                backdrop-filter: blur(20px);
            }

            @keyframes pulse {
                0%, 100% {
                    opacity: 0.4;
                }

                50% {
                    opacity: 0.6;
                }
            }

            .fade-in {
                opacity: 0;
                transform: translateY(20px);
                animation: fadeInUp 1s ease forwards;
            }

            @keyframes fadeInUp {
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>
    </div>
</x-guest-layout>
