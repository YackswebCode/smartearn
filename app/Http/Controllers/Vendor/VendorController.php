<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
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

  public function dashboard(Request $request)
{
    $user = Auth::user();
    $userCurrency = $user->currency;
    $toNGN = $this->toNGN;
    $symbols = $this->symbols;

    $productIds = Product::where('vendor_id', $user->id)->pluck('id');
    $orders = Order::whereIn('product_id', $productIds)
                    ->where('status', 'completed')
                    ->get();

    // ----- Basic metrics -----
    $salesCount = $orders->count();

    // ----- Volume per currency (total order amount) -----
    $volumeNGN = $orders->where('currency', 'NGN')->sum('amount');
    $volumeUSD = $orders->where('currency', 'USD')->sum('amount');
    $volumeGHS = $orders->where('currency', 'GHS')->sum('amount');
    $volumeXAF = $orders->where('currency', 'XAF')->sum('amount');
    $volumeKES = $orders->where('currency', 'KES')->sum('amount');

    // ----- Vendor earnings per currency (using vendor_earnings) -----
    $earningsNGN = $orders->where('currency', 'NGN')->sum('vendor_earnings');
    $earningsUSD = $orders->where('currency', 'USD')->sum('vendor_earnings');
    $earningsGHS = $orders->where('currency', 'GHS')->sum('vendor_earnings');
    $earningsXAF = $orders->where('currency', 'XAF')->sum('vendor_earnings');
    $earningsKES = $orders->where('currency', 'KES')->sum('vendor_earnings');

    // ----- Total vendor earnings in NGN -----
    $totalEarningsNGN = $orders->sum(function ($order) use ($toNGN) {
        return $order->vendor_earnings * $toNGN[$order->currency];
    });

    // ----- Today's data -----
    $todayOrders = $orders->where('created_at', '>=', now()->startOfDay());
    $todaySalesCount = $todayOrders->count();
    $todayEarningsNGN = $todayOrders->sum(function ($order) use ($toNGN) {
        return $order->vendor_earnings * $toNGN[$order->currency];
    });

    // ----- Withdrawn amount (from user's vendor_balance) -----
    $totalWithdrawn = $user->vendor_balance ?? 0; // Assuming this is in NGN
    $totalWithdrawnUserCurrency = $totalWithdrawn / $toNGN[$userCurrency];

    // ----- Convert main metrics to user's currency -----
    $totalVolumeUserCurrency = $orders->sum(function ($order) use ($toNGN, $userCurrency) {
        return $order->amount * ($toNGN[$order->currency] / $toNGN[$userCurrency]);
    });

    $totalEarningsUserCurrency = $orders->sum(function ($order) use ($toNGN, $userCurrency) {
        return $order->vendor_earnings * ($toNGN[$order->currency] / $toNGN[$userCurrency]);
    });

    $todayEarningsUserCurrency = $todayOrders->sum(function ($order) use ($toNGN, $userCurrency) {
        return $order->vendor_earnings * ($toNGN[$order->currency] / $toNGN[$userCurrency]);
    });

   $topProducts = Product::where('vendor_id', $user->id)
    ->withCount(['orders as units_sold' => function ($query) {
        $query->where('status', 'completed');
    }])
    ->with(['orders' => function ($query) {
        $query->where('status', 'completed');
    }])
    ->get()
    ->map(function ($product) use ($toNGN, $userCurrency) {
        $revenue = $product->orders->sum(function ($order) use ($toNGN, $userCurrency) {
            return $order->vendor_earnings * ($toNGN[$order->currency] / $toNGN[$userCurrency]);
        });
        return (object)[
            'id' => $product->id,
            'name' => $product->name,
            'image' => $product->image, // <-- Add this
            'units_sold' => $product->units_sold,
            'revenue' => $revenue,
        ];
    })
    ->sortByDesc('units_sold')
    ->take(5)
    ->values();

    // ----- Recent Sales -----
    $recentSales = Order::whereIn('product_id', $productIds)
        ->where('status', 'completed')
        ->with('product', 'affiliate')
        ->orderBy('created_at', 'desc')
        ->take(10)
        ->get()
        ->map(function ($order) use ($toNGN, $userCurrency, $symbols) {
            $affiliate = $order->affiliate;
            return (object)[
                'product_type' => $order->product->type ?? 'N/A',
                'customer_name' => $order->buyer_name,
                'customer_email' => $order->buyer_email,
                'reference' => $order->reference,
                'date' => $order->created_at,
                'amount' => $order->amount * ($toNGN[$order->currency] / $toNGN[$userCurrency]),
                'amount_formatted' => $symbols[$userCurrency] . number_format($order->amount * ($toNGN[$order->currency] / $toNGN[$userCurrency]), 2),
                'affiliate_name' => $affiliate->name ?? 'N/A',
                'affiliate_email' => $affiliate->email ?? 'N/A',
                'commission' => $order->affiliate_commission * ($toNGN[$order->currency] / $toNGN[$userCurrency]),
                'commission_formatted' => $symbols[$userCurrency] . number_format($order->affiliate_commission * ($toNGN[$order->currency] / $toNGN[$userCurrency]), 2),
            ];
        });

    // Placeholder percentage changes (you can compute real ones later)
    $salesChange = '+12.5%';
    $volumeChange = '+8.2%';
    $withdrawalChange = '+5.4%';
    $earningsChange = '+15.8%';
    $todayEarningsChange = '+22.3%';
    $totalSalesChange = '+9.7%';

    return view('vendor.dashboard', compact(
        'user',
        'userCurrency',
        'symbols',
        'toNGN',
        'salesCount',
        'volumeNGN',
        'volumeUSD',
        'volumeGHS',
        'volumeXAF',
        'volumeKES',
        'totalVolumeUserCurrency',
        'totalWithdrawnUserCurrency',
        'totalEarningsUserCurrency',
        'todayEarningsUserCurrency',
        'todaySalesCount',
        'topProducts',
        'recentSales',
        'salesChange',
        'volumeChange',
        'withdrawalChange',
        'earningsChange',
        'todayEarningsChange',
        'totalSalesChange'
    ));
}

    // Additional methods: orders, products, etc. can be added later
}