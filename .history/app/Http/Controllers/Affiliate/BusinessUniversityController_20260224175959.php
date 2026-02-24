<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BusinessUniversityController extends Controller
{
    /**
     * Display the business university page.
     */
    public function index()
    {
        // Dummy faculties (for filter chips)
        $faculties = [
            'Financial Market and Trading',
            'Digital Entrepreneurship and E-commerce',
            'Wealth Creation and Investment',
            'Wealth Creation and Investment', // duplicate as per example
        ];

        // Dummy courses
        $courses = [
            [
                'title'       => 'Amazon KDP Complete Guide: Learn Amazon kdp and More',
                'instructors' => 'Moreira Oyebambo, jamein Freemean',
                'rating'      => 4.5,
                'reviews'     => 41394,
                'price'       => 30000,
                'currency'    => 'N'
            ],
            [
                'title'       => 'Mini Importation Complete Guide: Learn Importation market and More',
                'instructors' => 'Moreira Oyebambo, jamein Freemean',
                'rating'      => 4.5,
                'reviews'     => 41394,
                'price'       => 45000,
                'currency'    => 'N'
            ],
            [
                'title'       => 'E-commerce Complete Guide: Learn E-commerce Like a pro',
                'instructors' => 'Moreira Oyebambo, jamein Freemean',
                'rating'      => 4.5,
                'reviews'     => 41394,
                'price'       => 80000,
                'currency'    => 'N'
            ],
            [
                'title'       => 'Introduction to E-commerce: Learn the E-commerce and More',
                'instructors' => 'Moreira Oyebambo, jamein Freemean',
                'rating'      => 4.5,
                'reviews'     => 41394,
                'price'       => 80000,
                'currency'    => 'N'
            ],
            [
                'title'       => 'Information Marketing: Learn Info marketing and more',
                'instructors' => 'Moreira Oyebambo, jamein Freemean',
                'rating'      => 4.5,
                'reviews'     => 41394,
                'price'       => 30000,
                'currency'    => 'N'
            ],
            [
                'title'       => 'Digital Entrepreneurship Complete Guide',
                'instructors' => 'Moreira Oyebambo, jamein Freemean',
                'rating'      => 4.5,
                'reviews'     => 41394,
                'price'       => 45000,
                'currency'    => 'N'
            ],
        ];

        return view('affiliate.business_university', compact('faculties', 'courses'));
    }
}