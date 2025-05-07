<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TheCrtCrew | Forex Trading Mastery</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Base Styles */
        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(135deg, #000000 0%, #741B1B 100%);
            min-height: 100vh;
            color: white;
            margin: 0;
            padding: 0;
        }

        /* Header/Navigation */
        .header {
            background: linear-gradient(to bottom, #000000, #000000);
            padding: 1rem 0;
            position: relative;
            z-index: 100;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .flex {
            display: flex;
        }

        .justify-between {
            justify-content: space-between;
        }

        .items-center {
            align-items: center;
        }

        /* Logo */
        .logo {
            color: #228B22;
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            text-decoration: none;
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

        /* Desktop Navigation */
        .desktop-nav {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .desktop-nav a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            transition: all 0.3s ease;
        }

        .desktop-nav a:hover {
            color: #228B22;
        }

        .desktop-nav .btn {
            background-color: #dc2626;
            color: white;
            border-radius: 9999px;
            padding: 0.5rem 1.5rem;
        }

        .desktop-nav .btn:hover {
            background-color: #b91c1c;
            color: white;
            transform: translateY(-2px);
        }

        /* Mobile Menu Button */
        .mobile-menu-button {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            z-index: 1001;
        }

        /* Mobile Slider Navigation */
        .mobile-slider-nav {
            position: fixed;
            top: 0;
            right: -300px;
            width: 280px;
            height: 100vh;
            background: rgba(0, 0, 0, 0.98);
            z-index: 1000;
            transition: right 0.3s ease-out;
            padding-top: 5rem;
            overflow-y: auto;
        }

        .mobile-slider-nav.active {
            right: 0;
        }

        .mobile-slider-nav a {
            display: block;
            padding: 1rem 1.5rem;
            color: white;
            text-decoration: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s;
        }

        .mobile-slider-nav a:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #228B22;
        }

        .mobile-slider-nav .btn {
            display: block;
            text-align: center;
            background: none;
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 9999px;
            padding: 0.75rem;
            margin: 0.5rem 1rem;
            transition: all 0.3s;
        }

        .mobile-slider-nav .btn:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #228B22;
            border-color: #228B22;
        }

        /* Overlay */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
        }

        .overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Close Button */
        .close-mobile-menu {
            position: absolute;
            top: 1.25rem;
            right: 1.25rem;
            color: white;
            font-size: 1.5rem;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.5rem;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .desktop-nav {
                display: none;
            }

            .mobile-menu-button {
                display: block;
            }
        }

        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('/frontend/background_image.jpg');
            background-size: cover;
            background-position: center;
        }

        .cta-button {
            background-color: #228B22;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 9999px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .cta-button:hover {
            background-color: #1a6e1a;
            transform: translateY(-2px);
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 0.5rem;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            border-color: #228B22;
        }

        .cart-link {
            padding: 0.5rem;
            margin-right: 0.5rem;
        }

        .cart-icon-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .cart-count-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            background-color: #228B22;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .mobile-cart-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
        }

        .mobile-cart-count {
            margin-left: 8px;
            background-color: #228B22;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

    </style>

    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <header class="header">
        <div class="container">
            <div class="flex justify-between items-center">
                <a href="/" class="logo">
                    <span class="logo-icon"></span>
                    TheCrtCrew
                </a>

                @if (Route::has('login'))
                    <!-- Desktop Navigation -->
                    <nav class="desktop-nav">

                        <a href="{{ route('cart.index') }}" class="cart-link hover:text-green-500">
                            <div class="cart-icon-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                @php
                                    $cartCount = count(session('cart', []));
                                @endphp
                                @if($cartCount > 0)
                                    <span class="cart-count-badge">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </div>
                        </a>

                        <a href="{{ route('courses.index') }}" class="hover:text-green-500">Courses</a>
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="hover:text-green-500">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn">Register</a>
                            @endif
                        @endauth
                    </nav>

                    <!-- Mobile Menu Button -->
                    <button class="mobile-menu-button" id="mobileMenuButton">
                        ☰
                    </button>
                @endif
            </div>
        </div>
    </header>

    <!-- Mobile Slider Navigation -->
    <div class="overlay" id="overlay"></div>
    <nav class="mobile-slider-nav" id="mobileSliderNav">
        <button class="close-mobile-menu" id="closeMobileMenu">x</button>
        <a href="{{ route('courses.index') }}">Courses</a>
        @auth
            <a href="{{ url('/dashboard') }}">Dashboard</a>
        @else
            <div class="auth-buttons">
                <a href="{{ route('login') }}">Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            </div>
        @endauth
        <a href="{{ route('cart.index') }}" class="mobile-cart-link">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            @php
                $cartCount = count(session('cart', []));
            @endphp
            @if($cartCount > 0)
                <span class="mobile-cart-count">
                    {{ $cartCount }}
                </span>
            @endif
        </a>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobileMenuButton');
            const closeMobileMenu = document.getElementById('closeMobileMenu');
            const mobileSliderNav = document.getElementById('mobileSliderNav');
            const overlay = document.getElementById('overlay');

            function toggleMobileMenu() {
                mobileSliderNav.classList.toggle('active');
                overlay.classList.toggle('active');
                document.body.style.overflow = mobileSliderNav.classList.contains('active') ? 'hidden' : '';
            }

            mobileMenuButton.addEventListener('click', toggleMobileMenu);
            closeMobileMenu.addEventListener('click', toggleMobileMenu);
            overlay.addEventListener('click', toggleMobileMenu);
        });
    </script>
</body>
</html>