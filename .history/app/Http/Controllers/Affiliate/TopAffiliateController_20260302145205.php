<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

    protected $symbols = [
        'NGN' => '₦',
        'USD' => '$',
        'GHS' => 'GH¢',
        'XAF' => 'FCFA',
        'KES' => 'KES',
    ];

    public function index()
    {
        $user = Auth::user();
        $userCurrency = $user->currency;
        $toNGN = $this->toNGN;
        $symbols = $this->symbols;

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

            $totalNgn = $stat->total_ngn;
            $totalUserCurrency = $totalNgn / $toNGN[$userCurrency];

            $level = $this->getLevel($totalNgn);
            $awardNgn = $this->getAwardNgn($position, $totalNgn);
            $awardUserCurrency = $awardNgn / $toNGN[$userCurrency];

            $leaderboard[] = [
                'position' => $position,
                'name' => $affiliate->name,
                'level' => $level,
                'sales' => $stat->sales_count,
                'total' => $totalUserCurrency,
                'total_formatted' => $symbols[$userCurrency] . number_format($totalUserCurrency, 2),
                'award_formatted' => $symbols[$userCurrency] . number_format($awardUserCurrency, 2),
            ];
            $position++;
        }

        return view('affiliate.top_affiliate', compact('leaderboard', 'userCurrency', 'symbols'));
    }

    private function getLevel($totalNgn)
    {
        $usdToNgn = $this->toNGN['USD'];
        if ($totalNgn >= 10000 * $usdToNgn) return 'Platinum';
        if ($totalNgn >= 5000 * $usdToNgn) return 'Gold';
        if ($totalNgn >= 1000 * $usdToNgn) return 'Silver';
        return 'Bronze';
    }

    private function getAwardNgn($position, $totalNgn)
    {
        $usdToNgn = $this->toNGN['USD'];
        if ($position == 1) return 500 * $usdToNgn;
        if ($position == 2) return 300 * $usdToNgn;
        if ($position == 3) return 200 * $usdToNgn;
        if ($totalNgn >= 5000 * $usdToNgn) return 100 * $usdToNgn;
        if ($totalNgn >= 1000 * $usdToNgn) return 50 * $usdToNgn;
        return 10 * $usdToNgn;
    }
}