<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\CourseProgress;

class UserDashboard extends Controller
{
    public function index()
    {
        // Check if the user is an admin
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Get the last purchase order for the logged-in user
        $lastOrder = Order::where('user_id', Auth::id())
            ->where('status', 'completed')   // Check if status is 'completed'
            ->whereNull('deleted_at')
            ->latest()
            ->first();

        if ($lastOrder) {
            // Get course details for the last purchase
            $course = $lastOrder->course;

            // Calculate progress for the last purchase
            $totalContents = $course->contents->count();
            $completedContents = $course->contents->filter(function ($content) {
                return CourseProgress::where('user_id', Auth::id())
                    ->where('course_content_id', $content->id)
                    ->where('completed', true)
                    ->exists();
            })->count();

            $progress = $totalContents > 0 ? ($completedContents / $totalContents) * 100 : 0;

            return view('client.dashboard', compact('course', 'progress'));
        }

        return view('client.dashboard');
    }
}
