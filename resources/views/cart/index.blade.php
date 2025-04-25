@extends('layouts.home')

@section('content')
    <section class="py-12 md:py-20 bg-gradient-to-b from-black/10 to-black/30">
        <div class="container mx-auto px-4 max-w-6xl">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-8">Your Cart</h2>

            @if(session('success'))
                <div class="bg-green-600/20 border border-green-600 text-green-400 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-600/20 border border-red-600 text-red-400 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            @if(count($cart) > 0)
                <div class="space-y-4">
                    @php
                        $totalAmount = 0;
                    @endphp

                    @foreach($cart as $courseId => $quantity)
                        @php
                            $course = \App\Models\Course::find($courseId);
                            $courseTotal = $course->price * $quantity;
                            $totalAmount += $courseTotal;
                        @endphp
                        <div class="bg-gray-900/50 rounded-lg border border-gray-800 p-6 flex justify-between items-center">
                            <div class="flex items-center">
                                @if($course->image)
                                    <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->name }}" class="w-20 h-20 object-cover rounded-lg mr-4">
                                @else
                                    <div class="w-20 h-20 bg-gray-800 rounded-lg mr-4 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                @endif
                                <div>
                                    <h3 class="text-lg font-bold text-white">{{ $course->name }}</h3>
                                    <p class="text-white/70">{{ $course->instructor_name }}</p>
                                    <p class="text-white/60">${{ number_format($course->price, 2) }}</p>
                                </div>
                            </div>
                            <form action="{{ route('cart.remove', $courseId) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-red-500 hover:text-red-400 transition-colors">
                                    Remove
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 bg-gray-900/50 rounded-lg border border-gray-800 p-6 flex justify-between items-center">
                    <div class="text-xl font-bold text-white">Total Amount</div>
                    <div class="text-2xl font-bold text-green-400">${{ number_format($totalAmount, 2) }}</div>
                </div>

                <div class="mt-8 flex justify-end">
                    @if(Auth::check())
                        <a href="{{ route('checkout.index') }}" class="bg-green-600 hover:bg-green-500 text-white px-8 py-3 rounded-full text-lg font-medium transition-colors">
                            Proceed to Checkout
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="bg-green-600 hover:bg-green-500 text-white px-8 py-3 rounded-full text-lg font-medium transition-colors">
                            Log in to Checkout
                        </a>
                    @endif
                </div>
            @else
                <div class="bg-gray-900/50 rounded-lg border border-gray-800 p-8 text-center">
                    <p class="text-white/80 text-lg">Your cart is empty. Start shopping!</p>
                    <a href="{{ route('courses.index') }}" class="inline-block mt-4 bg-green-600 hover:bg-green-500 text-white px-6 py-2 rounded-full text-sm font-medium transition-colors">
                        Browse Courses
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection