<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseContent;
use Illuminate\Http\Request;

class CourseListController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return view('shop.index', compact('courses'));
    }

    public function show(Course $course)
    {
        $contents = CourseContent::where('course_id', $course->id)->get();

        foreach ($contents as $index => $content) {
            if ($content->content_type == 'video') {
                $content->content = $this->extractDriveFileId($content->content);
            }

            $content->show_content = ($index === 0);
        }

        return view('shop.show', compact('course', 'contents'));
    }

    private function extractDriveFileId($url)
    {
        preg_match('/\/d\/([a-zA-Z0-9_-]+)/', $url, $matches);
        return $matches[1] ?? null;
    }

}
