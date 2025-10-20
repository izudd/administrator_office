<x-guest-layout>
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-emerald-50 via-sky-100 to-amber-50 relative overflow-hidden">

        <!-- Animated gradient background -->
        <div
            class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_#a7f3d0,_#93c5fd,_#fef9c3)] opacity-50 animate-[pulse_10s_ease-in-out_infinite]">
        </div>

        <!-- Glass container -->
        <div class="relative z-10 w-full max-w-md px-8 py-10 glass rounded-2xl shadow-xl border border-white/40 fade-in">
            <div class="text-center mb-8 fade-in" style="animation-delay: 0.2s;">
                <img src="{{ asset('images/logo.PNG') }}" alt="Logo"
                    class="w-20 h-auto mx-auto mb-4 rounded-lg drop-shadow-md">
                <h1 class="text-2xl font-semibold text-gray-800">Create Your Account</h1>
                <p class="text-sm text-gray-600">Join <span class="text-emerald-600 font-medium">KAP Budiandru &
                        Rekan</span> Administrator Portal</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-5 fade-in"
                style="animation-delay: 0.4s;">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Full Name')" class="text-gray-700" />
                    <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus
                        autocomplete="name"
                        class="mt-1 w-full bg-white/80 border border-gray-300 rounded-lg text-gray-700 placeholder-gray-400 focus:ring-emerald-400 focus:border-emerald-400 transition-all" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-gray-700" />
                    <x-text-input id="email" type="email" name="email" :value="old('email')" required
                        autocomplete="username"
                        class="mt-1 w-full bg-white/80 border border-gray-300 rounded-lg text-gray-700 focus:ring-emerald-400 focus:border-emerald-400 transition-all" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" class="text-gray-700" />
                    <x-text-input id="password" type="password" name="password" required autocomplete="new-password"
                        class="mt-1 w-full bg-white/80 border border-gray-300 rounded-lg text-gray-700 focus:ring-emerald-400 focus:border-emerald-400 transition-all" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700" />
                    <x-text-input id="password_confirmation" type="password" name="password_confirmation" required
                        autocomplete="new-password"
                        class="mt-1 w-full bg-white/80 border border-gray-300 rounded-lg text-gray-700 focus:ring-emerald-400 focus:border-emerald-400 transition-all" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500" />
                </div>

                <!-- Invite Code -->
                <div>
                    <x-input-label for="invite_code" :value="__('Invite Code')" class="text-gray-700" />
                    <x-text-input id="invite_code" type="text" name="invite_code"
                        class="mt-1 w-full bg-white/80 border border-gray-300 rounded-lg text-gray-700" required />
                    <x-input-error :messages="$errors->get('invite_code')" class="mt-2 text-red-500" />
                </div>


                <!-- Submit -->
                <div class="pt-4 fade-in" style="animation-delay: 0.6s;">
                    <x-primary-button
                        class="w-full justify-center bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-3 rounded-xl transition-all hover:shadow-lg hover:shadow-emerald-400/40 transform hover:-translate-y-0.5">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>

            <!-- Login redirect -->
            <p class="mt-6 text-center text-sm text-gray-600 fade-in" style="animation-delay: 0.8s;">
                Already have an account?
                <a href="{{ route('login') }}" class="text-emerald-600 hover:underline font-medium">Log in here</a>
            </p>
        </div>

        <style>
            .glass {
                background: rgba(255, 255, 255, 0.65);
                backdrop-filter: blur(20px);
            }

            @keyframes pulse {

                0%,
                100% {
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
