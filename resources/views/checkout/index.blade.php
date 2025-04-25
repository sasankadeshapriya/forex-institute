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

            <div class="bg-gray-900/50 rounded-xl p-6 md:p-8 border border-gray-800 mb-12">
                <div class="flex flex-col md:flex-row gap-8">
                    <!-- Course Info -->
                    <div class="w-full md:w-1/3">
                        <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">{{ $course->name }}</h1>
                        <p class="text-lg text-white/70 mb-6">{!! $course->description !!}</p>
                        <div class="text-3xl font-bold text-green-400">${{ number_format($course->price, 2) }}</div>
                    </div>

                    <!-- Billing Details (If Available) -->
                    <div class="w-full md:w-2/3">
                        <h3 class="text-xl font-bold text-white mb-4">Billing Details</h3>
                        @if($billing)
                            <p class="text-white"><strong>Address:</strong> {{ $billing->address }}</p>
                            <p class="text-white"><strong>City:</strong> {{ $billing->city }}</p>
                            <p class="text-white"><strong>Postal Code:</strong> {{ $billing->postal_code }}</p>
                            <p class="text-white"><strong>Phone:</strong> {{ $billing->phone_number }}</p>
                        @else
                            <p class="text-white">Please provide your billing details to complete the order.</p>

                            <!-- Billing Form if No Billing Details -->
                            <form action="{{ route('checkout.process', $course->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="address" class="text-white">Address</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address') }}">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="city" class="text-white">City</label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city') }}">
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="postal_code" class="text-white">Postal Code</label>
                                    <input type="text" class="form-control @error('postal_code') is-invalid @enderror" id="postal_code" name="postal_code" value="{{ old('postal_code') }}">
                                    @error('postal_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="phone_number" class="text-white">Phone Number</label>
                                    <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number') }}">
                                    @error('phone_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Payment Slip Upload -->
                                <div class="form-group">
                                    <label for="payment_slip" class="text-white">Payment Slip (Image Only)</label>
                                    <input type="file" class="form-control @error('payment_slip') is-invalid @enderror" id="payment_slip" name="payment_slip">
                                    @error('payment_slip')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">Complete Purchase</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
