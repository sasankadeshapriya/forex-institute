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

        $completedOrders = $user->orders()->where('status', 'completed')->get();

        $courses = $completedOrders->map(function ($order) {
            return $order->course;
        });

        $coursesWithProgress = $courses->map(function ($course) use ($user) {

            $totalContents = $course->contents->count();

            $completedContents = $course->contents->filter(function ($content) use ($user) {
                return $user->courseProgress()->where('course_content_id', $content->id)->where('completed', true)->exists();
            })->count();

            $progress = $totalContents > 0 ? ($completedContents / $totalContents) * 100 : 0;

            $course->progress = $progress;

            return $course;
        });

        return view('client.entrolled-courses.index', compact('coursesWithProgress'));
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

        // dd($course, $progress, $contents, $completedContentIds, $nextContent, $lastCompletedContentId);
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
    public function destroy(string $id)
    {
        //
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
