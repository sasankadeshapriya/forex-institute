@extends('layouts.main')

@section('content')

<?php
$sections = [
    'hero' => [
        'title' => 'TRADING BASICS AND INVESTMENTS',
        'subtitle' => 'Get a new profession and create your first basic algorithm in our course',
        'buttonText' => 'Sign up for a course',
        'bgGradient' => 'from-black to-red-900',
    ],
    'features' => [
        'title' => 'What You\'ll Master',
        'subtitle' => 'Our comprehensive curriculum covers everything you need to become a successful trader.',
        'bgGradient' => 'from-red-900 to-black',
        'cards' => [
            ['title' => 'Trading Strategy', 'description' => 'Build a personalized trading strategy based on your financial goals and risk tolerance levels.'],
            ['title' => 'Risk Management', 'description' => 'Master advanced risk management techniques while maintaining psychological balance.'],
            ['title' => 'Market Analysis', 'description' => 'Learn to analyze market trends and identify profitable trading opportunities.'],
            ['title' => 'Automation', 'description' => 'Create and optimize your first trading algorithm with real market testing.'],
        ],
    ],
    'benefits' => [
        'title' => 'Trading Benefits',
        'subtitle' => 'Experience the freedom and flexibility that trading can bring to your life.',
        'bgGradient' => 'from-black to-red-900',
        'cards' => [
            ['title' => 'Income', 'description' => 'There\'s no need to build or rent an office, a warehouse, look for employees, deal with suppliers. You can work from your phone/laptop and increase income.'],
            ['title' => 'Free Schedule', 'description' => 'The trading market runs in a comfortable mode: no deadlines and stressful needs, by staying in the moment and making decisions when you want.'],
            ['title' => 'Location Independence', 'description' => 'Work from anywhere in the world. All you need is your laptop and a stable internet connection.'],
            ['title' => 'Leverage Opportunities', 'description' => 'Utilize leverage to maximize your profits, allowing you to trade larger positions than your initial investment would normally allow.'],
        ],
    ],
    'cta' => [
        'title' => 'Start Your Trading Journey',
        'subtitle' => 'Join thousands of successful traders who have transformed their lives through our professional trading course.',
        'bgGradient' => 'from-red-900 to-black',
    ],
];
?>

<!-- Mobile/Tablet View (stacked layout) -->
<div class="lg:hidden bg-black">
    <!-- Auth Buttons -->
    <div class="bg-gradient-to-b from-black to-black py-4">
        <div class="container mx-auto px-4 flex justify-end gap-4">
            @if (Route::has('login'))
                <nav class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-red-600 hover:bg-red-700 text-white rounded-full transition-colors px-4 py-2">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-white px-4 py-2 rounded-lg transition-colors">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-full transition-colors">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
    </div>

    <!-- Stacked Sections -->
    @foreach ($sections as $key => $section)
        <section class="w-full py-16 px-4 bg-gradient-to-b {{ $section['bgGradient'] }}">
            <div class="max-w-4xl mx-auto text-center text-white">
                <h2 class="text-3xl font-bold mb-4">{{ $section['title'] }}</h2>
                <p class="text-lg mb-8">{{ $section['subtitle'] }}</p>

                @isset($section['cards'])
                    <div class="grid grid-cols-1 gap-6 mt-8">
                        @foreach ($section['cards'] as $card)
                            <div class="bg-black/30 backdrop-blur-sm p-6 rounded-lg">
                                <h3 class="text-xl font-semibold mb-3">{{ $card['title'] }}</h3>
                                <p class="text-sm text-gray-300">{{ $card['description'] }}</p>
                            </div>
                        @endforeach
                    </div>
                @endisset

                @if ($key === 'hero')
                    <button class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-full mt-8 transition-colors">
                        {{ $section['buttonText'] }}
                    </button>
                @endif

                @if ($key === 'cta')
                    <div class="mt-8 flex flex-col sm:flex-row gap-2 justify-center">
                        <input
                            type="email"
                            placeholder="Enter your email"
                            class="px-6 py-3 rounded-full sm:rounded-l-full sm:rounded-r-none bg-white/10 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 w-full sm:w-auto"
                        />
                        <button class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-full sm:rounded-l-none sm:rounded-r-full transition-colors w-full sm:w-auto">
                            Get Started
                        </button>
                    </div>
                @endif
            </div>
        </section>
    @endforeach
</div>

<!-- Desktop View (full-screen sliding sections) -->
<div class="hidden lg:block h-screen w-screen overflow-hidden relative bg-black">
    <!-- Auth Buttons - Inside a container with same background -->
    <div class="bg-gradient-to-b from-black to-black py-4">
        <div class="container mx-auto px-4 flex justify-end gap-4">
            @if (Route::has('login'))
                <nav class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-red-600 hover:bg-red-700 text-white rounded-full transition-colors px-4 py-2">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-white px-4 py-2 rounded-lg transition-colors">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-full transition-colors">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
    </div>

    <div class="flex transition-transform duration-700 ease-in-out h-full" id="sections-container">
        @foreach ($sections as $key => $section)
            <section
                id="{{ $key }}"
                class="min-w-full h-full flex flex-col items-center justify-center p-8 bg-gradient-to-b {{ $section['bgGradient'] }}">

                <div class="max-w-4xl mx-auto text-center text-white">
                    <h2 class="text-4xl font-bold mb-4">{{ $section['title'] }}</h2>
                    <p class="text-lg mb-8">{{ $section['subtitle'] }}</p>

                    @isset($section['cards'])
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-12">
                            @foreach ($section['cards'] as $card)
                                <div class="bg-black/30 backdrop-blur-sm p-6 rounded-lg">
                                    <h3 class="text-xl font-semibold mb-3">{{ $card['title'] }}</h3>
                                    <p class="text-sm text-gray-300">{{ $card['description'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endisset

                    @if ($key === 'hero')
                        <button class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-full mt-8 transition-colors">
                            {{ $section['buttonText'] }}
                        </button>
                    @endif

                    @if ($key === 'cta')
                        <div class="mt-8">
                            <input
                                type="email"
                                placeholder="Enter your email"
                                class="px-6 py-3 rounded-l-full bg-white/10 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500"
                            />
                            <button class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-r-full transition-colors">
                                Get Started
                            </button>
                        </div>
                    @endif
                </div>
            </section>
        @endforeach
    </div>

    <!-- Horizontal Navigation Dots - Desktop Only -->
    <div class="hidden lg:flex fixed bottom-8 left-1/2 -translate-x-1/2 gap-4 z-50">
        @foreach ($sections as $index => $section)
            <button
                onclick="setCurrentSection({{ $index }})"
                class="w-3 h-3 rounded-full transition-colors {{ $index === 0 ? 'bg-red-500' : 'bg-white/50 hover:bg-white/80' }} dot-navigation"
                data-index="{{ $index }}"
            />
        @endforeach
    </div>

    <!-- Left Navigation Arrow -->
    <button
        onclick="navigate('left')"
        class="fixed left-4 top-1/2 -translate-y-1/2 text-white/50 hover:text-white transition-colors invisible lg:block"
        id="left-arrow"
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left">
            <path d="M15 18l-6-6 6-6"></path>
        </svg>
    </button>

    <!-- Right Navigation Arrow -->
    <button
        onclick="navigate('right')"
        class="fixed right-4 top-1/2 -translate-y-1/2 text-white/50 hover:text-white transition-colors lg:block"
        id="right-arrow"
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right">
            <path d="M9 18l6-6-6-6"></path>
        </svg>
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentSection = 0;

        const sectionsContainer = document.getElementById('sections-container');
        const dots = document.querySelectorAll('.dot-navigation');
        const leftArrow = document.getElementById('left-arrow');
        const rightArrow = document.getElementById('right-arrow');

        if (!sectionsContainer || !dots.length) return;

        const totalSections = {{ count($sections) }}; // PHP variable for section count

        // Update UI state
        function updateUI() {
            // Update container position
            sectionsContainer.style.transform = `translateX(-${currentSection * 100}%)`;

            // Update dots
            dots.forEach((dot, index) => {
                if (index === currentSection) {
                    dot.classList.add('bg-red-500');
                    dot.classList.remove('bg-white/50');
                    dot.disabled = false; // Enable dot when the section is active
                } else {
                    dot.classList.remove('bg-red-500');
                    dot.classList.add('bg-white/50');
                    dot.disabled = true; // Disable other dots
                }
            });

            // Update arrows
            leftArrow.classList.toggle('invisible', currentSection === 0);
            rightArrow.classList.toggle('invisible', currentSection === totalSections - 1);
        }

        // Set current section
        function setCurrentSection(index) {
            if (index >= 0 && index < totalSections) {
                currentSection = index;
                updateUI();
            }
        }

        // Navigate between sections
        function navigate(direction) {
            if (direction === 'left') {
                setCurrentSection(currentSection - 1);
            } else if (direction === 'right') {
                setCurrentSection(currentSection + 1);
            }
        }

        // Handle window resize to fix content positioning
        window.addEventListener('resize', function() {
            if (window.innerWidth < 1024) {
                // Adjust styles when the window is resized below the breakpoint
                document.body.style.overflowY = "auto"; // Allow vertical scrolling in smaller screens
            }
        });

        // Initialize the layout
        updateUI();

        // Make functions available globally for HTML onclick handlers
        window.setCurrentSection = setCurrentSection;
        window.navigate = navigate;

        // Add keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') navigate('left');
            if (e.key === 'ArrowRight') navigate('right');
        });

        // Add swipe support for touch devices
        let touchStartX = 0;
        sectionsContainer.addEventListener('touchstart', (e) => {
            touchStartX = e.touches[0].clientX;
        }, { passive: true });

        sectionsContainer.addEventListener('touchend', (e) => {
            const touchEndX = e.changedTouches[0].clientX;
            const diff = touchStartX - touchEndX;
            if (Math.abs(diff) > 50) {
                navigate(diff > 0 ? 'right' : 'left');
            }
        }, { passive: true });
    });
</script>

@endsection
