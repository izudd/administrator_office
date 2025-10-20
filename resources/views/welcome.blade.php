<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>KAP Budiandru & Rekan | Administrator Portal</title>

    <!-- Font -->
    <link href="https://fonts.bunny.net/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: "Poppins", sans-serif;
            background: linear-gradient(to bottom right, #e0f7fa, #fef9c3);
            color: #334155;
            overflow-x: hidden;
        }

        /* Background animation */
        .gradient-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(-45deg, #6ee7b7, #93c5fd, #a5f3fc, #86efac);
            background-size: 400% 400%;
            z-index: -1;
            animation: gradientMove 14s ease infinite;
            opacity: 0.25;
        }

        @keyframes gradientMove {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .fade-in {
            opacity: 0;
            transform: translateY(15px);
            animation: fadeInUp 1s ease forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .glass {
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(18px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 1rem;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        .hover-glow {
            transition: all 0.3s ease;
        }

        .hover-glow:hover {
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.4);
            transform: translateY(-4px);
        }

        section {
            padding: 120px 20px;
        }

        html {
            scroll-behavior: smooth;
        }
    </style>

</head>

<body class="antialiased">

    <!-- Animated background -->
    <div class="gradient-bg"></div>

    <!-- Header -->
    <header class="fixed top-0 w-full flex justify-between items-center px-8 py-5 glass z-50">
        <div class="flex items-center space-x-3">
            <img src="{{ asset('images/logo.PNG') }}" alt="Logo" class="w-10 h-10 object-contain" />
            <h1 class="text-lg font-semibold text-gray-800">KAP Budiandru & Rekan</h1>
        </div>
        <nav class="hidden md:flex space-x-6 text-gray-800 text-sm">
            <a href="#home" class="hover:text-gray-800 transition">Home</a>
            <a href="#about" class="hover:text-gray-800 transition">About Us</a>
            <a href="#contact" class="hover:text-gray-800 transition">Contact</a>
        </nav>
    </header>

    <!-- Right Info Panel -->
    <aside class="fixed right-5 top-1/3 glass rounded-2xl p-4 hidden lg:block w-56">
        <h3 class="text-emerald-400 font-semibold mb-3">Quick Info</h3>
        <ul class="text-gray-800 text-sm space-y-2">
            <li>📅 {{ date('l, d M Y') }}</li>
            <li>🏢 KAP Budiandru & Rekan</li>
            <li>📍 Jakarta, Indonesia</li>
            <li>🕒 Office Hours: 09:00 - 17:00</li>
        </ul>
    </aside>

    <!-- Home -->
    <section id="home" class="flex flex-col items-center justify-center text-center min-h-screen">
        <div class="fade-in mb-8">
            <img src="{{ asset('images/logo.PNG') }}" alt="Logo"
                class="w-24 h-auto mx-auto drop-shadow-2xl rounded-lg" />
        </div>
        <h2 class="fade-in text-4xl md:text-5xl font-bold mb-4">
            Welcome to <span class="text-emerald-400">Administrator Portal</span>
        </h2>
        <p class="fade-in text-gray-800 max-w-2xl mb-10 leading-relaxed" style="animation-delay: 0.3s">
            Manage financial reports, audits, and internal data of
            <br />
            <span class="font-semibold text-emerald-400">KAP Budiandru & Rekan</span> securely and efficiently.
        </p>

        <div class="fade-in flex gap-4" style="animation-delay: 0.6s">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl font-semibold hover-glow">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-xl font-semibold hover-glow">
                        Login
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-900 rounded-xl font-semibold hover-glow">
                            Register
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </section>

    <!-- About -->
    <section id="about" class="text-center">
        <h2 class="text-3xl font-bold text-emerald-400 mb-6">About Us</h2>
        <div class="max-w-3xl mx-auto glass rounded-2xl p-8 text-gray-800">
            <p class="mb-4">
                <strong>Budiandru & Partners Public Accounting Firm</strong>, established since 2016, provides
                professional
                accounting services with a focus on independence and professional ethics. Located in East Jakarta, we
                also have
                branches in Surabaya and Pekanbaru.
            </p>
            <h3 class="text-xl font-semibold text-emerald-400 mt-6 mb-2">Vision</h3>
            <p class="mb-4">
                To develop Budiandru and Partners into a professional, trusted, and reliable Public Accounting Firm that
                provides
                the best service to clients by prioritizing independence and upholding professional ethics.
            </p>
            <h3 class="text-xl font-semibold text-emerald-400 mt-6 mb-2">Mission</h3>
            <p>
                Providing excellent service by considering clients as business partners.
            </p>
        </div>
    </section>

    <!-- Contact -->
    <section id="contact" class="text-center">
        <h2 class="text-3xl font-bold text-emerald-400 mb-6">Contact Us</h2>
        <div class="max-w-2xl mx-auto glass rounded-2xl p-8 text-gray-800">
            <h3 class="text-xl font-semibold text-emerald-400 mb-3">Head Office</h3>
            <p class="mb-4">
                Grand Kartika No. 8A, Jl. Jambore, RT.05, RW.06 Cibubur<br />
                Kec. Ciracas, Kota Jakarta Timur 13720
            </p>

            <h3 class="text-xl font-semibold text-emerald-400 mb-2">Phone</h3>
            <p class="mb-4">
                +62 878-0016-1936<br />
                +62 857-7251-4713<br />
                Office: 021-22870841
            </p>

            <h3 class="text-xl font-semibold text-emerald-400 mb-2">Email</h3>
            <p>info@kapbar.com</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center py-8 text-gray-500 text-sm">
        <p>© {{ date('Y') }} KAP Budiandru & Rekan <br>
            <span class="text-gray-400 italic text-xs">“Your Trusted Accounting Partner.”</span>
        </p>
    </footer>

</body>

</html>
