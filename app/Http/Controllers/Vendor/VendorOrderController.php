<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorOrderController extends Controller
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

        // Get all product IDs owned by this vendor
        $productIds = Product::where('vendor_id', $user->id)->pluck('id');

        // Build orders query (only completed orders)
        $ordersQuery = Order::whereIn('product_id', $productIds)
                            ->where('status', 'completed')
                            ->with('product', 'affiliate');

        // Optional: apply filters from request (e.g., date range, product)
        // For now, just get all orders

        $orders = $ordersQuery->orderBy('created_at', 'desc')->get();

        // ----- Metrics -----
        $salesCount = $orders->count();

        // Volume per currency
        $volumeNGN = $orders->where('currency', 'NGN')->sum('amount');
        $volumeUSD = $orders->where('currency', 'USD')->sum('amount');
        $volumeGHS = $orders->where('currency', 'GHS')->sum('amount');
        $volumeXAF = $orders->where('currency', 'XAF')->sum('amount');
        $volumeKES = $orders->where('currency', 'KES')->sum('amount');

        // Total volume in user's currency
        $totalVolumeUserCurrency = $orders->sum(function ($order) use ($toNGN, $userCurrency) {
            return $order->amount * ($toNGN[$order->currency] / $toNGN[$userCurrency]);
        });

        // Total earnings (vendor_earnings) in user's currency
        $totalEarningsUserCurrency = $orders->sum(function ($order) use ($toNGN, $userCurrency) {
            return $order->vendor_earnings * ($toNGN[$order->currency] / $toNGN[$userCurrency]);
        });

        // Total withdrawn (from user's vendor_balance, assumed NGN)
        $totalWithdrawn = $user->vendor_balance ?? 0;
        $totalWithdrawnUserCurrency = $totalWithdrawn / $toNGN[$userCurrency];

        // Prepare orders list for display (with formatted values)
        $ordersList = $orders->map(function ($order) use ($toNGN, $userCurrency, $symbols) {
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

        // Placeholder percentage changes (can be replaced with real calculations later)
        $salesChange = '+12.5%';
        $volumeChange = '+8.2%';
        $withdrawalChange = '+5.4%';
        $earningsChange = '+15.8%';
        $todayEarningsChange = '+22.3%';
        $totalSalesChange = '+9.7%';

       return view('vendor.orders', compact(
        'userCurrency',
        'symbols',
        'salesCount',
        'volumeNGN',          // <-- add
        'volumeUSD',          // <-- add
        'volumeGHS',          // <-- add
        'volumeXAF',          // <-- add
        'volumeKES',          // <-- add
        'totalVolumeUserCurrency',
        'totalWithdrawnUserCurrency',
        'totalEarningsUserCurrency',
        'ordersList',
        'salesChange',
        'volumeChange',
        'withdrawalChange',
        'earningsChange',
        'todayEarningsChange',
        'totalSalesChange'
    ));
    }
}