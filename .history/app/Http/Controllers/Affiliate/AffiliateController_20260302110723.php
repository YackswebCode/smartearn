<?php
// app/Http/Controllers/Affiliate/AffiliateController.php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AffiliateController extends Controller
{
    /**
     * Conversion rates to NGN (as base)
     */
    protected $toNGN = [
        'NGN' => 1,
        'USD' => 1363.33,
        'GHS' => 127.81,
        'XAF' => 2.45,
        'KES' => 10.56,
    ];

    /**
     * Currency symbols
     */
    protected $symbols = [
        'NGN' => '₦',
        'USD' => '$',
        'GHS' => 'GH¢',
        'XAF' => 'FCFA',
        'KES' => 'KES',
    ];

    public function dashboard()
    {
        $user = Auth::user();
        $userCurrency = $user->currency; // e.g., 'NGN', 'USD', etc.

        // Dummy sales volumes per currency (original values)
        $salesCount = 42;
        $totalVolumeNGN = 1250000.50;
        $totalVolumeUSD = 850.75;
        $totalVolumeGHS = 3200.00;
        $totalVolumeXAF = 150000.00;
        $totalVolumeKES = 45000.00;

        // Dummy earnings (in NGN)
        $totalWithdrawnNGN = 350000.00;
        $overallEarningNGN = 750000.00;
        $todayEarningNGN = 12500.00;
        $todaySalesCount = 3;

        // Convert total volume to user's currency
        $totalVolumeUserCurrency = 0;
        foreach (['NGN', 'USD', 'GHS', 'XAF', 'KES'] as $curr) {
            $amount = ${"totalVolume".$curr}; // variable variable
            $totalVolumeUserCurrency += $amount * ($this->toNGN[$curr] / $this->toNGN[$userCurrency]);
        }

        // Convert earnings (which are in NGN) to user's currency
        $totalWithdrawnUserCurrency = $totalWithdrawnNGN / $this->toNGN[$userCurrency];
        $overallEarningUserCurrency = $overallEarningNGN / $this->toNGN[$userCurrency];
        $todayEarningUserCurrency = $todayEarningNGN / $this->toNGN[$userCurrency];

        // Recent transactions (dummy)
        $recentTransactions = collect([
            (object)[
                'product_name' => 'Product A',
                'customer_name' => 'John Doe',
                'customer_email' => 'john@example.com',
                'reference' => 'TRX-001',
                'transaction_date' => now()->subDays(1),
                'total' => 15000.00, // in NGN
                'affiliate_name' => $user->name,
                'affiliate_email' => $user->email,
                'commission_percent' => 10,
                'commission_amount' => 1500.00, // in NGN
            ],
            (object)[
                'product_name' => 'Product B',
                'customer_name' => 'Jane Smith',
                'customer_email' => 'jane@example.com',
                'reference' => 'TRX-002',
                'transaction_date' => now()->subDays(2),
                'total' => 25000.00,
                'affiliate_name' => $user->name,
                'affiliate_email' => $user->email,
                'commission_percent' => 15,
                'commission_amount' => 3750.00,
            ],
        ]);

        return view('affiliate.dashboard', compact(
            'salesCount',
            'totalVolumeNGN',
            'totalVolumeUSD',
            'totalVolumeGHS',
            'totalVolumeXAF',
            'totalVolumeKES',
            'totalVolumeUserCurrency',
            'totalWithdrawnUserCurrency',
            'overallEarningUserCurrency',
            'todayEarningUserCurrency',
            'todaySalesCount',
            'recentTransactions',
            'userCurrency',
            'symbols'
        ));
    }

    // Other methods ...
}