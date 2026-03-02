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

            // Total is already in NGN
            $totalNgn = $stat->total_ngn;

            // Determine level based on total NGN
            $level = $this->getLevel($totalNgn);

            // Determine award in NGN based on position or total
            $awardNgn = $this->getAwardNgn($position, $totalNgn);

            $leaderboard[] = [
                'position' => $position,
                'name' => $affiliate->name,
                'level' => $level,
                'sales' => $stat->sales_count,
                'total_amount' => number_format($totalNgn, 2),
                'award' => '₦' . number_format($awardNgn, 2),
            ];
            $position++;
        }

        return view('affiliate.top_affiliate', compact('leaderboard'));
    }

    private function getLevel($totalNgn)
    {
        // Convert USD thresholds to NGN using toNGN['USD']
        $usdToNgn = $this->toNGN['USD'];
        if ($totalNgn >= 10000 * $usdToNgn) return 'Platinum';
        if ($totalNgn >= 5000 * $usdToNgn) return 'Gold';
        if ($totalNgn >= 1000 * $usdToNgn) return 'Silver';
        return 'Bronze';
    }

    private function getAwardNgn($position, $totalNgn)
    {
        $usdToNgn = $this->toNGN['USD'];
        if ($position == 1) return 500 * $usdToNgn;        // $500
        if ($position == 2) return 300 * $usdToNgn;        // $300
        if ($position == 3) return 200 * $usdToNgn;        // $200
        if ($totalNgn >= 5000 * $usdToNgn) return 100 * $usdToNgn; // $100
        if ($totalNgn >= 1000 * $usdToNgn) return 50 * $usdToNgn;   // $50
        return 10 * $usdToNgn;                                       // $10
    }
}