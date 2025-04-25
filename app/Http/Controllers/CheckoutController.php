<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Billing;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CheckoutController extends Controller
{
    // public function show()
    // {
    //     // Get the cart from session
    //     $cart = session()->get('cart', []);
    //     $totalAmount = 0;

    //     // Get course details and calculate the total amount
    //     foreach ($cart as $courseId => $quantity) {
    //         $course = Course::find($courseId);
    //         if ($course) {
    //             $totalAmount += $course->price * $quantity;
    //         }
    //     }

    //     // Get user's billing info
    //     $billing = Auth::user()->billing;

    //     return view('checkout.index', compact('cart', 'totalAmount', 'billing'));
    // }

    // public function processOrder(Request $request)
    // {
    //     $user = Auth::user();

    //     // Validate the form inputs
    //     $validated = $request->validate([
    //         'payment_method' => 'required|string',
    //         'payment_slip' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'address' => 'required|string|max:255',
    //         'city' => 'required|string|max:255',
    //         'postal_code' => 'required|string|max:10',
    //         'phone_number' => 'required|string|max:20',
    //     ]);

    //     // Check if the user has existing billing details, or create new ones
    //     $billing = $user->billing ?? $user->billing()->create([
    //         'address' => $validated['address'],
    //         'city' => $validated['city'],
    //         'postal_code' => $validated['postal_code'],
    //         'phone_number' => $validated['phone_number'],
    //     ]);

    //     // Process payment slip upload
    //     $paymentSlipPath = null;
    //     if ($request->hasFile('payment_slip')) {
    //         $file = $request->file('payment_slip');
    //         $timestamp = now()->format('Y-m-d_H-i-s');
    //         $imageName = $timestamp . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    //         $paymentSlipPath = $file->storeAs('slips', $imageName, 'private');
    //     }

    //     // Process each course in the cart
    //     $cart = session()->get('cart', []);
    //     $totalAmount = 0;
    //     $orderIds = [];

    //     foreach ($cart as $courseId => $quantity) {
    //         $course = Course::find($courseId);

    //         // Create the order for the course
    //         $order = Order::create([
    //             'user_id' => $user->id,
    //             'course_id' => $course->id,
    //             'amount' => $course->price * $quantity,
    //             'status' => 'pending',
    //         ]);

    //         // Create the payment for the order
    //         Payment::create([
    //             'order_id' => $order->id,
    //             'payment_slip' => $paymentSlipPath,
    //             'status' => 'pending',
    //         ]);

    //         // Store the order ID for redirection
    //         $orderIds[] = $order->id;
    //         $totalAmount += $course->price * $quantity;
    //     }

    //     // Clear the cart after successful checkout
    //     session()->forget('cart');

    //     return redirect()->route('checkout.success', ['order' => $orderIds[0]])->with('success', 'Your order is placed and is awaiting payment.');
    // }

    // public function success($orderId)
    // {
    //     // Fetch the order along with its associated course
    //     $order = Order::with('course')->findOrFail($orderId);

    //     // Debugging: Check if a course is associated with the order
    //     if (!$order->course) {
    //         dd('No course associated with this order.');
    //     }

    //     return view('checkout.success', compact('order'));
    // }

    public function show()
    {
        // Get the cart from session
        $cart = session()->get('cart', []);
        $totalAmount = 0;

        // Get course details and calculate the total amount
        foreach ($cart as $courseId => $quantity) {
            $course = Course::find($courseId);
            if ($course) {
                $totalAmount += $course->price * $quantity;
            }
        }

        // Get user's billing info
        $billing = Auth::user()->billing;

        return view('checkout.index', compact('cart', 'totalAmount', 'billing'));
    }

    public function processOrder(Request $request)
    {
        $user = Auth::user();

        // Validate the form inputs
        $validated = $request->validate([
            'payment_method' => 'required|string',
            'payment_slip' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'phone_number' => 'required|string|max:20',
        ]);

        // Check if the user has existing billing details, or create new ones
        $billing = $user->billing ?? $user->billing()->create([
            'address' => $validated['address'],
            'city' => $validated['city'],
            'postal_code' => $validated['postal_code'],
            'phone_number' => $validated['phone_number'],
        ]);

        // Process payment slip upload
        $paymentSlipPath = null;
        if ($request->hasFile('payment_slip')) {
            $file = $request->file('payment_slip');
            $timestamp = now()->format('Y-m-d_H-i-s');
            $imageName = $timestamp . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $paymentSlipPath = $file->storeAs('slips', $imageName, 'private');
        }

        // Process each course in the cart
        $cart = session()->get('cart', []);
        $totalAmount = 0;
        $orderIds = [];

        foreach ($cart as $courseId => $quantity) {
            $course = Course::find($courseId);

            // Create the order for the course
            $order = Order::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'amount' => $course->price * $quantity,
                'status' => 'pending',
            ]);

            // Create the payment for the order
            Payment::create([
                'order_id' => $order->id,
                'payment_slip' => $paymentSlipPath,
                'status' => 'pending',
            ]);

            // Store the order ID for redirection
            $orderIds[] = $order->id;
            $totalAmount += $course->price * $quantity;
        }

        // Store the orderId in the session for success page
        session(['orderId' => $orderIds]);

        // Clear the cart after successful checkout
        session()->forget('cart');

        return redirect()->route('checkout.success')->with('success', 'Your order is placed and is awaiting payment.');
    }

    public function success()
    {
        // Fetch the order IDs from the session
        $orderIds = session('orderId');

        if (!$orderIds) {
            return redirect()->route('cart.index');
        }

        // Fetch orders along with courses
        $orders = Order::with('course')->whereIn('id', $orderIds)->get();

        // Calculate the total cost of the order
        $totalCost = 0;
        foreach ($orders as $order) {
            $totalCost += $order->amount; // Assuming each order has an amount field for the cost
        }

        // Remove the orderId from the session to prevent revisiting the success page
        session()->forget('orderId');

        return view('checkout.success', compact('orders', 'totalCost'));
    }
}
