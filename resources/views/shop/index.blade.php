@extends('layouts.home')

@section('content')
    <!-- Courses Section -->
    <section id="courses" class="py-12 md:py-20 bg-gradient-to-b from-black/10 to-black/30">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4 text-white">Our Trading Courses</h2>
                <div class="w-20 h-1 bg-green-500 mx-auto mb-6"></div>
                <p class="text-lg md:text-xl max-w-2xl mx-auto text-white/70">Expert-led programs to accelerate your trading journey</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($courses as $course)
                <div class="bg-gray-900/50 rounded-xl overflow-hidden border border-gray-800 hover:border-green-500/50 transition-all duration-300 hover:shadow-xl hover:shadow-green-500/10">
                    <!-- Course Image -->
                    <div class="relative h-48 overflow-hidden">
                        @if($course->image)
                        <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->name }}"
                             class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                        @else
                        <div class="w-full h-full bg-gradient-to-br from-gray-800 to-gray-900 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        @endif
                        <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-black/90 to-transparent"></div>
                    </div>

                    <!-- Course Content -->
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-bold text-white">{{ $course->name }}</h3>
                            <span class="bg-green-500/20 text-green-400 text-sm font-medium px-3 py-1 rounded-full">
                                {{ $course->duration }}h
                            </span>
                        </div>

                        <p class="text-white/60 mb-2 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            {{ $course->instructor_name }}
                        </p>

                        <div class="flex justify-between items-center mt-6">
                            <span class="text-2xl font-bold text-green-400">
                                ${{ number_format($course->price, 2) }}
                            </span>
                            <a href="{{ route('courses.show', $course) }}"
                               class="flex items-center px-5 py-2 bg-green-600 hover:bg-green-500 text-white rounded-full text-sm font-medium transition-all">
                                Enroll Now
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection