<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TheCrtCrew | Forex Trading Mastery</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(135deg, #000000 0%, #741B1B 100%);
            min-height: 100vh;
            color: white;
        }
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('/frontend/background_image.jpg');
            background-size: cover;
            background-position: center;
        }
        .logo {
            color: #228B22;
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
        }
        .logo-icon {
            display: inline-block;
            width: 30px;
            height: 30px;
            background-color: #228B22;
            border-radius: 50%;
            margin-right: 8px;
            position: relative;
        }
        .logo-icon::after {
            content: "↑↓";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-weight: bold;
            font-size: 12px;
        }
        .cta-button {
            background-color: #228B22;
            transition: all 0.3s ease;
        }
        .cta-button:hover {
            background-color: #1a6e1a;
            transform: translateY(-2px);
        }
        .feature-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            border-color: #228B22;
        }

        /* Mobile Menu */
        .mobile-menu-button {
            display: none;
        }
        .mobile-menu {
            display: none;
        }

        @media (max-width: 768px) {
            .logo {
                font-size: 1.2rem;
            }
            .logo-icon {
                width: 25px;
                height: 25px;
            }

            /* Mobile Menu */
            .desktop-nav {
                display: none;
            }
            .mobile-menu-button {
                display: block;
                background: none;
                border: none;
                color: white;
                font-size: 1.5rem;
                cursor: pointer;
            }
            .mobile-menu.active {
                display: flex;
                flex-direction: column;
                position: absolute;
                top: 70px;
                right: 20px;
                background: rgba(0, 0, 0, 0.9);
                padding: 20px;
                border-radius: 8px;
                z-index: 1000;
                width: 200px;
            }
            .mobile-menu a {
                margin-bottom: 10px;
                text-align: center;
            }

            /* Hero Section */
            .hero-section {
                min-height: 80vh;
                padding-top: 60px;
                padding-bottom: 60px;
            }
            .hero-section h1 {
                font-size: 2.5rem;
                margin-bottom: 1rem;
            }
            .hero-section p {
                font-size: 1rem;
                margin-bottom: 1.5rem;
            }
            .hero-section .flex {
                flex-direction: column;
                gap: 1rem;
            }
            .hero-section a {
                width: 100%;
                text-align: center;
                padding: 0.75rem;
            }

            /* Features */
            .feature-card {
                padding: 1.5rem;
            }
            .feature-card h3 {
                font-size: 1.25rem;
            }

            /* Testimonials */
            .testimonial {
                padding: 1.5rem;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .logo {
                font-size: 1.8rem;
            }
            .hero-section h1 {
                font-size: 3rem;
            }
            .feature-card {
                padding: 1.5rem;
            }
        }

    </style>
</head>
<body>

    <!-- Navigation -->
    <div class="bg-gradient-to-b from-black to-black py-4">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="logo">
                <span class="logo-icon"></span>
                TheCrtCrew
            </div>

            @if (Route::has('login'))
                <!-- Desktop Navigation -->
                <nav class="desktop-nav flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-red-600 hover:bg-red-700 text-white rounded-full transition-colors px-4 py-2 text-sm md:text-base">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-white px-4 py-2 rounded-lg transition-colors text-sm md:text-base">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-4 md:px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-full transition-colors text-sm md:text-base">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>

                <!-- Mobile Menu Button -->
                <button class="mobile-menu-button" onclick="toggleMobileMenu()">
                    ☰
                </button>

                <!-- Mobile Menu -->
                <nav id="mobileMenu" class="mobile-menu">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-red-600 hover:bg-red-700 text-white rounded-full transition-colors px-4 py-2 block mb-2">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-white px-4 py-2 rounded-lg transition-colors block mb-2">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-full transition-colors block">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
    </div>

    @yield('content')

    <!-- Footer -->
    <footer class="bg-black py-6 md:py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="logo mb-4 md:mb-0">
                    <span class="logo-icon"></span>
                    TheCrtCrew
                </div>
                <div class="text-gray-400 text-sm md:text-base">
                    © {{ date('Y') }} TheCrtCrew. All rights reserved.
                </div>
            </div>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('active');
        }
    </script>
</body>
</html>
