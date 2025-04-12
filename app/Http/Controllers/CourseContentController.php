<?php

namespace App\Http\Controllers;

use App\Models\CourseContent;
use Illuminate\Http\Request;
use App\Models\Course;

class CourseContentController extends Controller
{

    // Show the form to create new course content
    public function create($course_id)
    {
        $course = Course::findOrFail($course_id);

        // Get the highest order number for this course and add 1 to get the next available order
        $nextOrder = CourseContent::where('course_id', $course->id)->max('order') + 1;

        // Fetch all contents for this course to show them on the page (optional)
        $contents = CourseContent::where('course_id', $course->id)->orderBy('order')->get();

        return view('admin.course-content.show', compact('course', 'nextOrder', 'contents'));
    }

    // Store new course content in the database
    public function store(Request $request, $course_id)
    {
        $request->validate([
            'heading' => 'required|string|max:255',
            'content_type' => 'required|string',
            'content' => 'required|string',
            'content_file' => 'nullable|file|mimes:pdf,zip',
            'video_link' => 'nullable|url',
        ]);

        $course = Course::findOrFail($course_id);

        // Handle file upload for PDF/File
        if ($request->hasFile('content_file')) {
            $filePath = $request->file('content_file')->store('content_files', 'public');
        } else {
            $filePath = null;
        }

        // Create course content
        $courseContent = new CourseContent();
        $courseContent->course_id = $course->id;
        $courseContent->heading = $request->heading;
        $courseContent->content_type = $request->content_type;
        $courseContent->content = $request->content ?? $filePath ?? $request->video_link;
        $courseContent->order = CourseContent::where('course_id', $course->id)->max('order') + 1; // Auto-increment the order
        $courseContent->save();

        return redirect()->route('admin.courses.show', $course->id)->with('success', 'Content added successfully!');
    }

    // Show the form to edit course content
    public function edit($id)
    {
        $courseContent = CourseContent::findOrFail($id);
        $course = $courseContent->course;
        return view('admin.course-content.edit', compact('course', 'courseContent'));
    }

    // Update course content in the database
    public function update(Request $request, $id)
    {
        $request->validate([
            'heading' => 'required|string|max:255',
            'content_type' => 'required|string',
            'content' => 'nullable|string',
            'content_file' => 'nullable|file|mimes:pdf,zip',
            'video_link' => 'nullable|url',
        ]);

        $courseContent = CourseContent::findOrFail($id);
        $course = $courseContent->course;

        // Handle file upload for PDF/File
        if ($request->hasFile('content_file')) {
            $filePath = $request->file('content_file')->store('content_files', 'public');
            $courseContent->content = $filePath;
        } elseif ($request->content_type == 'video') {
            $courseContent->content = $request->video_link;
        } else {
            $courseContent->content = $request->content;
        }

        $courseContent->heading = $request->heading;
        $courseContent->content_type = $request->content_type;
        $courseContent->save();

        return redirect()->route('admin.courses.show', $course->id)->with('success', 'Content updated successfully!');
    }

    // Delete the course content from the database
    public function destroy($id)
    {
        $courseContent = CourseContent::findOrFail($id);
        $course = $courseContent->course;
        $courseContent->delete();

        return redirect()->route('admin.courses.show', $course->id)->with('success', 'Content deleted successfully!');
    }

}
