@extends('layouts.home')

@section('content')
    <section class="py-12 md:py-20 bg-gradient-to-b from-black/10 to-black/30">
        <div class="container mx-auto px-4 max-w-6xl">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-8">Your Cart</h2>

            @if(session('success'))
                <div class="alert alert-success mb-4 text-white">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error mb-4 text-red-500">
                    {{ session('error') }}
                </div>
            @endif

            @if(count($cart) > 0)
                <div class="space-y-6">
                    @foreach($cart as $courseId => $quantity)
                        @php
                            $course = \App\Models\Course::find($courseId);
                        @endphp
                        <div class="bg-gray-900/50 rounded-lg border border-gray-800 p-6 flex justify-between items-center">
                            <div class="flex items-center">
                                @if($course->image)
                                    <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->name }}" class="w-20 h-20 object-cover rounded-lg mr-4">
                                @else
                                    <div class="w-20 h-20 bg-gray-800 rounded-lg mr-4"></div>
                                @endif
                                <div>
                                    <h3 class="text-lg font-bold text-white">{{ $course->name }}</h3>
                                    <p class="text-white/70">{{ $course->instructor_name }}</p>
                                    <p class="text-white/60">${{ number_format($course->price, 2) }}</p>
                                    <p class="text-white/70">Quantity: 1</p>
                                </div>
                            </div>
                            <form action="{{ route('cart.remove', $courseId) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-red-500 hover:text-red-600">Remove</button>
                            </form>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-between items-center mt-6">
                    <div class="text-2xl font-bold text-white">Total: ${{ number_format($totalAmount, 2) }}</div>

                    @if(Auth::check())
                        <a href="{{ route('checkout.index') }}" class="bg-green-600 text-white px-6 py-3 rounded-full text-sm font-medium">Proceed to Checkout</a>
                    @else
                        <a href="{{ route('login') }}" class="bg-green-600 text-white px-6 py-3 rounded-full text-sm font-medium">Log in to Checkout</a>
                    @endif
                </div>
            @else
                <p class="text-white">Your cart is empty. Start shopping!</p>
            @endif
        </div>
    </section>
@endsection
