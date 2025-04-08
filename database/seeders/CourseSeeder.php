<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Course::create([
            'name' => 'Forex Trading',
            'description' => 'Learn how to trade Forex markets.',
            'price' => 50,
            'image' => 'images/courses/other.jpg',
            'duration' => 1,
            'instructor_name' => 'John Smith'
        ]);

        Course::create([
            'name' => 'Advanced Forex Strategies',
            'description' => 'Master advanced Forex trading strategies.',
            'price' => 100,
            'image' => 'images/courses/other.jpg',
            'duration' => 3,
            'instructor_name' => 'Jane Doe'
        ]);

        Course::create([
            'name' => 'Forex Trading 02',
            'description' => 'Learn how to trade Forex markets.',
            'price' => 50,
            'image' => 'images/courses/other.jpg',
            'duration' => 1,
            'instructor_name' => 'John Smith'
        ]);

        Course::create([
            'name' => 'Advanced Forex Strategies 05',
            'description' => 'Master advanced Forex trading strategies.',
            'price' => 100,
            'image' => 'images/courses/other.jpg',
            'duration' => 3,
            'instructor_name' => 'Jane Doe'
        ]);

        Course::create([
            'name' => 'AB Trading',
            'description' => 'Learn how to trade Forex markets.',
            'price' => 50,
            'image' => 'images/courses/other.jpg',
            'duration' => 1,
            'instructor_name' => 'John Smith'
        ]);

        Course::create([
            'name' => 'CDB Strategies',
            'description' => 'Master advanced Forex trading strategies.',
            'price' => 100,
            'image' => 'images/courses/other.jpg',
            'duration' => 3,
            'instructor_name' => 'Jane Doe'
        ]);
    }
}
