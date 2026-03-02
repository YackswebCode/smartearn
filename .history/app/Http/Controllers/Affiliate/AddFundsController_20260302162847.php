<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddFundsController extends Controller
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
        $balance = $user->wallet_balance / $this->toNGN[$userCurrency];

        // Get only funding transactions
        $transactions = Transaction::where('user_id', $user->id)
            ->where('type', 'funding')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($tx) use ($userCurrency) {
                return [
                    'currency' => $userCurrency,
                    'amount' => $tx->amount / $this->toNGN[$userCurrency],
                    'type' => 'Funding',
                    'description' => $tx->description,
                    'date' => $tx->created_at->format('M d, Y'),
                ];
            });

        return view('affiliate.add_funds', compact('balance', 'transactions', 'userCurrency'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|in:card,bank,paypal',
        ]);

        $user = Auth::user();
        $amount = $request->amount;
        $userCurrency = $user->currency;
        $amountInNGN = $amount * $this->toNGN[$userCurrency];

        // For simplicity, we'll simulate a successful payment.
        // In production, integrate Flutterwave here.
        // After successful payment:
        DB::transaction(function () use ($user, $amountInNGN, $amount, $userCurrency, $request) {
            $oldBalance = $user->wallet_balance;
            $user->wallet_balance += $amountInNGN;
            $user->save();

            Transaction::create([
                'user_id' => $user->id,
                'type' => 'funding',
                'amount' => $amountInNGN,
                'currency' => 'NGN',
                'balance_type' => 'wallet',
                'balance_before' => $oldBalance,
                'balance_after' => $user->wallet_balance,
                'description' => "Added funds via " . ucfirst($request->payment_method),
                'reference' => 'FUND_' . uniqid(),
                'payment_gateway' => $request->payment_method,
                'status' => 'completed',
                'meta' => ['user_currency' => $userCurrency, 'user_amount' => $amount],
            ]);
        });

        return redirect()->route('affiliate.add_funds')->with('success', 'Funds added successfully.');
    }
}