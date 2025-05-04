<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Laravel\Pail\ValueObjects\Origin\Console;
use Log;


class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::orderBy('created_at', 'desc')->get();
        return view('admin.orders.index', compact('orders'));
    }

    // {
    //     try {
    //         // Get the order with course, user, and payment relationships
    //         $order = Order::with(['course', 'user', 'payment'])->findOrFail($orderId);

    //         $paymentSlipUrl = null;

    //         // Check if the order has a payment slip
    //         if ($order->payment && $order->payment->payment_slip) {
    //             $path = 'private/slips/' . $order->payment->payment_slip;

    //             // Check if the payment slip file exists in the storage
    //             if (Storage::exists($path)) {
    //                 $fileExtension = pathinfo($order->payment->payment_slip, PATHINFO_EXTENSION);

    //                 // Only allow image files (jpg, jpeg, png, gif)
    //                 if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif'])) {
    //                     $paymentSlipUrl = route('admin.debug.slip', ['filename' => $order->payment->payment_slip]);
    //                 } else {
    //                     Log::warning("Payment slip is not an image file.");
    //                 }
    //             } else {
    //                 Log::warning("Payment slip file not found at path: {$path}");
    //             }
    //         } else {
    //             Log::info("No payment slip associated with this order.");
    //         }

    //         // Prepare the response with order details and the payment slip URL
    //         $response = [
    //             'order' => $order,
    //             'paymentSlipUrl' => $paymentSlipUrl
    //         ];

    //         return response()->json($response);

    //     } catch (\Exception $e) {
    //         Log::error("Error fetching order details: " . $e->getMessage());
    //         return response()->json([
    //             'error' => 'Failed to load order details'
    //         ], 500);
    //     }
    // }

    public function show($orderId)
    {
        try {
            $order = Order::with(['course', 'user', 'payment'])->findOrFail($orderId);

            $paymentSlipUrl = null;

            // Check if the order has a payment slip
            if ($order->payment && $order->payment->payment_slip) {
                $paymentSlipPath = $order->payment->payment_slip;
                $paymentSlipPath = str_replace('slips/', '', $paymentSlipPath);
                $paymentSlipUrl = route('admin.debug.slip', ['filename' => $paymentSlipPath]);
                $fileExtension = pathinfo($paymentSlipPath, PATHINFO_EXTENSION);
                if (!in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif'])) {
                    Log::warning("Payment slip is not an image file.");
                    $paymentSlipUrl = null;
                }
            } else {
                Log::info("No payment slip associated with this order.");
            }

            $response = [
                'order' => $order,
                'paymentSlipUrl' => $paymentSlipUrl
            ];

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error("Error fetching order details: " . $e->getMessage());
            return response()->json([
                'error' => 'Failed to load order details'
            ], 500);
        }
    }


    public function showSlip($filename)
    {
        try {
            $filePath = storage_path('app/private/slips/' . $filename);

            // Check if the file exists and is an image
            if (Storage::exists('private/slips/' . $filename) && in_array(pathinfo($filename, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif'])) {
                return response()->file($filePath);
            } else {
                abort(404, 'File not found or not an image.');
            }

        } catch (\Exception $e) {
            Log::error("Error serving payment slip: " . $e->getMessage());
            abort(500, 'Failed to serve payment slip.');
        }
    }


    public function update(Request $request, Order $order)
    {
        // Validate the incoming request to ensure payment status is one of the allowed values
        $request->validate([
            'payment_status' => 'required|string|in:confirmed,pending,rejected'
        ]);

        // Update the payment status if it exists
        if ($order->payment) {
            $order->payment->status = $request->input('payment_status');
            $order->payment->save();
        }

        // Update the order status
        $order->status = $request->input('payment_status');
        $order->save();

        // Return success response after update
        return response()->json(['success' => true]);
    }

    public function destroy(Order $order)
    {

    }
}
