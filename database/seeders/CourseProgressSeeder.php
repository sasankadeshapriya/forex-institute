<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CourseProgress;

class CourseProgressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CourseProgress::create([
            'user_id' => 2,
            'course_id' => 1,
            'course_content_id' => 1,
            'completed' => true,
        ]);

        CourseProgress::create([
            'user_id' => 2,
            'course_id' => 1,
            'course_content_id' => 2,
            'completed' => true,
        ]);

        CourseProgress::create([
            'user_id' => 2,
            'course_id' => 1,
            'course_content_id' => 3,
            'completed' => false,
        ]);
    }
}
