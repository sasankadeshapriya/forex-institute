@extends('layouts.home')

@section('content')

    <!-- Hero Section -->
    <section class="hero-section min-h-screen flex items-center justify-center">
        <div class="container mx-auto px-4 py-20 flex flex-col items-center text-center">
            <div class="max-w-2xl">
                <h1 class="text-4xl md:text-5xl font-bold mb-6">
                    Forex Trading Like a Pro
                </h1>
                <p class="text-lg md:text-xl mb-8">
                    Join our comprehensive course and learn the secrets of successful currency trading from industry experts with years of market experience.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}"
                    class="cta-button text-white font-bold px-8 py-3 rounded-full text-center">
                        Start Learning Now
                    </a>
                    <a href="#features"
                    class="border border-white text-white font-bold px-8 py-3 rounded-full hover:bg-white hover:text-black transition-colors text-center">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    </section>


    <!-- Features Section -->
    <section id="features" class="py-12 md:py-20">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-8 md:mb-16">Why Choose Our Forex Course?</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
                <!-- Feature 1 -->
                <div class="feature-card p-6 md:p-8 rounded-xl">
                    <div class="text-4xl md:text-5xl mb-3 md:mb-4 text-green-500">01</div>
                    <h3 class="text-xl md:text-2xl font-bold mb-3 md:mb-4">Expert Instructors</h3>
                    <p class="text-sm md:text-base">Learn from professional traders with over 10 years of market experience and proven track records.</p>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card p-6 md:p-8 rounded-xl">
                    <div class="text-4xl md:text-5xl mb-3 md:mb-4 text-green-500">02</div>
                    <h3 class="text-xl md:text-2xl font-bold mb-3 md:mb-4">Comprehensive Curriculum</h3>
                    <p class="text-sm md:text-base">From basics to advanced strategies, our course covers everything you need to trade successfully.</p>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card p-6 md:p-8 rounded-xl">
                    <div class="text-4xl md:text-5xl mb-3 md:mb-4 text-green-500">03</div>
                    <h3 class="text-xl md:text-2xl font-bold mb-3 md:mb-4">Live Trading Sessions</h3>
                    <p class="text-sm md:text-base">Watch real-time market analysis and trading with explanations from our experts.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-12 md:py-20 bg-black bg-opacity-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-8 md:mb-16">Success Stories</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8 max-w-6xl mx-auto">
                <!-- Testimonial 1 -->
                <div class="bg-gray-900 p-6 md:p-8 rounded-xl">
                    <div class="flex items-center mb-3 md:mb-4">
                        <div class="w-10 h-10 md:w-12 md:h-12 rounded-full overflow-hidden mr-3 md:mr-4">
                            <img src="/frontend/profile_pic3.jpg" alt="Michael R." class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="font-bold text-sm md:text-base">Michael R.</h4>
                            <p class="text-gray-400 text-xs md:text-sm">Professional Trader</p>
                        </div>
                    </div>
                    <p class="text-sm md:text-base">"This course transformed my trading approach. I went from losing money to consistent profits within 3 months. The risk management module alone was worth the price!"</p>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-gray-900 p-6 md:p-8 rounded-xl">
                    <div class="flex items-center mb-3 md:mb-4">
                        <div class="w-10 h-10 md:w-12 md:h-12 rounded-full overflow-hidden mr-3 md:mr-4">
                            <img src="/frontend/profile_pic2.jpg" alt="Sarah K." class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="font-bold text-sm md:text-base">Sarah K.</h4>
                            <p class="text-gray-400 text-xs md:text-sm">Part-time Trader</p>
                        </div>
                    </div>
                    <p class="text-sm md:text-base">"As someone with a full-time job, the flexible learning format was perfect. I now make more from trading than my day job thanks to this course."</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-12 md:py-20">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6 md:mb-8">Ready to Transform Your Trading?</h2>
            <p class="text-lg md:text-xl mb-6 md:mb-8 max-w-2xl mx-auto">Join thousands of successful traders who started with our course. Limited spots available for our next cohort.</p>
            <a href="{{ route('register') }}" class="cta-button text-white font-bold px-8 py-3 rounded-full inline-block">
                Enroll Now
            </a>
        </div>
    </section>

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

@endsection