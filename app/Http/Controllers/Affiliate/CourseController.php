<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display the specified course.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        // Dummy data based on the provided description
        $course = (object) [
            'title'               => 'Crypto Trading Complete Guide: Learn the Crypto Market & More',
            'description'          => 'Lorem ipsum dolor sit amet consectetur. Semper sed nunc ac facilisis molestie tellus in eros morbi.',
            'rating'               => 4.5,
            'reviews_count'        => 41394,
            'students_count'       => 272045,
            'instructors'          => 'Moreira Bambillion, willson woodbrow, Kelvin Right',
            'last_updated'         => '12/2024',
            'language'             => 'English',
            'price'                => 250000,
            'discounted_price'     => 110000,
            'discount_percent'     => 75,
            'time_left'            => '20hours left at this price',
            'includes'             => [
                '28 hours on-demand video',
                '21 articles',
                '76 downloadable resources',
                'Access on mobile and TV',
                'Full lifetime access',
                'Audio description in existing audio',
                'Certificate of completion',
            ],
            'sections'             => [
                [
                    'title'    => 'Crypto Trading Complete Guide',
                    'lectures' => 3,
                    'length'   => '6min',
                    'items'    => [
                        ['title' => 'Lorem ipsum dolor sit amet consectetur.', 'preview' => true, 'duration' => '3:46'],
                        ['title' => 'Lorem ipsum dolor sit amet consectetur.', 'preview' => true, 'duration' => '3:46'],
                        ['title' => 'Lorem ipsum dolor sit amet consectetur.', 'preview' => true, 'duration' => '3:46'],
                    ],
                ],
                [
                    'title'    => 'Crypto Trading Complete Guide',
                    'lectures' => 3,
                    'length'   => '6min',
                    'items'    => [
                        ['title' => 'Lorem ipsum dolor sit amet consectetur.', 'preview' => true, 'duration' => '3:46'],
                        ['title' => 'Lorem ipsum dolor sit amet consectetur.', 'preview' => true, 'duration' => '3:46'],
                        ['title' => 'Lorem ipsum dolor sit amet consectetur.', 'preview' => true, 'duration' => '3:46'],
                    ],
                ],
                [
                    'title'    => 'Crypto Trading Complete Guide',
                    'lectures' => 3,
                    'length'   => '6min',
                    'items'    => [
                        ['title' => 'Lorem ipsum dolor sit amet consectetur.', 'preview' => true, 'duration' => '3:46'],
                        ['title' => 'Lorem ipsum dolor sit amet consectetur.', 'preview' => true, 'duration' => '3:46'],
                        ['title' => 'Lorem ipsum dolor sit amet consectetur.', 'preview' => true, 'duration' => '3:46'],
                    ],
                ],
                [
                    'title'    => 'Crypto Trading Complete Guide',
                    'lectures' => 3,
                    'length'   => '6min',
                    'items'    => [
                        ['title' => 'Lorem ipsum dolor sit amet consectetur.', 'preview' => true, 'duration' => '3:46'],
                        ['title' => 'Lorem ipsum dolor sit amet consectetur.', 'preview' => true, 'duration' => '3:46'],
                        ['title' => 'Lorem ipsum dolor sit amet consectetur.', 'preview' => true, 'duration' => '3:46'],
                    ],
                ],
            ],
        ];

        return view('affiliate.course_show', compact('course'));
    }
}