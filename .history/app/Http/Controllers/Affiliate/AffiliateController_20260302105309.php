<?php
// app/Http/Controllers/Affiliate/AffiliateController.php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AffiliateController extends Controller
{
    public function dashboard()
    {
        // In a real app, you would fetch data specific to the logged-in user
        $user = Auth::user();

        // Dummy data for demonstration
        $salesCount = 42;
        $totalVolumeNGN = 1250000.50;
        $totalVolumeUSD = 850.75;
        $totalVolumeGHS = 3200.00;
        $totalVolumeXAF = 150000.00;
        $totalVolumeKES = 45000.00;
        $totalWithdrawn = 350000.00;
        $overallEarning = 750000.00;
        $todayEarning = 12500.00;
        $todaySalesCount = 3;

        // Recent transactions (dummy)
        $recentTransactions = collect([
            (object)[
                'product_name' => 'Product A',
                'customer_name' => 'John Doe',
                'customer_email' => 'john@example.com',
                'reference' => 'TRX-001',
                'transaction_date' => now()->subDays(1),
                'total' => 15000.00,
                'affiliate_name' => $user->name,
                'affiliate_email' => $user->email,
                'commission_percent' => 10,
                'commission_amount' => 1500.00,
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
            // Add more as needed
        ]);

        return view('affiliate.dashboard', compact(
            'salesCount',
            'totalVolumeNGN',
            'totalVolumeUSD',
            'totalVolumeGHS',
            'totalVolumeXAF',
            'totalVolumeKES',
            'totalWithdrawn',
            'overallEarning',
            'todayEarning',
            'todaySalesCount',
            'recentTransactions'
        ));
    }

    // Other methods (orders, marketplace, etc.) would go here
}