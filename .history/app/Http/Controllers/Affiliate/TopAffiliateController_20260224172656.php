<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TopAffiliateController extends Controller
{
    /**
     * Display the top affiliate leaderboard.
     */
    public function index()
    {
        // Generate 20 entries (you can replace with DB query)
        $names = [
            'CHIAMAKA JOY AGBIM',
            'OYEBAMBO MOREIRA',
            'JOHN DOE',
            'JANE SMITH',
            'MICHAEL JOHNSON',
            'SARAH WILLIAMS',
            'DAVID BROWN',
            'EMMA JONES',
            'JAMES GARCIA',
            'LINDA MARTINEZ',
            'ROBERT ROBINSON',
            'PATRICIA CLARK',
            'CHARLES RODRIGUEZ',
            'BARBARA LEWIS',
            'THOMAS LEE',
            'JENNIFER WALKER',
            'CHRISTOPHER HALL',
            'NANCY ALLEN',
            'DANIEL YOUNG',
            'LISA KING'
        ];

        $leaderboard = collect();
        for ($i = 1; $i <= 20; $i++) {
            $leaderboard->push([
                'position' => $i,
                'name' => $names[($i - 1) % count($names)], // cycle through names
                'level' => $i <= 5 ? 'Commando' : ($i <= 10 ? 'Elite' : 'Rookie'),
                'sales' => rand(100, 1000),
                'total_amount' => '***', // or generate random amount if needed
                'award' => $i == 1 ? 'Gold' : ($i == 2 ? 'Silver' : ($i == 3 ? 'Bronze' : '-'))
            ]);
        }

        return view('affiliate.top_affiliate', compact('leaderboard'));
    }
}