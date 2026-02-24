<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class AffiliateController extends Controller
{
    public function dashboard()
    {
        // Dummy user
        $dummyUser = (object) [
            'name' => 'Awonusi Temitope',
            'email' => 'awonusitemitope25@gmail.com',
            'affiliate_earnings_ngn' => 15000,
        ];

        // Dummy dashboard stats
        $salesCount = 400;
        $totalVolumeNGN = 7000;
        $totalVolumeUSD = 102;
        $totalVolumeGHS = 46;
        $totalVolumeXAF = 20;
        $totalVolumeKES = 120;
        $totalWithdrawn = 300;
        $overallEarning = 15000;
        $todayEarning = 1000;
        $todaySalesCount = 10;

        // Dummy transactions
        $recentTransactions = collect([
            (object) [
                'product_name' => 'Website Design to Millions',
                'customer_name' => 'Moreira Bambi',
                'customer_email' => 'bambitechdrive@gmail.com',
                'reference' => 'S1649NW13',
                'transaction_date' => now()->subDays(2),
                'total' => 786,
                'affiliate_name' => 'Awonusi Temitope',
                'affiliate_email' => 'awonusitemitope25@gmail.com',
                'commission_percent' => 30,
                'commission_amount' => 800,
            ],
            (object) [
                'product_name' => 'SEO Mastery Course',
                'customer_name' => 'John Doe',
                'customer_email' => 'john@example.com',
                'reference' => 'S1649NW14',
                'transaction_date' => now()->subDays(1),
                'total' => 1200,
                'affiliate_name' => 'Awonusi Temitope',
                'affiliate_email' => 'awonusitemitope25@gmail.com',
                'commission_percent' => 20,
                'commission_amount' => 240,
            ],
        ]);

        // Simulate pagination
        $recentTransactions = new LengthAwarePaginator(
            $recentTransactions,
            $recentTransactions->count(),
            10,
            1
        );

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
            'recentTransactions',
            'dummyUser'
        ));
    }

  public function orders()
{
    // Dummy dashboard stats (same as dashboard)
    $salesCount = 400;
    $totalVolumeNGN = 7000;
    $totalVolumeUSD = 102;
    $totalVolumeGHS = 46;
    $totalVolumeXAF = 20;
    $totalVolumeKES = 120;

    // Dummy transactions (or orders)
    $recentTransactions = collect([
        (object)[
            'product_name' => 'Website Design to Millions',
            'customer_name' => 'Moreira Bambi',
            'customer_email' => 'bambitechdrive@gmail.com',
            'reference' => 'S1649NW13',
            'transaction_date' => now()->subDays(2),
            'total' => 786,
            'affiliate_name' => 'Awonusi Temitope',
            'affiliate_email' => 'awonusitemitope25@gmail.com',
            'commission_percent' => 30,
            'commission_amount' => 800,
        ],
        (object)[
            'product_name' => 'SEO Mastery Course',
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'reference' => 'S1649NW14',
            'transaction_date' => now()->subDays(1),
            'total' => 1200,
            'affiliate_name' => 'Awonusi Temitope',
            'affiliate_email' => 'awonusitemitope25@gmail.com',
            'commission_percent' => 20,
            'commission_amount' => 240,
        ],
    ]);

    // Paginate dummy transactions
    $recentTransactions = new \Illuminate\Pagination\LengthAwarePaginator(
        $recentTransactions,
        $recentTransactions->count(),
        10,
        1
    );

    return view('affiliate.orders', compact(
        'salesCount',
        'totalVolumeNGN',
        'totalVolumeUSD',
        'totalVolumeGHS',
        'totalVolumeXAF',
        'totalVolumeKES',
        'recentTransactions'
    ));
}


    // Other placeholder methods
   public function marketplace()
{
    // Dummy products
    $products = collect([
        (object)[
            'name' => 'Affiliate Marketing Beginners',
            'category' => 'E-learning',
            'price' => 45000,
            'commission_percent' => 55,
            'rating' => 4,
            'slug' => 'affiliate-marketing-beginners'
        ],
        (object)[
            'name' => 'SEO Mastery Course',
            'category' => 'E-learning',
            'price' => 30000,
            'commission_percent' => 40,
            'rating' => 5,
            'slug' => 'seo-mastery-course'
        ],
        (object)[
            'name' => 'Social Media Marketing',
            'category' => 'E-learning',
            'price' => 25000,
            'commission_percent' => 50,
            'rating' => 3,
            'slug' => 'social-media-marketing'
        ],
        (object)[
            'name' => 'Ecommerce 101',
            'category' => 'E-learning',
            'price' => 20000,
            'commission_percent' => 45,
            'rating' => 4,
            'slug' => 'ecommerce-101'
        ],
        (object)[
            'name' => 'Facebook Ads Mastery',
            'category' => 'E-learning',
            'price' => 35000,
            'commission_percent' => 60,
            'rating' => 5,
            'slug' => 'facebook-ads-mastery'
        ],
        (object)[
            'name' => 'Email Marketing Expert',
            'category' => 'E-learning',
            'price' => 15000,
            'commission_percent' => 35,
            'rating' => 2,
            'slug' => 'email-marketing-expert'
        ],
        (object)[
            'name' => 'Copywriting Secrets',
            'category' => 'E-learning',
            'price' => 18000,
            'commission_percent' => 50,
            'rating' => 4,
            'slug' => 'copywriting-secrets'
        ],
        (object)[
            'name' => 'Instagram Growth',
            'category' => 'E-learning',
            'price' => 22000,
            'commission_percent' => 45,
            'rating' => 3,
            'slug' => 'instagram-growth'
        ],
        (object)[
            'name' => 'YouTube Monetization',
            'category' => 'E-learning',
            'price' => 40000,
            'commission_percent' => 55,
            'rating' => 5,
            'slug' => 'youtube-monetization'
        ],
        (object)[
            'name' => 'TikTok Marketing',
            'category' => 'E-learning',
            'price' => 18000,
            'commission_percent' => 40,
            'rating' => 4,
            'slug' => 'tiktok-marketing'
        ],
        (object)[
            'name' => 'Affiliate Funnel Mastery',
            'category' => 'E-learning',
            'price' => 50000,
            'commission_percent' => 60,
            'rating' => 5,
            'slug' => 'affiliate-funnel-mastery'
        ],
        (object)[
            'name' => 'Google Ads Training',
            'category' => 'E-learning',
            'price' => 35000,
            'commission_percent' => 50,
            'rating' => 4,
            'slug' => 'google-ads-training'
        ],
    ]);

    // Paginate manually
    $products = new \Illuminate\Pagination\LengthAwarePaginator(
        $products,
        $products->count(),
        12,
        1,
        ['path' => url()->current()]
    );

    return view('affiliate.marketplace', compact('products'));
}

public function promoteProduct($productId)
{
    // For now, just redirect back to marketplace (design phase)
    return redirect()->route('affiliate.marketplace')->with('success', 'You can now promote product ID: '.$productId);
}



    public function productDetail($slug) {
        return view('affiliate.product-detail');
    }

    public function statistics() {
        return view('affiliate.statistics');
    }

    public function withdrawals() {
        return view('affiliate.withdrawals');
    }
}
