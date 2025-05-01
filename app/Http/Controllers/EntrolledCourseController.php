<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Course;
use App\Models\CourseProgress;
use App\Models\CourseContent;

class EntrolledCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // 1) Pull all completed orders, newest first
        $completedOrders = $user->orders()
            ->where('status', 'completed')
            ->whereNull('deleted_at')
            ->orderByDesc('created_at')
            ->get();

        // 2) Extract each course and compute its progress
        $coursesWithProgress = $completedOrders->map(function ($order) use ($user) {
            $course = $order->course;
            $totalContents = $course->contents->count();
            $completedContents = $course->contents->filter(function ($content) use ($user) {
                return $user->courseProgress()
                    ->where('course_content_id', $content->id)
                    ->where('completed', true)
                    ->exists();
            })->count();

            $course->progress = $totalContents > 0
                ? ($completedContents / $totalContents) * 100
                : 0;

            return $course;
        });

        // 3) Find the very last piece of content they marked complete
        $lastProg = $user->courseProgress()
            ->where('completed', true)
            ->latest('updated_at')
            ->first();

        // 4) Decide which course to continue:
        //    - if they've ever completed a piece, continue that course
        //    - else, fall back to most-recently purchased
        $continueCourseId = $lastProg
            ? $lastProg->course_id
            : ($completedOrders->first()->course_id ?? null);

        return view(
            'client.entrolled-courses.index',
            compact('coursesWithProgress', 'continueCourseId')
        );
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = Auth::user();
        $course = Course::findOrFail($id);

        // Check if the course has any contents
        if ($course->contents->isEmpty()) {

            return view('client.entrolled-courses.under-maintenance')->with('message', 'This course is currently under maintenance as no content is available.');
        }

        // Get the user's progress for this course
        $courseProgress = $user->courseProgress()->where('course_id', $course->id)->get();

        // Get total contents and completed contents
        $totalContents = $course->contents->count();
        $completedContents = $courseProgress->count();
        $progress = $totalContents > 0 ? ($completedContents / $totalContents) * 100 : 0;

        // Fetch all course contents, ordered by ID
        $contents = $course->contents->sortBy('id');
        $completedContentIds = $courseProgress->pluck('course_content_id')->toArray();

        // Get the last completed content (if any)
        $lastCompletedContent = $courseProgress->last();
        $lastCompletedContentId = $lastCompletedContent ? $lastCompletedContent->course_content_id : null;

        // Find the next content (next in sequence after the last completed content)
        $nextContent = null;
        if ($lastCompletedContentId) {
            $nextContent = $course->contents->where('id', '>', $lastCompletedContentId)->first();
        } else {
            $nextContent = $course->contents->first(); // If no content is completed, show the first one
        }

        return view('client.entrolled-courses.show', compact('course', 'progress', 'contents', 'completedContentIds', 'nextContent', 'lastCompletedContentId'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = Auth::user();

        // Find the order for the course
        $order = Order::where('user_id', $user->id)
            ->where('course_id', $id)
            ->whereNull('deleted_at')
            ->first();

        if ($order) {
            // Soft delete the order (removing it from the cart)
            $order->delete();

            return redirect()->route('entrolled-courses.index')->with('success', 'Course removed from your enrolled courses.');
        }

        return redirect()->route('entrolled-courses.index')->with('error', 'Course not found in your enrolled courses.');
    }

    public function markComplete($courseId, $contentId)
    {
        $user = Auth::user();
        $course = Course::findOrFail($courseId);

        $progress = $user->courseProgress()->firstOrNew([
            'course_id' => $course->id,
            'course_content_id' => $contentId,
        ]);
        $progress->completed = true;
        $progress->save();

        return redirect()->route('entrolled-courses.show', $course->id);
    }

}
