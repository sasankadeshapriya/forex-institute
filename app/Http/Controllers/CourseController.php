<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::paginate(5);
        return view('admin.courses.courses', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'instructor_name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpg,png|max:1024',
            'price' => 'required|numeric',
            'duration' => 'required|integer',
            'last_updated' => 'nullable|date',
        ]);

        if ($request->hasFile('image')) {
            $originalName = $request->file('image')->getClientOriginalName();
            $timestamp = now()->format('Y-m-d_H-i-s'); // Get timestamp to create a unique image name
            $imageName = $timestamp . '_' . $originalName;
            $imagePath = $request->file('image')->storeAs('images/courses', $imageName, 'public');
        }

        $course = new Course();
        $course->name = $request->input('name');
        $course->instructor_name = $request->input('instructor_name');
        $course->description = $request->input('description');
        $course->image = $imagePath;
        $course->price = $request->input('price');
        $course->duration = $request->input('duration');

        if ($request->filled('last_updated')) {
            $course->last_updated = \Carbon\Carbon::parse($request->input('last_updated'));
        }

        $course->save();

        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        return view('admin.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $course = Course::findOrFail($course->id);
        return view('admin.courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'instructor_name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,png|max:1024',
            'price' => 'required|numeric',
            'duration' => 'required|integer',
            'last_updated' => 'nullable|date',
        ]);

        $course->name = $request->input('name');
        $course->instructor_name = $request->input('instructor_name');
        $course->description = $request->input('description');
        $course->price = $request->input('price');
        $course->duration = $request->input('duration');

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($course->image && \Storage::disk('public')->exists($course->image)) {
                \Storage::disk('public')->delete($course->image);
            }

            // Store the new image
            $originalName = $request->file('image')->getClientOriginalName();
            $timestamp = now()->format('Y-m-d_H-i-s');
            $imageName = $timestamp . '_' . $originalName;
            $imagePath = $request->file('image')->storeAs('images/courses', $imageName, 'public');
            $course->image = $imagePath;
        }

        if ($request->filled('last_updated')) {
            $course->last_updated = \Carbon\Carbon::parse($request->input('last_updated'));
        }

        $course->save();

        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {

        if ($course->image && \Storage::disk('public')->exists($course->image)) {
            \Storage::disk('public')->delete($course->image);
        }

        $course->delete();

        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully!');
    }
}
