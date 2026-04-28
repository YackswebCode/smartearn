<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
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

    public function index(Request $request)
    {
        $user = Auth::user();
        $userCurrency = $user->currency;
        $toNGN = $this->toNGN;
        $symbols = $this->symbols;

        $currentMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        // --- Filter logic ---
        $productId = $request->input('product_id');
        $selectedProduct = null;

        if ($productId) {
            $selectedProduct = Product::find($productId);
            if (!$selectedProduct) {
                $productId = null; // ignore invalid ids
            }
        }

        // Base query
        $query = Order::where('status', 'completed')
            ->whereBetween('created_at', [$currentMonth, $endOfMonth]);

        if ($productId) {
            $query->where('product_id', $productId);
        }

        $affiliateStats = $query->select(
                'affiliate_id',
                DB::raw('COUNT(*) as sales_count')
            )
            ->groupBy('affiliate_id')
            ->orderByDesc('sales_count')
            ->get();

        // Prepare leaderboard
        $leaderboard = [];
        $position = 1;
        foreach ($affiliateStats as $stat) {
            $affiliate = User::find($stat->affiliate_id);
            if (!$affiliate) continue;

            $leaderboard[] = [
                'position' => $position,
                'name' => $affiliate->name,
                'product_name' => $productId ? ($selectedProduct->name ?? 'Unknown') : 'All Products',
                'sales' => $stat->sales_count,
            ];
            $position++;
        }

        // Products for filter dropdown (all products)
        $products = Product::orderBy('name')->get();

        return view('affiliate.top_affiliate', compact(
            'leaderboard',
            'userCurrency',
            'symbols',
            'products',
            'productId'  // selected product id for dropdown
        ));
    }
}