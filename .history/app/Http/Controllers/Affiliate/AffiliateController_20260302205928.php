<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AffiliateController extends Controller
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

    public function dashboard()
    {
        $user = Auth::user();
        $userCurrency = $user->currency;
        $toNGN = $this->toNGN;
        $symbols = $this->symbols;

        $orders = Order::where('affiliate_id', $user->id)
                       ->where('status', 'completed')
                       ->get();

        $salesCount = $orders->count();

        // ----- SALES VOLUME (per currency) -----
        $volumeNGN = $orders->where('currency', 'NGN')->sum('amount');
        $volumeUSD = $orders->where('currency', 'USD')->sum('amount');
        $volumeGHS = $orders->where('currency', 'GHS')->sum('amount');
        $volumeXAF = $orders->where('currency', 'XAF')->sum('amount');
        $volumeKES = $orders->where('currency', 'KES')->sum('amount');

        // ----- AFFILIATE EARNINGS (in NGN) -----
        $overallEarningNGN = $orders->sum(function ($order) use ($toNGN) {
            return $order->affiliate_commission * $toNGN[$order->currency];
        });

        // Today's data
        $todayOrders = $orders->where('created_at', '>=', now()->startOfDay());
        $todaySalesCount = $todayOrders->count();
        $todayEarningNGN = $todayOrders->sum(function ($order) use ($toNGN) {
            return $order->affiliate_commission * $toNGN[$order->currency];
        });

        $totalWithdrawnNGN = 0; // withdrawals not yet implemented

        // Convert total sales volume to user's currency (for display)
        $totalVolumeUserCurrency = $orders->sum(function ($order) use ($toNGN, $userCurrency) {
            return $order->amount * ($toNGN[$order->currency] / $toNGN[$userCurrency]);
        });

        $totalWithdrawnUserCurrency = $totalWithdrawnNGN / $toNGN[$userCurrency];
        $overallEarningUserCurrency = $overallEarningNGN / $toNGN[$userCurrency];
        $todayEarningUserCurrency = $todayEarningNGN / $toNGN[$userCurrency];

        // Recent transactions
        $recentTransactions = $orders->sortByDesc('created_at')->take(10)->map(function ($order) use ($user) {
            $product = Product::find($order->product_id);
            return (object)[
                'product_name'       => $product->name ?? 'Unknown Product',
                'customer_name'      => $order->buyer_name,
                'customer_email'     => $order->buyer_email,
                'reference'          => $order->reference,
                'transaction_date'   => $order->created_at,
                'total'              => $order->amount,          // in original currency
                'affiliate_name'     => $user->name,
                'affiliate_email'    => $user->email,
                'commission_percent' => $product->commission_percent ?? 0,
                'commission_amount'  => $order->affiliate_commission, // in original currency
            ];
        });

        return view('affiliate.dashboard', compact(
            'salesCount',
            'volumeNGN',
            'volumeUSD',
            'volumeGHS',
            'volumeXAF',
            'volumeKES',
            'totalVolumeUserCurrency',
            'totalWithdrawnUserCurrency',
            'overallEarningUserCurrency',
            'todayEarningUserCurrency',
            'todaySalesCount',
            'recentTransactions',
            'userCurrency',
            'symbols',
            'toNGN'
        ));
    }

    public function orders()
    {
        $user = Auth::user();
        $userCurrency = $user->currency;
        $toNGN = $this->toNGN;
        $symbols = $this->symbols;

        $orders = Order::where('affiliate_id', $user->id)
                       ->where('status', 'completed')
                       ->orderBy('created_at', 'desc')
                       ->get();

        $salesCount = $orders->count();

        // Sales volume per currency
        $volumeNGN = $orders->where('currency', 'NGN')->sum('amount');
        $volumeUSD = $orders->where('currency', 'USD')->sum('amount');
        $volumeGHS = $orders->where('currency', 'GHS')->sum('amount');
        $volumeXAF = $orders->where('currency', 'XAF')->sum('amount');
        $volumeKES = $orders->where('currency', 'KES')->sum('amount');

        $recentTransactions = $orders->map(function ($order) use ($user) {
            $product = Product::find($order->product_id);
            return (object)[
                'product_name'       => $product->name ?? 'Unknown Product',
                'customer_name'      => $order->buyer_name,
                'customer_email'     => $order->buyer_email,
                'reference'          => $order->reference,
                'transaction_date'   => $order->created_at,
                'total'              => $order->amount,
                'affiliate_name'     => $user->name,
                'affiliate_email'    => $user->email,
                'commission_percent' => $product->commission_percent ?? 0,
                'commission_amount'  => $order->affiliate_commission,
            ];
        });

        return view('affiliate.orders', compact(
            'salesCount',
            'volumeNGN',
            'volumeUSD',
            'volumeGHS',
            'volumeXAF',
            'volumeKES',
            'recentTransactions',
            'userCurrency',
            'symbols',
            'toNGN'
        ));
    }

    public function marketplace()
    {
        $user = Auth::user();
        $userCurrency = $user->currency;
        $toNGN = $this->toNGN;
        $symbols = $this->symbols;

        $isSubscribed = $user->marketplace_subscribed && $user->subscription_expires_at && $user->subscription_expires_at->isFuture();

        if (!$isSubscribed) {
            return view('affiliate.marketplace-subscribe', compact('user', 'userCurrency', 'toNGN', 'symbols'));
        }

        $products = Product::paginate(8);
        return view('affiliate.marketplace', compact('products', 'userCurrency', 'toNGN', 'symbols'));
    }

    public function subscribe(Request $request)
    {
        $user = Auth::user();
        $fee = 5000;

        if ($user->wallet_balance < $fee) {
            return back()->with('error', 'Insufficient wallet balance. Please add funds.');
        }

        $user->wallet_balance -= $fee;
        $user->marketplace_subscribed = true;
        $user->subscription_expires_at = now()->addYear();
        $user->save();

        return redirect()->route('affiliate.marketplace')->with('success', 'Subscription successful! You now have access.');
    }

    public function productDetail($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('affiliate.product-detail', compact('product'));
    }
}