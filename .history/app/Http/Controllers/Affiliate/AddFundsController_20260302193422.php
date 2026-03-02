<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $toNGN = $this->toNGN;
        $symbols = $this->symbols;
        $balance = $user->wallet_balance / $toNGN[$userCurrency];

        // Get only funding transactions
        $transactions = Transaction::where('user_id', $user->id)
            ->where('type', 'funding')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($tx) use ($userCurrency, $toNGN) {
                $amountInUser = $tx->amount / $toNGN[$userCurrency];
                return [
                    'currency' => $userCurrency,
                    'amount' => $amountInUser,
                    'type' => 'Funding',
                    'description' => $tx->description,
                    'date' => $tx->created_at->format('M d, Y'),
                ];
            });

        return view('affiliate.add_funds', compact('balance', 'transactions', 'userCurrency', 'toNGN', 'symbols'));
    }

    public function verify(Request $request)
    {
        Log::info('Funding verification started', $request->all());

        $request->validate([
            'transaction_id' => 'required',
            'reference' => 'required|string',
            'amount' => 'required|numeric',
            'currency' => 'required|in:NGN,USD,GHS,XAF,KES',
        ]);

        // Verify with Flutterwave (implement properly)
        $verified = $this->verifyFlutterwaveTransaction($request->transaction_id, $request->amount, $request->currency);

        if (!$verified) {
            return response()->json(['success' => false, 'message' => 'Transaction verification failed.']);
        }

        $user = Auth::user();
        $amountInUserCurrency = $request->amount;
        $userCurrency = $user->currency;
        $amountInNGN = $amountInUserCurrency * $this->toNGN[$userCurrency];

        DB::beginTransaction();

        try {
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
                'description' => 'Wallet funding via Flutterwave',
                'reference' => $request->reference,
                'payment_gateway' => 'flutterwave',
                'status' => 'completed',
                'meta' => [
                    'user_currency' => $userCurrency,
                    'user_amount' => $amountInUserCurrency,
                    'flutterwave_tx_id' => $request->transaction_id,
                ],
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'redirect' => route('affiliate.add_funds')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Funding error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    private function verifyFlutterwaveTransaction($transactionId, $expectedAmount, $expectedCurrency)
    {
        // TODO: Implement actual Flutterwave verification using their API
        // For now, return true for testing
        return true;
    }
}