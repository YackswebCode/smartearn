<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\DigitalEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        // Fetch all active/completed digital enrollments (purchases)
        $purchases = DigitalEnrollment::with('track.faculty')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $allPurchasesCount = $purchases->count();
        $totalInvestment = $purchases->sum('amount_paid'); // in the track's currency

        // Group by currency for display
        $investmentByCurrency = $purchases->groupBy('currency')
            ->map(function ($items) {
                return $items->sum('amount_paid');
            });

        // Recent purchases (last 5)
        $recentPurchases = $purchases->take(5);

        // Use a default currency symbol for total (you can refine this per-currency)
        $currencySymbol = '₦'; // or fetch from user preference

        return view('customer.dashboard', compact(
            'allPurchasesCount',
            'totalInvestment',
            'currencySymbol',
            'investmentByCurrency',
            'recentPurchases'
        ));
    }

    public function myPurchases()
    {
        $user = Auth::user();
        $purchases = DigitalEnrollment::with('track.faculty')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.my_purchases', compact('purchases'));
    }
}