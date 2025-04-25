<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Billing;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CheckoutController extends Controller
{
    // Show the checkout page
    public function show(Course $course)
    {
        // Check if the user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'You need to log in to continue.');
        }

        // Check if the user has billing information
        $billing = Auth::user()->billing;

        return view('checkout.index', compact('course', 'billing'));
    }

    // Process the order with payment slip
    public function processOrder(Request $request, Course $course)
    {
        $user = Auth::user();

        // Validate the payment slip if the user selects "bank transfer" payment method
        $request->validate([
            'payment_slip' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // If the user does not have billing details, validate and create them
        if (!$user->billing) {
            $request->validate([
                'address' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'postal_code' => 'required|string|max:10',
                'phone_number' => 'required|string|max:20',
            ]);

            // Create new billing record
            $billing = $user->billing()->create([
                'address' => $request->address,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'phone_number' => $request->phone_number,
            ]);
        }

        // Process payment slip upload
        if ($request->hasFile('payment_slip')) {
            $file = $request->file('payment_slip');
            $timestamp = now()->format('Y-m-d_H-i-s');
            $imageName = $timestamp . '_' . $file->getClientOriginalName();
            $imagePath = $file->storeAs('slips', $imageName, 'private');  // Store in 'slips' folder

            // Create the order with the payment slip path
            $order = Order::create([
                'user_id' => $user->id,
                'course_id' => $course->id,  // Ensure course_id is assigned
                'amount' => $course->price,  // Ensure the price is correctly assigned
                'status' => 'pending',
            ]);

            // Create payment record with payment slip path
            Payment::create([
                'order_id' => $order->id,
                'status' => 'pending',
                'payment_slip' => $imagePath,  // Store the path to the payment slip
            ]);

            return redirect()->route('checkout.success', ['order' => $order->id])
                ->with('message', 'Your order is placed and is awaiting payment.');
        }

        return redirect()->back()->with('error', 'Please upload a valid payment slip.');
    }

    // Show success message
    public function success(Order $order)
    {
        return view('checkout.success', compact('order'));
    }
}