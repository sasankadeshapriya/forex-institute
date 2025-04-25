@extends('layouts.home')

@section('content')
    <section class="py-12 md:py-20 bg-gradient-to-b from-black/10 to-black/30">
        <div class="container mx-auto px-4 max-w-6xl">
            <!-- Back Button -->
            <div class="mb-8">
                <a href="{{ url()->previous() }}" class="inline-flex items-center text-white hover:text-green-400 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Courses
                </a>
            </div>

            <!-- Course Header -->
            <div class="bg-gray-900/50 rounded-xl p-6 md:p-8 border border-gray-800 mb-12">
                <div class="flex flex-col md:flex-row gap-8">
                    <!-- Course Image -->
                    <div class="w-full md:w-1/3">
                        @if($course->image)
                        <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->name }}"
                             class="w-full h-auto rounded-lg object-cover shadow-lg">
                        @else
                        <div class="w-full h-48 bg-gradient-to-br from-gray-800 to-gray-900 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        @endif
                    </div>

                    <!-- Course Info -->
                    <div class="w-full md:w-2/3">
                        <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">{{ $course->name }}</h1>
                        <p class="text-lg text-white/70 mb-6">{!! $course->description !!}</p>

                        <!-- Instructor and Rating -->
                        <div class="flex items-center mb-6">
                            <div class="flex items-center mr-8">
                                <img src="/frontend/profile_pic1.jpg" alt="{{ $course->instructor_name }}" class="w-8 h-8 rounded-full mr-2 object-cover">
                                <span class="text-white">{{ $course->instructor_name }}</span>
                            </div>
                            <div class="flex items-center">
                                <div class="flex mr-2">
                                    <span class="text-yellow-400">★★★★★</span>
                                </div>
                                <span class="text-white/70">5.0 (24 ratings)</span>
                            </div>
                        </div>

                        <!-- Duration and Price -->
                        <div class="flex flex-wrap items-center justify-between mb-6">
                            <div class="flex items-center mb-4 md:mb-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-white">{{ $course->duration }} hours of content</span>
                            </div>
                            <div class="text-3xl font-bold text-green-400">${{ number_format($course->price, 2) }}</div>
                        </div>

                        <!-- Enroll Now Button (Changed to Form submission) -->
                        <form action="{{ route('cart.add', $course->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-500 text-white font-bold px-6 py-3 rounded-full text-center transition-colors block">
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Course Content -->
            <div class="mb-12">
                <h2 class="text-2xl md:text-3xl font-bold text-white mb-6">Course Curriculum</h2>

                <div class="space-y-2">
                    @foreach ($contents as $index => $content)
                    <div class="bg-gray-900/50 rounded-lg border border-gray-800 overflow-hidden">
                        <div class="p-4 md:p-6">
                            <div class="flex justify-between items-center">
                                <h3 class="text-xl font-bold text-white">{{ $content->heading }}</h3>
                                @if($index > 0)
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    <span class="text-sm text-gray-400">Locked</span>
                                </div>
                                @else
                                <button onclick="toggleContent(this)" class="text-green-400 hover:text-green-300 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                @endif
                            </div>

                            @if($index == 0 && $content->show_content)
                                <div class="content-section mt-4" style="display: none;">
                                    @if($content->content_type == 'text')
                                        <div class="prose prose-invert max-w-none text-white/80">
                                            {!! $content->content !!}
                                        </div>
                                    @endif

                                    @if($content->content_type == 'video')
                                        <div class="mt-4 relative" style="padding-bottom: 56.25%; height: 0; overflow: hidden;">
                                            <iframe src="https://drive.google.com/file/d/{{ $content->content }}/preview"
                                                    class="absolute top-0 left-0 w-full h-full"
                                                    style="border: none;"
                                                    allow="autoplay; fullscreen"
                                                    allowfullscreen></iframe>
                                        </div>
                                    @endif

                                    @if(in_array($content->content_type, ['pdf', 'file']))
                                        <div class="mt-4">
                                            <a href="{{ route('file.download', ['fileName' => basename($content->content)]) }}"
                                               target="_blank"
                                               class="inline-flex items-center px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white rounded-lg transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                </svg>
                                                Download {{ strtoupper($content->content_type) }}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Instructor Section -->
            <div class="mb-12">
                <h2 class="text-2xl md:text-3xl font-bold text-white mb-6">Meet Your Instructor</h2>
                <div class="bg-gray-900/50 rounded-xl p-6 border border-gray-800">
                    <div class="flex flex-col md:flex-row items-center gap-6">
                        <img src="/frontend/profile_pic1.jpg" alt="{{ $course->instructor_name }}" class="w-24 h-24 rounded-full object-cover border-2 border-green-500">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-white mb-2">{{ $course->instructor_name }}</h3>
                            <p class="text-green-400 font-medium mb-3">Senior Forex Analyst & Trading Mentor</p>
                            <p class="text-white/80 mb-4">With over a decade of experience in currency markets, {{ $course->instructor_name }} has helped thousands of traders develop profitable strategies. Former hedge fund manager with specialization in technical analysis and risk management.</p>
                            <div class="flex items-center text-sm text-white/60">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                <span>4,800+ students enrolled</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reviews Section -->
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-white mb-6">What Our Students Say</h2>
                <div class="bg-gray-900/50 rounded-xl p-6 border border-gray-800">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
                        <div>
                            <div class="text-4xl font-bold text-white mb-2">4.9</div>
                            <div class="flex mb-2">
                                <span class="text-yellow-400 text-2xl">★★★★★</span>
                            </div>
                            <div class="text-white/70">Based on 24 reviews</div>
                        </div>
                        <button class="mt-4 md:mt-0 px-6 py-2 bg-green-600 hover:bg-green-500 text-white rounded-full font-medium transition-colors">
                            Write a Review
                        </button>
                    </div>

                    <!-- Review Item -->
                    <div class="border-t border-gray-800 pt-6">
                        <div class="flex items-center mb-4">
                            <img src="/frontend/profile_pic4.jpg" alt="John Doe" class="w-12 h-12 rounded-full mr-4 object-cover">
                            <div>
                                <h4 class="font-bold text-white">Lakshi Rathnayake</h4>
                                <div class="flex items-center">
                                    <span class="text-yellow-400 mr-2">★★★★★</span>
                                    <span class="text-white/60 text-sm">3 days ago</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-white/80 mb-4">"This course exceeded all my expectations. The way {{ $course->instructor_name }} explains complex trading concepts makes them so accessible. I've already implemented strategies that have improved my trading results significantly."</p>
                        <div class="flex items-center text-sm text-white/60">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                            <span>Completed Course: 1 week ago</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function toggleContent(button) {
            const contentSection = button.closest('.bg-gray-900\\/50').querySelector('.content-section');
            const icon = button.querySelector('svg');

            if (contentSection.style.display === 'none') {
                contentSection.style.display = 'block';
                icon.setAttribute('transform', 'rotate(180)');
            } else {
                contentSection.style.display = 'none';
                icon.removeAttribute('transform');
            }
        }
    </script>
@endsection