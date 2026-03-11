<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopVendorController extends Controller
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

        $vendors = User::where('vendor_status', 'Active')->get();
        $vendorData = [];

        foreach ($vendors as $vendor) {
            $orders = Order::where('vendor_id', $vendor->id)
                ->where('status', 'completed')
                ->get();

            $totalSalesNGN = 0;
            $totalEarningsNGN = 0;
            $transactions = $orders->count();

            foreach ($orders as $order) {
                $rate = $toNGN[$order->currency] ?? 1;
                $totalSalesNGN += $order->amount * $rate;
                $totalEarningsNGN += $order->vendor_earnings * $rate;
            }

            // Convert to user's currency
            $toUserCurrency = $toNGN[$userCurrency]; // NGN per user currency
            $totalSalesUser = $totalSalesNGN / $toUserCurrency;
            $totalEarningsUser = $totalEarningsNGN / $toUserCurrency;
            $conversion = $totalSalesNGN > 0 ? ($totalEarningsNGN / $totalSalesNGN) * 100 : 0;

            $vendorData[] = [
                'vendor' => $vendor,
                'total_sales' => $totalSalesUser,
                'total_earnings' => $totalEarningsUser,
                'transactions' => $transactions,
                'conversion' => $conversion,
            ];
        }

        // Sort by total sales (in user's currency, descending)
        usort($vendorData, fn($a, $b) => $b['total_sales'] <=> $a['total_sales']);

        $topVendor = $vendorData[0] ?? null;
        $rankings = array_slice($vendorData, 1, 9); // next 9

        return view('vendor.top_vendor', compact(
            'topVendor',
            'rankings',
            'userCurrency',
            'symbols'
        ));
    }
}