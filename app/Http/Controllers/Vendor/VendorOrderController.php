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

    protected function convertAmount(float $amount, string $fromCurrency, string $toCurrency): float
    {
        $fromRate = $this->toNGN[$fromCurrency] ?? 1;
        $toRate = $this->toNGN[$toCurrency] ?? 1;

        return $amount * ($fromRate / $toRate);
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $userCurrency = $this->symbols[$user->currency ?? 'NGN'] ? ($user->currency ?? 'NGN') : 'NGN';

        if (!array_key_exists($userCurrency, $this->toNGN)) {
            $userCurrency = 'NGN';
        }

        $symbols = $this->symbols;

        // All product IDs owned by this vendor
        $productIds = Product::where('vendor_id', $user->id)->pluck('id');

        // Completed orders only
        $orders = Order::whereIn('product_id', $productIds)
            ->where('status', 'completed')
            ->with(['product', 'affiliate'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Overall metrics
        $salesCount = $orders->count();

        $volumeNGN = $orders->where('currency', 'NGN')->sum('amount');
        $volumeUSD = $orders->where('currency', 'USD')->sum('amount');
        $volumeGHS = $orders->where('currency', 'GHS')->sum('amount');
        $volumeXAF = $orders->where('currency', 'XAF')->sum('amount');
        $volumeKES = $orders->where('currency', 'KES')->sum('amount');

        $totalVolumeUserCurrency = $orders->sum(function ($order) use ($userCurrency) {
            return $this->convertAmount((float) $order->amount, $order->currency ?? 'NGN', $userCurrency);
        });

        $totalEarningsUserCurrency = $orders->sum(function ($order) use ($userCurrency) {
            return $this->convertAmount((float) $order->affiliate_commission, $order->currency ?? 'NGN', $userCurrency);
        });

        $totalWithdrawn = $user->vendor_balance ?? 0;
        $totalWithdrawnUserCurrency = $this->convertAmount((float) $totalWithdrawn, 'NGN', $userCurrency);

        // Recent transactions only (client asked for recent transactions)
        $ordersList = $orders->take(10)->map(function ($order) use ($userCurrency, $symbols) {
            $affiliate = $order->affiliate;
            $product = $order->product;

            $convertedAmount = $this->convertAmount((float) $order->amount, $order->currency ?? 'NGN', $userCurrency);
            $convertedCommission = $this->convertAmount((float) $order->affiliate_commission, $order->currency ?? 'NGN', $userCurrency);

            return (object) [
                'id' => $order->id,
                'product_name' => $product->name ?? 'N/A',
                'product_type' => $product->type ?? 'N/A',
                'customer_name' => $order->buyer_name ?? 'N/A',
                'customer_email' => $order->buyer_email ?? 'N/A',
                'reference' => $order->reference ?? 'N/A',
                'date' => optional($order->created_at)->format('Y-m-d H:i'),
                'currency' => $order->currency ?? 'NGN',
                'amount' => $convertedAmount,
                'amount_formatted' => ($symbols[$userCurrency] ?? '') . number_format($convertedAmount, 2),
                'affiliate_name' => $affiliate->name ?? 'N/A',
                'affiliate_email' => $affiliate->email ?? 'N/A',
                'commission' => $convertedCommission,
                'commission_formatted' => ($symbols[$userCurrency] ?? '') . number_format($convertedCommission, 2),
                'status' => $order->status ?? 'completed',
            ];
        });

        // Placeholder percentage changes
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
            'totalVolumeUserCurrency',
            'totalWithdrawnUserCurrency',
            'totalEarningsUserCurrency',
            'ordersList',
            'salesChange',
            'volumeChange',
            'withdrawalChange',
            'earningsChange',
            'todayEarningsChange',
            'totalSalesChange',
            'volumeNGN',
            'volumeUSD',
            'volumeGHS',
            'volumeXAF',
            'volumeKES'
        ));
    }
}