<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TopAffiliateController extends Controller
{
    /**
     * Display the top affiliate leaderboard.
     */
    public function index()
    {
        // Dummy data – replace with your actual database query
        $leaderboard = collect([
            ['position' => 1, 'name' => 'CHIAMAKA JOY AGBIM', 'level' => 'Commando', 'sales' => 568, 'total_amount' => '***', 'award' => '-'],
            ['position' => 2, 'name' => 'CHIAMAKA JOY AGBIM', 'level' => 'Commando', 'sales' => 568, 'total_amount' => '***', 'award' => '-'],
            ['position' => 3, 'name' => 'OYEBAMBO MOREIRA', 'level' => 'Commando', 'sales' => 568, 'total_amount' => '***', 'award' => '-'],
            ['position' => 4, 'name' => 'OYEBAMBO MOREIRA', 'level' => 'Commando', 'sales' => 568, 'total_amount' => '***', 'award' => '-'],
            ['position' => 5, 'name' => 'OYEBAMBO MOREIRA', 'level' => 'Commando', 'sales' => 568, 'total_amount' => '***', 'award' => '-'],
            ['position' => 6, 'name' => 'OYEBAMBO MOREIRA', 'level' => 'Commando', 'sales' => 568, 'total_amount' => '***', 'award' => '-'],
            ['position' => 7, 'name' => 'OYEBAMBO MOREIRA', 'level' => 'Commando', 'sales' => 568, 'total_amount' => '***', 'award' => '-'],
            ['position' => 8, 'name' => 'OYEBAMBO MOREIRA', 'level' => 'Commando', 'sales' => 568, 'total_amount' => '***', 'award' => '-'],
            ['position' => 9, 'name' => 'OYEBAMBO MOREIRA', 'level' => 'Commando', 'sales' => 568, 'total_amount' => '***', 'award' => '-'],
            ['position' => 10, 'name' => 'OYEBAMBO MOREIRA', 'level' => 'Commando', 'sales' => 568, 'total_amount' => '***', 'award' => '-'],
            ['position' => 11, 'name' => 'OYEBAMBO MOREIRA', 'level' => 'Commando', 'sales' => 568, 'total_amount' => '***', 'award' => '-'],
            ['position' => 12, 'name' => 'OYEBAMBO MOREIRA', 'level' => 'Commando', 'sales' => 568, 'total_amount' => '***', 'award' => '-'],
            ['position' => 13, 'name' => 'OYEBAMBO MOREIRA', 'level' => 'Commando', 'sales' => 568, 'total_amount' => '***', 'award' => '-'],
            ['position' => 14, 'name' => 'OYEBAMBO MOREIRA', 'level' => 'Commando', 'sales' => 568, 'total_amount' => '***', 'award' => '-'],
            ['position' => 15, 'name' => 'OYEBAMBO MOREIRA', 'level' => 'Commando', 'sales' => 568, 'total_amount' => '***', 'award' => '-'],
            ['position' => 16, 'name' => 'OYEBAMBO MOREIRA', 'level' => 'Commando', 'sales' => 568, 'total_amount' => '***', 'award' => '-'],
            ['position' => 17, 'name' => 'OYEBAMBO MOREIRA', 'level' => 'Commando', 'sales' => 568, 'total_amount' => '***', 'award' => '-'],
            ['position' => 18, 'name' => 'OYEBAMBO MOREIRA', 'level' => 'Commando', 'sales' => 568, 'total_amount' => '***', 'award' => '-'],
            ['position' => 19, 'name' => 'OYEBAMBO MOREIRA', 'level' => 'Commando', 'sales' => 568, 'total_amount' => '***', 'award' => '-'],
            ['position' => 20, 'name' => 'OYEBAMBO MOREIRA', 'level' => 'Commando', 'sales' => 568, 'total_amount' => '***', 'award' => '-'],
        ]);

        return view('affiliate.top_affiliate', compact('leaderboard'));
    }
}