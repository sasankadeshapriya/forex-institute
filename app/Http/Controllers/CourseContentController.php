<?php

namespace App\Http\Controllers;

use App\Models\CourseContent;
use Illuminate\Http\Request;
use App\Models\Course;

class CourseContentController extends Controller
{

    public function create($course_id)
    {
        $course = Course::findOrFail($course_id);
        $nextOrder = CourseContent::where('course_id', $course->id)->max('order') + 1;
        $contents = CourseContent::where('course_id', $course->id)->orderBy('order')->get();

        return view('admin.course-content.show', compact('course', 'nextOrder', 'contents'));
    }

    public function store(Request $request, $course_id)
    {
        $request->validate([
            'heading' => 'required|string|max:255',
            'content_type' => 'required|string',
            'content' => 'nullable|string',
            'content_file' => 'nullable|file|mimes:pdf,zip',
            'video_link' => 'nullable|url',
        ]);

        $course = Course::findOrFail($course_id);

        if ($request->hasFile('content_file')) {
            // Store the file securely in the 'private' folder (storage/app/private)
            $filePath = $request->file('content_file')->store('contents', 'private');
        } else {
            $filePath = null;
        }

        // Create course content
        $courseContent = new CourseContent();
        $courseContent->course_id = $course->id;
        $courseContent->heading = $request->heading;
        $courseContent->content_type = $request->content_type;

        // Handle different types of content
        if ($request->content_type == 'text') {
            $courseContent->content = $request->content;
        } elseif ($request->content_type == 'video') {
            $courseContent->content = $request->video_link;
        } elseif ($request->content_type == 'pdf' || $request->content_type == 'file') {
            $courseContent->content = $filePath;
        }

        // Set the order for the content (auto-increment order)
        $courseContent->order = CourseContent::where('course_id', $course->id)->max('order') + 1;

        $courseContent->save();

        return redirect()->route('admin.course-content.create', $course->id)->with('success', 'Content added successfully!');
    }

    public function destroy($id)
    {
        $courseContent = CourseContent::findOrFail($id);
        $course = $courseContent->course;

        if ($courseContent->content_type == 'file' || $courseContent->content_type == 'pdf') {

            $filePath = storage_path('app/private/' . $courseContent->content);

            if (file_exists($filePath)) {
                unlink($filePath);  // Delete the file
            }
        }

        $courseContent->delete();

        return redirect()->route('admin.course-content.create', $course->id)->with('success', 'Content and associated file deleted successfully!');
    }


    public function deleteAll($course_id)
    {

        $course = Course::findOrFail($course_id);

        $courseContents = CourseContent::where('course_id', $course_id)->get();

        foreach ($courseContents as $content) {

            if ($content->content_type == 'file' || $content->content_type == 'pdf') {

                $filePath = storage_path('app/private/' . $content->content);

                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $content->delete();
        }

        return redirect()->route('admin.course-content.create', $course_id)->with('success', 'All course content and associated files have been deleted successfully!');

    }


    // Move content up
    public function moveUp($id)
    {
        $courseContent = CourseContent::findOrFail($id);
        $course = $courseContent->course;

        $previousContent = CourseContent::where('course_id', $course->id)
            ->where('order', $courseContent->order - 1)
            ->first();

        if ($previousContent) {
            $currentOrder = $courseContent->order;
            $courseContent->order = $previousContent->order;
            $previousContent->order = $currentOrder;

            $courseContent->save();
            $previousContent->save();
        }

        return redirect()->route('admin.course-content.create', $course->id)->with('success', 'Content order updated!');
    }

    // Move content down
    public function moveDown($id)
    {
        $courseContent = CourseContent::findOrFail($id);
        $course = $courseContent->course;

        $nextContent = CourseContent::where('course_id', $course->id)
            ->where('order', $courseContent->order + 1)
            ->first();

        if ($nextContent) {
            $currentOrder = $courseContent->order;
            $courseContent->order = $nextContent->order;
            $nextContent->order = $currentOrder;

            $courseContent->save();
            $nextContent->save();
        }

        return redirect()->route('admin.course-content.create', $course->id)->with('success', 'Content order updated!');
    }
}
