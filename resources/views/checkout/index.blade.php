{{-- @extends('layouts.home')

@section('content')
    <section class="py-12 md:py-20 bg-gradient-to-b from-black/10 to-black/30">
        <div class="container mx-auto px-4 max-w-6xl">
            <!-- Checkout Header -->
            <div class="mb-10 text-center md:text-left">
                <h1 class="text-3xl md:text-4xl font-bold text-white">Complete Your Purchase</h1>
                <div class="w-20 h-1 bg-green-500 mt-3 mx-auto md:mx-0"></div>
            </div>

            <!-- Status Messages -->
            @if(session('success'))
                <div class="bg-green-600/20 border border-green-600 text-green-400 px-4 py-3 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-600/20 border border-red-600 text-red-400 px-4 py-3 rounded-lg mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Main Form Wrapper -->
            <form id="checkoutForm" action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="course_ids" value="{{ implode(',', array_keys($cart)) }}">
                <input type="hidden" name="total_amount" value="{{ $totalAmount }}">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column - Order and Billing -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Order Summary Card -->
                        <div class="bg-gray-900/50 rounded-xl border border-gray-800 p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-xl font-bold text-white">Your Courses</h2>
                                <span class="text-sm text-white/60">{{ count($cart) }} items</span>
                            </div>

                            <div class="divide-y divide-gray-800">
                                @php $totalAmount = 0; @endphp
                                @foreach($cart as $courseId => $quantity)
                                    @php
                                        $course = \App\Models\Course::find($courseId);
                                        $courseTotal = $course->price * $quantity;
                                        $totalAmount += $courseTotal;
                                    @endphp
                                    <div class="py-4 flex items-start">
                                        <div class="flex-shrink-0">
                                            @if($course->image)
                                                <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->name }}" class="w-16 h-16 object-cover rounded-lg">
                                            @else
                                                <div class="w-16 h-16 bg-gray-800 rounded-lg flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <h3 class="text-lg font-medium text-white">{{ $course->name }}</h3>
                                            <p class="text-sm text-white/60">{{ $course->instructor_name }}</p>
                                            <div class="mt-1 flex items-center justify-between">
                                                <span class="text-sm text-white/70">${{ number_format($course->price, 2) }} × {{ $quantity }}</span>
                                                <span class="text-green-400 font-medium">${{ number_format($courseTotal, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Billing Information Card -->
                        <div class="bg-gray-900/50 rounded-xl border border-gray-800 p-6">
                            <h2 class="text-xl font-bold text-white mb-4">Billing Information</h2>

                            @if($billing)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-white/60 mb-1">Address</p>
                                        <p class="text-white">{{ $billing->address }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-white/60 mb-1">City</p>
                                        <p class="text-white">{{ $billing->city }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-white/60 mb-1">Postal Code</p>
                                        <p class="text-white">{{ $billing->postal_code }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-white/60 mb-1">Phone</p>
                                        <p class="text-white">{{ $billing->phone_number }}</p>
                                    </div>
                                </div>

                                <!-- Hidden fields for existing billing info -->
                                <input type="hidden" name="address" value="{{ $billing->address }}">
                                <input type="hidden" name="city" value="{{ $billing->city }}">
                                <input type="hidden" name="postal_code" value="{{ $billing->postal_code }}">
                                <input type="hidden" name="phone_number" value="{{ $billing->phone_number }}">
                            @else
                                <div class="space-y-4">
                                    <div>
                                        <label for="address" class="block text-sm font-medium text-white/80 mb-2">Street Address</label>
                                        <input type="text" id="address" name="address" value="{{ old('address') }}"
                                            class="w-full bg-gray-800/50 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-green-500 focus:ring-green-500"
                                            placeholder="123 Main St" required>
                                        @error('address')
                                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="city" class="block text-sm font-medium text-white/80 mb-2">City</label>
                                            <input type="text" id="city" name="city" value="{{ old('city') }}"
                                                class="w-full bg-gray-800/50 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-green-500 focus:ring-green-500"
                                                placeholder="New York" required>
                                            @error('city')
                                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="postal_code" class="block text-sm font-medium text-white/80 mb-2">Postal Code</label>
                                            <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code') }}"
                                                class="w-full bg-gray-800/50 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-green-500 focus:ring-green-500"
                                                placeholder="10001" required>
                                            @error('postal_code')
                                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div>
                                        <label for="phone_number" class="block text-sm font-medium text-white/80 mb-2">Phone Number</label>
                                        <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}"
                                            class="w-full bg-gray-800/50 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-green-500 focus:ring-green-500"
                                            placeholder="+1 (555) 123-4567" required>
                                        @error('phone_number')
                                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Right Column - Payment Summary -->
                    <div class="space-y-6">
                        <!-- Order Total Card -->
                        <div class="bg-gray-900/50 rounded-xl border border-gray-800 p-6">
                            <h2 class="text-xl font-bold text-white mb-4">Order Summary</h2>

                            <div class="space-y-3">
                                @foreach($cart as $courseId => $quantity)
                                    @php $course = \App\Models\Course::find($courseId); @endphp
                                    <div class="flex justify-between text-white/80">
                                        <span>{{ $course->name }} × {{ $quantity }}</span>
                                        <span>${{ number_format($course->price * $quantity, 2) }}</span>
                                    </div>
                                @endforeach

                                <div class="border-t border-gray-800 my-3"></div>

                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-white">Total</span>
                                    <span class="text-2xl font-bold text-green-400">${{ number_format($totalAmount, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method Card -->
                        <div class="bg-gray-900/50 rounded-xl border border-gray-800 p-6">
                            <h2 class="text-xl font-bold text-white mb-4">Payment Method</h2>

                            <div class="space-y-4">
                                <div>
                                    <div class="flex items-center">
                                        <input type="radio" id="bank_transfer" name="payment_method" value="bank_transfer" checked
                                            class="h-5 w-5 text-green-500 focus:ring-green-500 border-gray-700">
                                        <label for="bank_transfer" class="ml-3 block text-white">Bank Transfer</label>
                                    </div>
                                </div>

                                <div class="bg-gray-800/50 border border-gray-700 rounded-lg p-4">
                                    <h4 class="font-bold text-white mb-2">Bank Details</h4>
                                    <div class="text-sm text-white/80 space-y-1">
                                        <p><span class="font-medium">Bank:</span> XYZ Bank</p>
                                        <p><span class="font-medium">Account:</span> 123456789</p>
                                        <p><span class="font-medium">Name:</span> John Doe</p>
                                        <p><span class="font-medium">Reference:</span> Forex Course</p>
                                    </div>
                                </div>

                                <div>
                                    <label for="payment_slip" class="block text-sm font-medium text-white/80 mb-2">Upload Payment Slip</label>
                                    <div class="mt-1">
                                        <input type="file" id="payment_slip" name="payment_slip" required
                                            class="block w-full text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-600/50 file:text-white hover:file:bg-green-600/70">
                                        @error('payment_slip')
                                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Complete Purchase Button -->
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-500 text-white px-6 py-4 rounded-xl text-lg font-bold transition-colors flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Complete Purchase
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('checkoutForm');

            if (form) {
                console.log('Checkout form found');

                form.addEventListener('submit', function(e) {
                    console.log('Form submission initiated');

                    // Optional: Add validation or confirmation here
                    // Example: Confirm payment slip is uploaded
                    const paymentSlip = document.getElementById('payment_slip');
                    if (paymentSlip.files.length === 0) {
                        e.preventDefault();
                        alert('Please upload a payment slip');
                        return false;
                    }

                    console.log('All validation passed, submitting form...');
                });
            } else {
                console.error('Checkout form not found!');
            }
        });
    </script>
    @endpush
@endsection --}}

@extends('layouts.home')

@section('content')
    <section class="py-12 md:py-20 bg-gradient-to-b from-black/10 to-black/30">
        <div class="container mx-auto px-4 max-w-6xl">
            <!-- Checkout Header -->
            <div class="mb-10 text-center md:text-left">
                <h1 class="text-3xl md:text-4xl font-bold text-white">Complete Your Purchase</h1>
                <div class="w-20 h-1 bg-green-500 mt-3 mx-auto md:mx-0"></div>
            </div>

            <!-- Status Messages -->
            @if(session('success'))
                <div class="bg-green-600/20 border border-green-600 text-green-400 px-4 py-3 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-600/20 border border-red-600 text-red-400 px-4 py-3 rounded-lg mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Main Form -->
            <form id="checkoutForm" action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="course_ids" value="{{ implode(',', array_keys($cart)) }}">
                <input type="hidden" name="total_amount" value="{{ $totalAmount }}">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column - Order and Billing -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Order Summary Card -->
                        <div class="bg-gray-900/50 rounded-xl border border-gray-800 p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-xl font-bold text-white">Your Courses</h2>
                                <span class="text-sm text-white/60">{{ count($cart) }} items</span>
                            </div>

                            <div class="divide-y divide-gray-800">
                                @php $totalAmount = 0; @endphp
                                @foreach($cart as $courseId => $quantity)
                                    @php
                                        $course = \App\Models\Course::find($courseId);
                                        $courseTotal = $course->price * $quantity;
                                        $totalAmount += $courseTotal;
                                    @endphp
                                    <div class="py-4 flex items-start">
                                        <div class="flex-shrink-0">
                                            @if($course->image)
                                                <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->name }}" class="w-16 h-16 object-cover rounded-lg">
                                            @else
                                                <div class="w-16 h-16 bg-gray-800 rounded-lg flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <h3 class="text-lg font-medium text-white">{{ $course->name }}</h3>
                                            <p class="text-sm text-white/60">{{ $course->instructor_name }}</p>
                                            <div class="mt-1 flex items-center justify-between">
                                                <span class="text-sm text-white/70">${{ number_format($course->price, 2) }} × {{ $quantity }}</span>
                                                <span class="text-green-400 font-medium">${{ number_format($courseTotal, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Billing Information Card -->
                        <div class="bg-gray-900/50 rounded-xl border border-gray-800 p-6">
                            <h2 class="text-xl font-bold text-white mb-4">Billing Information</h2>

                            @if($billing)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-white/60 mb-1">Address</p>
                                        <p class="text-white">{{ $billing->address }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-white/60 mb-1">City</p>
                                        <p class="text-white">{{ $billing->city }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-white/60 mb-1">Postal Code</p>
                                        <p class="text-white">{{ $billing->postal_code }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-white/60 mb-1">Phone</p>
                                        <p class="text-white">{{ $billing->phone_number }}</p>
                                    </div>
                                </div>

                                <!-- Hidden fields for existing billing info -->
                                <input type="hidden" name="address" value="{{ $billing->address }}">
                                <input type="hidden" name="city" value="{{ $billing->city }}">
                                <input type="hidden" name="postal_code" value="{{ $billing->postal_code }}">
                                <input type="hidden" name="phone_number" value="{{ $billing->phone_number }}">
                            @else
                                <div class="space-y-4">
                                    <div>
                                        <label for="address" class="block text-sm font-medium text-white/80 mb-2">Street Address</label>
                                        <input type="text" id="address" name="address" value="{{ old('address') }}"
                                            class="w-full bg-gray-800/50 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-green-500 focus:ring-green-500"
                                            placeholder="123 Main St" required>
                                        @error('address')
                                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="city" class="block text-sm font-medium text-white/80 mb-2">City</label>
                                            <input type="text" id="city" name="city" value="{{ old('city') }}"
                                                class="w-full bg-gray-800/50 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-green-500 focus:ring-green-500"
                                                placeholder="New York" required>
                                            @error('city')
                                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="postal_code" class="block text-sm font-medium text-white/80 mb-2">Postal Code</label>
                                            <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code') }}"
                                                class="w-full bg-gray-800/50 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-green-500 focus:ring-green-500"
                                                placeholder="10001" required>
                                            @error('postal_code')
                                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div>
                                        <label for="phone_number" class="block text-sm font-medium text-white/80 mb-2">Phone Number</label>
                                        <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}"
                                            class="w-full bg-gray-800/50 border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-green-500 focus:ring-green-500"
                                            placeholder="+1 (555) 123-4567" required>
                                        @error('phone_number')
                                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Right Column - Payment Summary -->
                    <div class="space-y-6">
                        <!-- Order Total Card -->
                        <div class="bg-gray-900/50 rounded-xl border border-gray-800 p-6">
                            <h2 class="text-xl font-bold text-white mb-4">Order Summary</h2>

                            <div class="space-y-3">
                                @foreach($cart as $courseId => $quantity)
                                    @php $course = \App\Models\Course::find($courseId); @endphp
                                    <div class="flex justify-between text-white/80">
                                        <span>{{ $course->name }} × {{ $quantity }}</span>
                                        <span>${{ number_format($course->price * $quantity, 2) }}</span>
                                    </div>
                                @endforeach

                                <div class="border-t border-gray-800 my-3"></div>

                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-white">Total</span>
                                    <span class="text-2xl font-bold text-green-400">${{ number_format($totalAmount, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method Card -->
                        <div class="bg-gray-900/50 rounded-xl border border-gray-800 p-6">
                            <h2 class="text-xl font-bold text-white mb-4">Payment Method</h2>

                            <div class="space-y-4">
                                <div>
                                    <div class="flex items-center">
                                        <input type="radio" id="bank_transfer" name="payment_method" value="bank_transfer" checked
                                            class="h-5 w-5 text-green-500 focus:ring-green-500 border-gray-700">
                                        <label for="bank_transfer" class="ml-3 block text-white">Bank Transfer</label>
                                    </div>
                                </div>

                                <div class="bg-gray-800/50 border border-gray-700 rounded-lg p-4">
                                    <h4 class="font-bold text-white mb-2">Bank Details</h4>
                                    <div class="text-sm text-white/80 space-y-1">
                                        <p><span class="font-medium">Bank:</span> XYZ Bank</p>
                                        <p><span class="font-medium">Account:</span> 123456789</p>
                                        <p><span class="font-medium">Name:</span> John Doe</p>
                                        <p><span class="font-medium">Reference:</span> Forex Course</p>
                                    </div>
                                </div>

                                <div>
                                    <label for="payment_slip" class="block text-sm font-medium text-white/80 mb-2">Upload Payment Slip</label>
                                    <div class="mt-1">
                                        <input type="file" id="payment_slip" name="payment_slip" required
                                            class="block w-full text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-600/50 file:text-white hover:file:bg-green-600/70">
                                        @error('payment_slip')
                                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Complete Purchase Button -->
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-500 text-white px-6 py-4 rounded-xl text-lg font-bold transition-colors flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Complete Purchase
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('checkoutForm');

            if (form) {
                console.log('Checkout form found');

                form.addEventListener('submit', function(e) {
                    const paymentSlip = document.getElementById('payment_slip');
                    if (paymentSlip.files.length === 0) {
                        e.preventDefault();
                        alert('Please upload a payment slip');
                        return false;
                    }

                    // Show loading state
                    const submitBtn = form.querySelector('button[type="submit"]');
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = `
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Processing...
                    `;
                });
            }
        });
    </script>
    @endpush
@endsection