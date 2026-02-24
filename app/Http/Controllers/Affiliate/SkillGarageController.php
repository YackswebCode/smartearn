<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SkillGarageController extends Controller
{
    /**
     * Display the skill garage page.
     */
    public function index()
    {
        // Dummy data for skills – replace with database query
        $skills = [
            [
                'title'       => 'HTML, JAVA SCRIPT: Learn HTML, Java script and more',
                'instructors' => 'Moreira Oyebambo, jamein Freemean',
                'rating'      => 4.5,
                'reviews'     => 41394,
                'price'       => 30000,
                'currency'    => 'N'
            ],
            [
                'title'       => 'HTML, JAVA SCRIPT: Learn HTML, Java script and more',
                'instructors' => 'Moreira Oyebambo, jamein Freemean',
                'rating'      => 4.5,
                'reviews'     => 41394,
                'price'       => 45000,
                'currency'    => 'N'
            ],
            [
                'title'       => 'Data Analysis: Learn Data Science and more',
                'instructors' => 'Moreira Oyebambo, jamein Freemean',
                'rating'      => 4.5,
                'reviews'     => 41394,
                'price'       => 80000,
                'currency'    => 'N'
            ],
            [
                'title'       => 'Learn Digital soft skills: Digital soft skills and more',
                'instructors' => 'Moreira Oyebambo, jamein Freemean',
                'rating'      => 4.5,
                'reviews'     => 41394,
                'price'       => 30000,
                'currency'    => 'N'
            ],
            [
                'title'       => 'Learn Digital soft skills: Digital soft skills and more',
                'instructors' => 'Moreira Oyebambo, jamein Freemean',
                'rating'      => 4.5,
                'reviews'     => 41394,
                'price'       => 80000,
                'currency'    => 'N'
            ],
            // Add more as needed
        ];

        return view('affiliate.skill_garage', compact('skills'));
    }
}