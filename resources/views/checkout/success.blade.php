@extends('layouts.home')

@section('content')
    <section class="py-12 md:py-20 bg-gradient-to-b from-black/10 to-black/30">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="text-center md:text-left mb-10">
                <h1 class="text-3xl md:text-4xl font-bold text-white">Order Success</h1>
                <div class="w-20 h-1 bg-green-500 mt-3 mx-auto md:mx-0"></div>
            </div>

            <!-- Success Message -->
            <div class="bg-gray-900/50 rounded-xl border border-gray-800 p-6 mb-6">
                <h3 class="text-lg font-medium text-white">Your Order has been placed successfully!</h3>
            </div>

            <!-- Order Details -->
            <div class="bg-gray-900/50 rounded-xl border border-gray-800 p-6">
                <h3 class="text-lg font-medium text-white">Your Courses</h3>
                @foreach($orders as $order)
                    <div class="py-4 flex items-start">
                        <div class="flex-shrink-0">
                            @if($order->course->image)
                                <img src="{{ asset('storage/' . $order->course->image) }}" alt="{{ $order->course->name }}" class="w-16 h-16 object-cover rounded-lg">
                            @else
                                <div class="w-16 h-16 bg-gray-800 rounded-lg flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="ml-4 flex-1">
                            <h4 class="text-lg font-medium text-white">{{ $order->course->name }}</h4>
                            <p class="text-sm text-white/60">{{ $order->course->instructor_name }}</p>
                            <div class="mt-1 flex items-center justify-between">
                                <span class="text-sm text-white/70">${{ number_format($order->course->price, 2) }}</span>
                                <span class="text-green-400 font-medium">${{ number_format($order->amount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Total Amount -->
            <div class="bg-gray-900/50 rounded-xl border border-gray-800 p-6 mb-6">
                <h3 class="text-lg font-medium text-white">Total Amount</h3>
                <div class="mt-3 flex justify-between items-center">
                    <span class="text-lg font-bold text-white">Total</span>
                    <span class="text-2xl font-bold text-green-400">${{ number_format($totalCost, 2) }}</span>
                </div>
            </div>
        </div>
    </section>
@endsection
