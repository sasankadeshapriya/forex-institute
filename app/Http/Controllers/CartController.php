<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function index()
    {
        // Get the cart from session
        $cart = session()->get('cart', []);
        $totalAmount = 0;

        foreach ($cart as $courseId => $quantity) {
            $course = Course::find($courseId);
            $totalAmount += $course->price * $quantity;
        }

        return view('cart.index', compact('cart', 'totalAmount'));
    }

    public function add($courseId)
    {
        $course = Course::findOrFail($courseId);

        // Check if the user is logged in and if they are already enrolled in the course
        if (Auth::check() && Auth::user()->courses->contains($course)) {
            return redirect()->route('cart.index')->with('error', 'You are already enrolled in this course.');
        }

        // Get the current cart session
        $cart = session()->get('cart', []);

        if (isset($cart[$courseId])) {
            return redirect()->route('cart.index')->with('error', 'You can only add one copy of a course.');
        }

        $cart[$courseId] = 1;

        // Store the updated cart in the session
        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Course added to the cart.');
    }

    public function remove($courseId)
    {
        // Get the current cart session
        $cart = session()->get('cart', []);

        if (isset($cart[$courseId])) {
            unset($cart[$courseId]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Course removed from the cart.');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }
}
