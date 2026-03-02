<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
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

        // Convert balances to user's currency
        $walletBalance = $user->wallet_balance / $toNGN[$userCurrency];
        $affiliateBalance = $user->affiliate_balance / $toNGN[$userCurrency];

        // Get all transactions for this user
        $transactions = Transaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($tx) use ($userCurrency, $toNGN, $symbols) {
                $amountInUser = $tx->amount / $toNGN[$userCurrency];
                return [
                    'currency' => $userCurrency,
                    'amount' => $tx->type == 'withdrawal' ? -$amountInUser : $amountInUser,
                    'type' => ucfirst($tx->type),
                    'description' => $tx->description,
                    'date' => $tx->created_at->format('M d, Y'),
                ];
            });

        return view('affiliate.wallet', compact('walletBalance', 'affiliateBalance', 'transactions', 'userCurrency', 'symbols'));
    }
}