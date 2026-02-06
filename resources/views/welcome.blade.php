<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>KAP Budiandru & Rekan | Administrator Portal</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.PNG') }}">

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Animations */
        @keyframes fade-up {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-up {
            animation: fade-up 0.8s ease-out forwards;
            opacity: 0;
        }

        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
        .delay-500 { animation-delay: 0.5s; }
        .delay-600 { animation-delay: 0.6s; }

        /* Card Hover */
        .feature-card {
            transition: all 0.4s ease;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px rgba(16, 185, 129, 0.1);
        }

        /* Smooth scroll */
        html { scroll-behavior: smooth; }

        /* Floating animation */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }

        /* Blob animation */
        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(20px, -30px) scale(1.05); }
            50% { transform: translate(-15px, 15px) scale(0.95); }
            75% { transform: translate(25px, 10px) scale(1.02); }
        }
        .animate-blob { animation: blob 20s ease-in-out infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
    </style>
</head>

<body class="antialiased bg-gradient-to-br from-slate-50 via-white to-emerald-50 text-gray-800">
    <!-- Soft Animated Background -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-emerald-200/30 rounded-full blur-3xl animate-blob"></div>
        <div class="absolute top-1/2 -left-40 w-[500px] h-[500px] bg-cyan-200/20 rounded-full blur-3xl animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-40 right-1/3 w-96 h-96 bg-teal-200/25 rounded-full blur-3xl animate-blob animation-delay-4000"></div>
    </div>

    <!-- Navigation -->
    <header class="fixed top-0 left-0 right-0 z-50">
        <nav class="bg-white/70 backdrop-blur-xl border-b border-gray-200/50 shadow-sm">
            <div class="max-w-7xl mx-auto px-6 py-4">
                <div class="flex justify-between items-center">
                    <!-- Logo -->
                    <div class="flex items-center gap-3 animate-fade-up">
                        <div class="relative">
                            <div class="absolute inset-0 bg-emerald-500 rounded-xl blur-lg opacity-20"></div>
                            <img src="{{ asset('images/logo.PNG') }}" alt="Logo" class="relative w-10 h-10 object-contain rounded-xl shadow-md" />
                        </div>
                        <div>
                            <h1 class="text-lg font-bold text-gray-800">KAP Budiandru</h1>
                            <p class="text-xs text-gray-500">& Rekan</p>
                        </div>
                    </div>

                    <!-- Nav Links -->
                    <div class="hidden md:flex items-center gap-8 animate-fade-up delay-100">
                        <a href="#home" class="text-sm text-gray-600 hover:text-emerald-600 transition-colors font-medium">Home</a>
                        <a href="#about" class="text-sm text-gray-600 hover:text-emerald-600 transition-colors font-medium">About</a>
                        <a href="#services" class="text-sm text-gray-600 hover:text-emerald-600 transition-colors font-medium">Services</a>
                        <a href="#contact" class="text-sm text-gray-600 hover:text-emerald-600 transition-colors font-medium">Contact</a>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="flex items-center gap-3 animate-fade-up delay-200">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                    class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-semibold text-sm hover:shadow-lg hover:shadow-emerald-500/20 transition-all">
                                    <i class="fa-solid fa-gauge-high mr-2"></i>Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="px-5 py-2.5 rounded-xl text-gray-600 hover:text-emerald-600 text-sm font-medium transition-colors">
                                    Login
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-semibold text-sm hover:shadow-lg hover:shadow-emerald-500/20 transition-all">
                                        Get Started
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section id="home" class="min-h-screen flex items-center justify-center pt-20 px-6">
        <div class="max-w-5xl mx-auto text-center">
            <!-- Badge -->
            <div class="animate-fade-up inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-50 border border-emerald-200 mb-8">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                <span class="text-sm text-emerald-700 font-medium">Trusted Accounting Partner Since 2016</span>
            </div>

            <!-- Main Heading -->
            <h1 class="animate-fade-up delay-100 text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold mb-6 leading-tight">
                <span class="text-gray-800">Welcome to</span><br>
                <span class="bg-gradient-to-r from-emerald-600 via-teal-500 to-cyan-600 bg-clip-text text-transparent">Administrator Portal</span>
            </h1>

            <!-- Subtitle -->
            <p class="animate-fade-up delay-200 text-lg sm:text-xl text-gray-500 max-w-2xl mx-auto mb-10 leading-relaxed">
                Manage financial reports, audits, and internal data of
                <span class="text-emerald-600 font-semibold">KAP Budiandru & Rekan</span>
                securely and efficiently with our modern platform.
            </p>

            <!-- CTA Buttons -->
            <div class="animate-fade-up delay-300 flex flex-col sm:flex-row gap-4 justify-center">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="px-8 py-4 rounded-2xl bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 text-white font-bold text-lg shadow-xl hover:shadow-emerald-500/25 hover:-translate-y-1 transition-all">
                            <i class="fa-solid fa-rocket mr-2"></i>Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-8 py-4 rounded-2xl bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 text-white font-bold text-lg shadow-xl hover:shadow-emerald-500/25 hover:-translate-y-1 transition-all">
                            <i class="fa-solid fa-right-to-bracket mr-2"></i>Login to Portal
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="px-8 py-4 rounded-2xl bg-white border-2 border-gray-200 text-gray-700 font-semibold text-lg hover:border-emerald-300 hover:text-emerald-600 hover:-translate-y-1 transition-all shadow-sm">
                                <i class="fa-solid fa-user-plus mr-2"></i>Create Account
                            </a>
                        @endif
                    @endauth
                @endif
            </div>

            <!-- Stats -->
            <div class="animate-fade-up delay-400 grid grid-cols-3 gap-6 max-w-xl mx-auto mt-16">
                <div class="text-center">
                    <p class="text-3xl sm:text-4xl font-bold bg-gradient-to-r from-emerald-600 to-teal-500 bg-clip-text text-transparent">8+</p>
                    <p class="text-sm text-gray-500 mt-1">Years Experience</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl sm:text-4xl font-bold bg-gradient-to-r from-teal-500 to-cyan-600 bg-clip-text text-transparent">500+</p>
                    <p class="text-sm text-gray-500 mt-1">Clients Served</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl sm:text-4xl font-bold bg-gradient-to-r from-cyan-600 to-emerald-600 bg-clip-text text-transparent">3</p>
                    <p class="text-sm text-gray-500 mt-1">Office Locations</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-24 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-1.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-600 text-sm font-medium mb-4">About Us</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-4">Who We Are</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">
                    A professional public accounting firm dedicated to excellence and integrity.
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- About Card -->
                <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-8 feature-card border border-gray-100 shadow-sm">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center mb-6 shadow-lg shadow-emerald-500/20">
                        <i class="fa-solid fa-building-columns text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Our Story</h3>
                    <p class="text-gray-500 leading-relaxed">
                        <strong class="text-emerald-600">Budiandru & Partners Public Accounting Firm</strong>, established since 2016,
                        provides professional accounting services with a focus on independence and professional ethics.
                        Located in East Jakarta, we also have branches in Surabaya and Pekanbaru.
                    </p>
                </div>

                <!-- Vision Card -->
                <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-8 feature-card border border-gray-100 shadow-sm">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-cyan-500 to-blue-500 flex items-center justify-center mb-6 shadow-lg shadow-cyan-500/20">
                        <i class="fa-solid fa-eye text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Our Vision</h3>
                    <p class="text-gray-500 leading-relaxed">
                        To develop Budiandru and Partners into a professional, trusted, and reliable Public Accounting Firm
                        that provides the best service to clients by prioritizing independence and upholding professional ethics.
                    </p>
                </div>

                <!-- Mission Card -->
                <div class="md:col-span-2 bg-white/80 backdrop-blur-sm rounded-3xl p-8 feature-card border border-gray-100 shadow-sm">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-violet-500 to-purple-500 flex items-center justify-center mb-6 shadow-lg shadow-violet-500/20">
                        <i class="fa-solid fa-bullseye text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Our Mission</h3>
                    <p class="text-gray-500 leading-relaxed">
                        Providing excellent service by considering clients as business partners. We believe in building
                        long-term relationships based on trust, transparency, and mutual growth.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-24 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-1.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-600 text-sm font-medium mb-4">Services</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-4">What We Offer</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">
                    Comprehensive accounting and auditing services tailored to your needs.
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Service 1 -->
                <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-6 feature-card group border border-gray-100 shadow-sm">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-file-invoice-dollar text-emerald-500 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Financial Audit</h3>
                    <p class="text-sm text-gray-500">Independent examination of financial statements to ensure accuracy and compliance.</p>
                </div>

                <!-- Service 2 -->
                <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-6 feature-card group border border-gray-100 shadow-sm">
                    <div class="w-12 h-12 rounded-xl bg-cyan-50 border border-cyan-200 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-calculator text-cyan-500 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Tax Consulting</h3>
                    <p class="text-sm text-gray-500">Expert guidance on tax planning, compliance, and optimization strategies.</p>
                </div>

                <!-- Service 3 -->
                <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-6 feature-card group border border-gray-100 shadow-sm">
                    <div class="w-12 h-12 rounded-xl bg-violet-50 border border-violet-200 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-chart-line text-violet-500 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Business Advisory</h3>
                    <p class="text-sm text-gray-500">Strategic advice to help your business grow and achieve its goals.</p>
                </div>

                <!-- Service 4 -->
                <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-6 feature-card group border border-gray-100 shadow-sm">
                    <div class="w-12 h-12 rounded-xl bg-amber-50 border border-amber-200 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-shield-halved text-amber-500 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Compliance Review</h3>
                    <p class="text-sm text-gray-500">Ensure your business meets all regulatory requirements and standards.</p>
                </div>

                <!-- Service 5 -->
                <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-6 feature-card group border border-gray-100 shadow-sm">
                    <div class="w-12 h-12 rounded-xl bg-rose-50 border border-rose-200 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-building text-rose-500 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Corporate Services</h3>
                    <p class="text-sm text-gray-500">Company formation, secretarial services, and corporate governance support.</p>
                </div>

                <!-- Service 6 -->
                <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-6 feature-card group border border-gray-100 shadow-sm">
                    <div class="w-12 h-12 rounded-xl bg-indigo-50 border border-indigo-200 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-users text-indigo-500 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">HR & Payroll</h3>
                    <p class="text-sm text-gray-500">Comprehensive payroll management and human resource consulting services.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-24 px-6">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-1.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-600 text-sm font-medium mb-4">Contact Us</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-4">Get In Touch</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">
                    Ready to work with us? Contact our team for consultation.
                </p>
            </div>

            <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-8 sm:p-10 border border-gray-100 shadow-sm">
                <div class="grid sm:grid-cols-2 gap-8">
                    <!-- Office Info -->
                    <div>
                        <div class="flex items-start gap-4 mb-8">
                            <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-location-dot text-emerald-500"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 mb-2">Head Office</h3>
                                <p class="text-sm text-gray-500 leading-relaxed">
                                    Grand Kartika No. 8A, Jl. Jambore, RT.05, RW.06 Cibubur<br>
                                    Kec. Ciracas, Kota Jakarta Timur 13720
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 mb-8">
                            <div class="w-12 h-12 rounded-xl bg-cyan-50 border border-cyan-200 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-phone text-cyan-500"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 mb-2">Phone</h3>
                                <p class="text-sm text-gray-500">
                                    +62 878-0016-1936<br>
                                    +62 857-7251-4713<br>
                                    Office: 021-22870841
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-violet-50 border border-violet-200 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-envelope text-violet-500"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 mb-2">Email</h3>
                                <p class="text-sm text-gray-500">info@kapbar.com</p>
                            </div>
                        </div>
                    </div>

                    <!-- Office Hours -->
                    <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-2xl p-6 border border-emerald-100">
                        <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-clock text-emerald-500"></i>
                            Office Hours
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center py-2 border-b border-emerald-100">
                                <span class="text-gray-600 text-sm">Monday - Friday</span>
                                <span class="text-emerald-600 font-medium text-sm">08:00 - 17:00</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-emerald-100">
                                <span class="text-gray-600 text-sm">Saturday</span>
                                <span class="text-gray-500 text-sm">By Appointment</span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-600 text-sm">Sunday</span>
                                <span class="text-gray-500 text-sm">Closed</span>
                            </div>
                        </div>

                        <div class="mt-6 pt-6 border-t border-emerald-100">
                            <p class="text-sm text-gray-500 mb-4">Connect with us</p>
                            <div class="flex gap-3">
                                <a href="#" class="w-10 h-10 rounded-xl bg-white border border-gray-200 hover:border-emerald-300 hover:bg-emerald-50 flex items-center justify-center transition-all">
                                    <i class="fa-brands fa-instagram text-gray-500 hover:text-emerald-500"></i>
                                </a>
                                <a href="#" class="w-10 h-10 rounded-xl bg-white border border-gray-200 hover:border-emerald-300 hover:bg-emerald-50 flex items-center justify-center transition-all">
                                    <i class="fa-brands fa-linkedin-in text-gray-500 hover:text-emerald-500"></i>
                                </a>
                                <a href="#" class="w-10 h-10 rounded-xl bg-white border border-gray-200 hover:border-emerald-300 hover:bg-emerald-50 flex items-center justify-center transition-all">
                                    <i class="fa-brands fa-whatsapp text-gray-500 hover:text-emerald-500"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-8 px-6 border-t border-gray-200/50 bg-white/50 backdrop-blur-sm">
        <div class="max-w-6xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.PNG') }}" alt="Logo" class="w-8 h-8 object-contain rounded-lg shadow-sm" />
                <span class="text-sm text-gray-500">&copy; {{ date('Y') }} KAP Budiandru & Rekan. All rights reserved.</span>
            </div>
            <p class="text-sm text-gray-400 italic">"Your Trusted Accounting Partner"</p>
        </div>
    </footer>
</body>

</html>
