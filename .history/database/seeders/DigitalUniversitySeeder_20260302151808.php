<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faculty;
use App\Models\Track;

class DigitalUniversitySeeder extends Seeder
{
    public function run()
    {
        // Faculty of Engineering
        $eng = Faculty::create([
            'name' => 'Faculty of Engineering',
            'description' => 'Build the future with code and infrastructure.',
            'icon' => 'fas fa-laptop-code',
            'order' => 1,
        ]);

        $tracks = [
            ['name' => 'Backend Software Engineering', 'price_yearly' => 300000],
            ['name' => 'Frontend Software Engineering', 'price_yearly' => 280000],
            ['name' => 'Fullstack Software Engineering', 'price_yearly' => 450000],
            ['name' => 'Cybersecurity', 'price_yearly' => 350000],
            ['name' => 'Cloud Engineering', 'price_yearly' => 320000],
            ['name' => 'AI / Machine Learning', 'price_yearly' => 400000],
        ];

        foreach ($tracks as $t) {
            Track::create([
                'faculty_id' => $eng->id,
                'name' => $t['name'],
                'description' => 'Comprehensive program...',
                'detailed_explanation' => 'Full details...',
                'price_monthly' => $t['price_yearly'] / 12,
                'price_quarterly' => $t['price_yearly'] / 4 * 1.1, // example
                'price_yearly' => $t['price_yearly'],
                'currency' => 'NGN',
                'duration_months' => 12,
                'is_diploma' => true,
            ]);
        }

        // Faculty of Data
        $data = Faculty::create([
            'name' => 'Faculty of Data',
            'description' => 'Turn data into decisions.',
            'icon' => 'fas fa-chart-bar',
            'order' => 2,
        ]);

        $tracks = [
            ['name' => 'Data Analysis', 'price_yearly' => 250000],
            ['name' => 'Business Intelligence', 'price_yearly' => 270000],
            ['name' => 'Data Science', 'price_yearly' => 380000],
        ];
        // ... similar

        // Faculty of Product and Design
        $design = Faculty::create([...]);

        // Faculty of Business and Marketing
        $business = Faculty::create([...]);
    }
}