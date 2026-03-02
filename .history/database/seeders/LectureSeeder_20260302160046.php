<?php
// database/seeders/LectureSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Track;
use App\Models\Lecture;

class LectureSeeder extends Seeder
{
    public function run()
    {
        $tracks = Track::all();

        foreach ($tracks as $track) {
            // Add sample lectures for each track
            for ($i = 1; $i <= 3; $i++) {
                Lecture::create([
                    'track_id' => $track->id,
                    'title' => "Lecture {$i}: Introduction to " . $track->name,
                    'description' => "This is a sample description for lecture {$i}. It covers the basics and more.",
                    'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', // placeholder
                    'order' => $i,
                    'is_preview' => $i == 1, // first lecture is preview
                ]);
            }
        }
    }
}