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
            darkMode: 'class',
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

        /* Aurora Background */
        .aurora-bg {
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg, #0a0f1a 0%, #0e1525 25%, #111827 50%, #0e1525 75%, #0a0f1a 100%);
            z-index: -2;
        }

        .aurora-glow {
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 50% at 20% 20%, rgba(16, 185, 129, 0.15) 0%, transparent 50%),
                radial-gradient(ellipse 60% 40% at 80% 80%, rgba(6, 182, 212, 0.12) 0%, transparent 50%),
                radial-gradient(ellipse 50% 30% at 50% 50%, rgba(139, 92, 246, 0.08) 0%, transparent 50%);
            z-index: -1;
            animation: aurora-pulse 8s ease-in-out infinite;
        }

        @keyframes aurora-pulse {
            0%, 100% { opacity: 0.6; }
            50% { opacity: 1; }
        }

        /* Floating Orbs */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(60px);
            animation: orb-float 20s ease-in-out infinite;
            z-index: -1;
        }

        .orb-1 {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.3) 0%, transparent 70%);
            top: -10%;
            left: -5%;
            animation-delay: 0s;
        }

        .orb-2 {
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, rgba(6, 182, 212, 0.25) 0%, transparent 70%);
            top: 60%;
            right: -5%;
            animation-delay: -5s;
        }

        .orb-3 {
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.2) 0%, transparent 70%);
            bottom: -10%;
            left: 30%;
            animation-delay: -10s;
        }

        @keyframes orb-float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(30px, -40px) scale(1.05); }
            50% { transform: translate(-20px, 20px) scale(0.95); }
            75% { transform: translate(40px, 30px) scale(1.02); }
        }

        /* Grid Background */
        .grid-bg {
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(16, 185, 129, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(16, 185, 129, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            z-index: -1;
        }

        /* Particles */
        .particles {
            position: fixed;
            inset: 0;
            overflow: hidden;
            z-index: -1;
        }

        .particle {
            position: absolute;
            width: 3px;
            height: 3px;
            background: rgba(16, 185, 129, 0.5);
            border-radius: 50%;
            animation: particle-rise 15s linear infinite;
        }

        @keyframes particle-rise {
            0% {
                transform: translateY(100vh) scale(0);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100vh) scale(1);
                opacity: 0;
            }
        }

        /* Animations */
        @keyframes fade-up {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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

        /* Glassmorphism */
        .glass {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .glass-card {
            background: rgba(17, 24, 39, 0.6);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Gradient Text */
        .gradient-text {
            background: linear-gradient(135deg, #10b981 0%, #06b6d4 50%, #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Button Hover Effect */
        .btn-glow {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .btn-glow::before {
            content: '';
            position: absolute;
            inset: -2px;
            background: linear-gradient(135deg, #10b981, #06b6d4, #8b5cf6);
            border-radius: inherit;
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .btn-glow:hover::before {
            opacity: 1;
        }

        .btn-glow:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(16, 185, 129, 0.3);
        }

        /* Scroll behavior */
        html {
            scroll-behavior: smooth;
        }

        /* Card Hover */
        .feature-card {
            transition: all 0.4s ease;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px rgba(16, 185, 129, 0.15);
        }

        /* Icon Glow */
        .icon-glow {
            box-shadow: 0 0 30px rgba(16, 185, 129, 0.4);
        }
    </style>
</head>

<body class="antialiased text-gray-100">
    <!-- Background Effects -->
    <div class="aurora-bg"></div>
    <div class="aurora-glow"></div>
    <div class="grid-bg"></div>

    <!-- Floating Orbs -->
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <!-- Particles -->
    <div class="particles">
        @for ($i = 0; $i < 20; $i++)
            <div class="particle" style="left: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 15) }}s; animation-duration: {{ rand(12, 20) }}s;"></div>
        @endfor
    </div>

    <!-- Navigation -->
    <header class="fixed top-0 left-0 right-0 z-50">
        <nav class="glass border-b border-white/5">
            <div class="max-w-7xl mx-auto px-6 py-4">
                <div class="flex justify-between items-center">
                    <!-- Logo -->
                    <div class="flex items-center gap-3 animate-fade-up">
                        <div class="relative">
                            <div class="absolute inset-0 bg-emerald-500 rounded-xl blur-lg opacity-50"></div>
                            <img src="{{ asset('images/logo.PNG') }}" alt="Logo" class="relative w-10 h-10 object-contain rounded-xl" />
                        </div>
                        <div>
                            <h1 class="text-lg font-bold text-white">KAP Budiandru</h1>
                            <p class="text-xs text-gray-400">& Rekan</p>
                        </div>
                    </div>

                    <!-- Nav Links -->
                    <div class="hidden md:flex items-center gap-8 animate-fade-up delay-100">
                        <a href="#home" class="text-sm text-gray-300 hover:text-emerald-400 transition-colors">Home</a>
                        <a href="#about" class="text-sm text-gray-300 hover:text-emerald-400 transition-colors">About</a>
                        <a href="#services" class="text-sm text-gray-300 hover:text-emerald-400 transition-colors">Services</a>
                        <a href="#contact" class="text-sm text-gray-300 hover:text-emerald-400 transition-colors">Contact</a>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="flex items-center gap-3 animate-fade-up delay-200">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                    class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-cyan-500 text-white font-semibold text-sm hover:shadow-lg hover:shadow-emerald-500/30 transition-all">
                                    <i class="fa-solid fa-gauge-high mr-2"></i>Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="px-5 py-2.5 rounded-xl text-gray-300 hover:text-white text-sm font-medium transition-colors">
                                    Login
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-cyan-500 text-white font-semibold text-sm hover:shadow-lg hover:shadow-emerald-500/30 transition-all">
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
            <div class="animate-fade-up inline-flex items-center gap-2 px-4 py-2 rounded-full glass-card mb-8">
                <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                <span class="text-sm text-gray-300">Trusted Accounting Partner Since 2016</span>
            </div>

            <!-- Main Heading -->
            <h1 class="animate-fade-up delay-100 text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold mb-6 leading-tight">
                <span class="text-white">Welcome to</span><br>
                <span class="gradient-text">Administrator Portal</span>
            </h1>

            <!-- Subtitle -->
            <p class="animate-fade-up delay-200 text-lg sm:text-xl text-gray-400 max-w-2xl mx-auto mb-10 leading-relaxed">
                Manage financial reports, audits, and internal data of
                <span class="text-emerald-400 font-semibold">KAP Budiandru & Rekan</span>
                securely and efficiently with our modern platform.
            </p>

            <!-- CTA Buttons -->
            <div class="animate-fade-up delay-300 flex flex-col sm:flex-row gap-4 justify-center">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="btn-glow px-8 py-4 rounded-2xl bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 text-white font-bold text-lg shadow-xl">
                            <i class="fa-solid fa-rocket mr-2"></i>Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="btn-glow px-8 py-4 rounded-2xl bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 text-white font-bold text-lg shadow-xl">
                            <i class="fa-solid fa-right-to-bracket mr-2"></i>Login to Portal
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="px-8 py-4 rounded-2xl glass-card text-gray-300 font-semibold text-lg hover:text-white hover:border-emerald-500/50 transition-all">
                                <i class="fa-solid fa-user-plus mr-2"></i>Create Account
                            </a>
                        @endif
                    @endauth
                @endif
            </div>

            <!-- Stats -->
            <div class="animate-fade-up delay-400 grid grid-cols-3 gap-6 max-w-xl mx-auto mt-16">
                <div class="text-center">
                    <p class="text-3xl sm:text-4xl font-bold gradient-text">8+</p>
                    <p class="text-sm text-gray-500 mt-1">Years Experience</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl sm:text-4xl font-bold gradient-text">500+</p>
                    <p class="text-sm text-gray-500 mt-1">Clients Served</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl sm:text-4xl font-bold gradient-text">3</p>
                    <p class="text-sm text-gray-500 mt-1">Office Locations</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-24 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-1.5 rounded-full glass-card text-emerald-400 text-sm font-medium mb-4">About Us</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">Who We Are</h2>
                <p class="text-gray-400 max-w-2xl mx-auto">
                    A professional public accounting firm dedicated to excellence and integrity.
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- About Card -->
                <div class="glass-card rounded-3xl p-8 feature-card">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-cyan-500 flex items-center justify-center mb-6 icon-glow">
                        <i class="fa-solid fa-building-columns text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">Our Story</h3>
                    <p class="text-gray-400 leading-relaxed">
                        <strong class="text-emerald-400">Budiandru & Partners Public Accounting Firm</strong>, established since 2016,
                        provides professional accounting services with a focus on independence and professional ethics.
                        Located in East Jakarta, we also have branches in Surabaya and Pekanbaru.
                    </p>
                </div>

                <!-- Vision Card -->
                <div class="glass-card rounded-3xl p-8 feature-card">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-cyan-500 to-purple-500 flex items-center justify-center mb-6 icon-glow">
                        <i class="fa-solid fa-eye text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">Our Vision</h3>
                    <p class="text-gray-400 leading-relaxed">
                        To develop Budiandru and Partners into a professional, trusted, and reliable Public Accounting Firm
                        that provides the best service to clients by prioritizing independence and upholding professional ethics.
                    </p>
                </div>

                <!-- Mission Card -->
                <div class="md:col-span-2 glass-card rounded-3xl p-8 feature-card">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center mb-6 icon-glow">
                        <i class="fa-solid fa-bullseye text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">Our Mission</h3>
                    <p class="text-gray-400 leading-relaxed">
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
                <span class="inline-block px-4 py-1.5 rounded-full glass-card text-emerald-400 text-sm font-medium mb-4">Services</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">What We Offer</h2>
                <p class="text-gray-400 max-w-2xl mx-auto">
                    Comprehensive accounting and auditing services tailored to your needs.
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Service 1 -->
                <div class="glass-card rounded-3xl p-6 feature-card group">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/20 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-file-invoice-dollar text-emerald-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Financial Audit</h3>
                    <p class="text-sm text-gray-400">Independent examination of financial statements to ensure accuracy and compliance.</p>
                </div>

                <!-- Service 2 -->
                <div class="glass-card rounded-3xl p-6 feature-card group">
                    <div class="w-12 h-12 rounded-xl bg-cyan-500/20 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-calculator text-cyan-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Tax Consulting</h3>
                    <p class="text-sm text-gray-400">Expert guidance on tax planning, compliance, and optimization strategies.</p>
                </div>

                <!-- Service 3 -->
                <div class="glass-card rounded-3xl p-6 feature-card group">
                    <div class="w-12 h-12 rounded-xl bg-purple-500/20 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-chart-line text-purple-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Business Advisory</h3>
                    <p class="text-sm text-gray-400">Strategic advice to help your business grow and achieve its goals.</p>
                </div>

                <!-- Service 4 -->
                <div class="glass-card rounded-3xl p-6 feature-card group">
                    <div class="w-12 h-12 rounded-xl bg-amber-500/20 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-shield-halved text-amber-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Compliance Review</h3>
                    <p class="text-sm text-gray-400">Ensure your business meets all regulatory requirements and standards.</p>
                </div>

                <!-- Service 5 -->
                <div class="glass-card rounded-3xl p-6 feature-card group">
                    <div class="w-12 h-12 rounded-xl bg-rose-500/20 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-building text-rose-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Corporate Services</h3>
                    <p class="text-sm text-gray-400">Company formation, secretarial services, and corporate governance support.</p>
                </div>

                <!-- Service 6 -->
                <div class="glass-card rounded-3xl p-6 feature-card group">
                    <div class="w-12 h-12 rounded-xl bg-indigo-500/20 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-users text-indigo-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">HR & Payroll</h3>
                    <p class="text-sm text-gray-400">Comprehensive payroll management and human resource consulting services.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-24 px-6">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-1.5 rounded-full glass-card text-emerald-400 text-sm font-medium mb-4">Contact Us</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">Get In Touch</h2>
                <p class="text-gray-400 max-w-2xl mx-auto">
                    Ready to work with us? Contact our team for consultation.
                </p>
            </div>

            <div class="glass-card rounded-3xl p-8 sm:p-10">
                <div class="grid sm:grid-cols-2 gap-8">
                    <!-- Office Info -->
                    <div>
                        <div class="flex items-start gap-4 mb-8">
                            <div class="w-12 h-12 rounded-xl bg-emerald-500/20 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-location-dot text-emerald-400"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-white mb-2">Head Office</h3>
                                <p class="text-sm text-gray-400 leading-relaxed">
                                    Grand Kartika No. 8A, Jl. Jambore, RT.05, RW.06 Cibubur<br>
                                    Kec. Ciracas, Kota Jakarta Timur 13720
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 mb-8">
                            <div class="w-12 h-12 rounded-xl bg-cyan-500/20 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-phone text-cyan-400"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-white mb-2">Phone</h3>
                                <p class="text-sm text-gray-400">
                                    +62 878-0016-1936<br>
                                    +62 857-7251-4713<br>
                                    Office: 021-22870841
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-purple-500/20 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-envelope text-purple-400"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-white mb-2">Email</h3>
                                <p class="text-sm text-gray-400">info@kapbar.com</p>
                            </div>
                        </div>
                    </div>

                    <!-- Office Hours -->
                    <div class="glass rounded-2xl p-6">
                        <h3 class="font-bold text-white mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-clock text-emerald-400"></i>
                            Office Hours
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center py-2 border-b border-white/5">
                                <span class="text-gray-400">Monday - Friday</span>
                                <span class="text-emerald-400 font-medium">08:00 - 17:00</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-white/5">
                                <span class="text-gray-400">Saturday</span>
                                <span class="text-gray-500">By Appointment</span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-400">Sunday</span>
                                <span class="text-gray-500">Closed</span>
                            </div>
                        </div>

                        <div class="mt-6 pt-6 border-t border-white/5">
                            <p class="text-sm text-gray-400 mb-4">Connect with us</p>
                            <div class="flex gap-3">
                                <a href="#" class="w-10 h-10 rounded-xl bg-white/5 hover:bg-emerald-500/20 flex items-center justify-center transition-colors">
                                    <i class="fa-brands fa-instagram text-gray-400 hover:text-emerald-400"></i>
                                </a>
                                <a href="#" class="w-10 h-10 rounded-xl bg-white/5 hover:bg-emerald-500/20 flex items-center justify-center transition-colors">
                                    <i class="fa-brands fa-linkedin-in text-gray-400 hover:text-emerald-400"></i>
                                </a>
                                <a href="#" class="w-10 h-10 rounded-xl bg-white/5 hover:bg-emerald-500/20 flex items-center justify-center transition-colors">
                                    <i class="fa-brands fa-whatsapp text-gray-400 hover:text-emerald-400"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-8 px-6 border-t border-white/5">
        <div class="max-w-6xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.PNG') }}" alt="Logo" class="w-8 h-8 object-contain rounded-lg" />
                <span class="text-sm text-gray-400">© {{ date('Y') }} KAP Budiandru & Rekan. All rights reserved.</span>
            </div>
            <p class="text-sm text-gray-500 italic">"Your Trusted Accounting Partner"</p>
        </div>
    </footer>
</body>

</html>
