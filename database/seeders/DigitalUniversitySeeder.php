<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class DigitalUniversitySeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // ========================
        // 1. FACULTIES
        // ========================
        $faculties = [
            ['name' => 'Faculty of Engineering',    'icon' => 'fa-laptop-code',   'order' => 1],
            ['name' => 'Faculty of Data',            'icon' => 'fa-chart-bar',     'order' => 2],
            ['name' => 'Faculty of Product & Design','icon' => 'fa-paint-brush',   'order' => 3],
            ['name' => 'Faculty of Business & Marketing','icon' => 'fa-bullhorn', 'order' => 4],
        ];

        foreach ($faculties as $faculty) {
            DB::table('digital_faculties')->insert(array_merge($faculty, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // Retrieve faculty IDs
        $engId  = DB::table('digital_faculties')->where('name', 'Faculty of Engineering')->value('id');
        $dataId = DB::table('digital_faculties')->where('name', 'Faculty of Data')->value('id');
        $prodId = DB::table('digital_faculties')->where('name', 'Faculty of Product & Design')->value('id');
        $bizId  = DB::table('digital_faculties')->where('name', 'Faculty of Business & Marketing')->value('id');

        // ========================
        // 2. TRACKS
        // ========================
        $tracks = [
            // Engineering
            ['faculty_id' => $engId, 'title' => 'Backend Software Engineering'],
            ['faculty_id' => $engId, 'title' => 'Frontend Software Engineering'],
            ['faculty_id' => $engId, 'title' => 'Fullstack Software Engineering'],
            ['faculty_id' => $engId, 'title' => 'Cybersecurity'],
            ['faculty_id' => $engId, 'title' => 'Cloud Engineering'],
            ['faculty_id' => $engId, 'title' => 'AI/Machine Learning'],

            // Data
            ['faculty_id' => $dataId, 'title' => 'Data Analysis'],
            ['faculty_id' => $dataId, 'title' => 'Business Intelligence'],
            ['faculty_id' => $dataId, 'title' => 'Data Science'],

            // Product & Design
            ['faculty_id' => $prodId, 'title' => 'Product Design (UI/UX)'],
            ['faculty_id' => $prodId, 'title' => 'Product Management'],
            ['faculty_id' => $prodId, 'title' => 'Brand Identity Design'],
            ['faculty_id' => $prodId, 'title' => 'Motion Design'],

            // Business & Marketing
            ['faculty_id' => $bizId, 'title' => 'Digital Marketing'],
            ['faculty_id' => $bizId, 'title' => 'Performance Marketing (Media Buying)'],
            ['faculty_id' => $bizId, 'title' => 'Social Media Management'],
            ['faculty_id' => $bizId, 'title' => 'SEO & Content Marketing'],
            ['faculty_id' => $bizId, 'title' => 'High Ticket Sales'],
            ['faculty_id' => $bizId, 'title' => 'Funnel Building'],
        ];

        foreach ($tracks as $track) {
            $isDiploma = in_array($track['title'], [
                'AI/Machine Learning',
                'Fullstack Software Engineering',
                'Data Science',
                'Cybersecurity',
            ]);

            DB::table('digital_tracks')->insert([
                'faculty_id'      => $track['faculty_id'],
                'title'           => $track['title'],
                'slug'            => Str::slug($track['title']),
                'description'     => $this->randomDescription($track['title'], $faker),
                'instructors'     => 'Dr. ' . $faker->name() . ', Prof. ' . $faker->lastName(),
                'rating'          => $faker->randomFloat(1, 3.5, 5.0),
                'reviews_count'   => rand(100, 1500),
                'duration_months' => $isDiploma ? rand(12, 18) : rand(1, 6),
                'price'           => rand(15000, 50000),
                'monthly_price'   => rand(15000, 50000),
                'quarterly_price' => rand(40000, 130000),
                'one_time_price'  => $isDiploma ? rand(300000, 700000) : rand(80000, 250000),
                'currency'        => 'NGN',
                'order'           => 0,
                'is_active'       => true,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }

        // ========================
        // 3. LECTURES
        // ========================
        $allTrackIds = DB::table('digital_tracks')->pluck('id');
        foreach ($allTrackIds as $trackId) {
            for ($i = 1; $i <= 5; $i++) {
                DB::table('digital_lectures')->insert([
                    'track_id'   => $trackId,
                    'title'      => "Module $i: " . $faker->sentence(3),
                    'content'    => $faker->paragraphs(3, true),
                    'video_url'  => 'https://example.com/video-' . $i,
                    'order'      => $i,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // ========================
        // 4. SAMPLE ENROLLMENTS
        // ========================
        $userId = DB::table('users')->value('id');
        if ($userId) {
            $trackIds = DB::table('digital_tracks')->pluck('id')->take(3);
            foreach ($trackIds as $tId) {
                DB::table('digital_enrollments')->insert([
                    'user_id'    => $userId,
                    'track_id'   => $tId,
                    'plan'       => ['monthly', 'quarterly', 'one_time'][rand(0, 2)],
                    'amount_paid'=> rand(15000, 300000),
                    'currency'   => 'NGN',
                    'status'     => 'active',
                    'start_date' => now()->subMonths(1),
                    'end_date'   => now()->addMonths(5),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    private function randomDescription($title, $faker)
    {
        return "Master {$title} with our comprehensive track. " .
               "Gain practical skills, build real‑world projects, and earn a recognised certification. " .
               "This program includes mentorship, community access, and job placement support.";
    }
}