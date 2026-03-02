<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BusinessFaculty;
use App\Models\BusinessCourse;
use App\Models\BusinessLecture;

class BusinessUniversitySeeder extends Seeder
{
    public function run()
    {
        // Faculties
        $faculties = [
            ['name' => 'Business Management', 'icon' => 'fas fa-chart-line'],
            ['name' => 'Marketing', 'icon' => 'fas fa-bullhorn'],
            ['name' => 'Finance', 'icon' => 'fas fa-coins'],
            ['name' => 'Entrepreneurship', 'icon' => 'fas fa-rocket'],
        ];

        foreach ($faculties as $f) {
            $fac = BusinessFaculty::create([
                'name' => $f['name'],
                'description' => 'Learn the essentials of ' . $f['name'],
                'icon' => $f['icon'],
                'order' => 1,
            ]);

            // Create 2 courses per faculty
            for ($i = 1; $i <= 2; $i++) {
                $course = BusinessCourse::create([
                    'faculty_id' => $fac->id,
                    'title' => $fac->name . ' Course ' . $i,
                    'slug' => str()->slug($fac->name . ' Course ' . $i),
                    'description' => 'This is a comprehensive course on ' . $fac->name . ' covering all key topics.',
                    'detailed_explanation' => 'In this course you will learn... (detailed content)',
                    'instructors' => 'Moreira Oyebambo, jamein Freemean',
                    'rating' => 4.5,
                    'reviews_count' => 150,
                    'price' => 50000,
                    'currency' => 'NGN',
                    'is_diploma' => true,
                    'duration_months' => 6,
                ]);

                // Create 3 lectures per course
                for ($j = 1; $j <= 3; $j++) {
                    BusinessLecture::create([
                        'course_id' => $course->id,
                        'title' => "Lecture {$j}: Introduction to " . $course->title,
                        'description' => "This lecture covers the fundamentals of " . $course->title,
                        'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                        'order' => $j,
                        'is_preview' => $j == 1,
                    ]);
                }
            }
        }
    }
}