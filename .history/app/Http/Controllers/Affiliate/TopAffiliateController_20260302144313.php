<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TopAffiliateController extends Controller
{
    protected $toNGN = [
        'NGN' => 1,
        'USD' => 1363.33,
        'GHS' => 127.81,
        'XAF' => 2.45,
        'KES' => 10.56,
    ];

    public function index()
    {
        $currentMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        // Get all affiliates with completed orders this month
        $affiliateStats = Order::where('status', 'completed')
            ->whereBetween('created_at', [$currentMonth, $endOfMonth])
            ->select(
                'affiliate_id',
                DB::raw('COUNT(*) as sales_count'),
                DB::raw('SUM(amount) as total_ngn')
            )
            ->groupBy('affiliate_id')
            ->orderByDesc('total_ngn')
            ->get();

        // Prepare leaderboard array
        $leaderboard = [];
        $position = 1;
        foreach ($affiliateStats as $stat) {
            $affiliate = User::find($stat->affiliate_id);
            if (!$affiliate) continue;

            // Convert total to USD for display
            $totalUsd = $stat->total_ngn / $this->toNGN['USD'];

            // Determine level based on total USD
            $level = $this->getLevel($totalUsd);

            // Determine award based on position or total
            $award = $this->getAward($position, $totalUsd);

            $leaderboard[] = [
                'position' => $position,
                'name' => $affiliate->name,
                'level' => $level,
                'sales' => $stat->sales_count,
                'total_amount' => number_format($totalUsd, 2),
                'award' => $award,
            ];
            $position++;
        }

        return view('affiliate.top_affiliate', compact('leaderboard'));
    }

    private function getLevel($totalUsd)
    {
        if ($totalUsd >= 10000) return 'Platinum';
        if ($totalUsd >= 5000) return 'Gold';
        if ($totalUsd >= 1000) return 'Silver';
        return 'Bronze';
    }

    private function getAward($position, $totalUsd)
    {
        if ($position == 1) return '$500';
        if ($position == 2) return '$300';
        if ($position == 3) return '$200';
        if ($totalUsd >= 5000) return '$100';
        if ($totalUsd >= 1000) return '$50';
        return '$10';
    }
}