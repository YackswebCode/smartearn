<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\UserBankAccount;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
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
        $balance = $user->affiliate_balance / $this->toNGN[$userCurrency]; // withdrawal from affiliate balance
        $withdrawalFee = 100; // fixed fee in NGN, convert later

        // Get default bank account
        $bankDetails = UserBankAccount::where('user_id', $user->id)
            ->where('is_default', true)
            ->first();

        if (!$bankDetails) {
            // create a dummy for demo
            $bankDetails = (object)[
                'type' => 'bank',
                'bank_name' => 'Not set',
                'account_number' => '****',
                'account_name' => 'Not set',
            ];
        }

        // Get withdrawal transactions
        $transactions = Transaction::where('user_id', $user->id)
            ->where('type', 'withdrawal')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($tx) use ($userCurrency) {
                $amountInUser = $tx->amount / $this->toNGN[$userCurrency];
                return [
                    'currency' => $userCurrency,
                    'amount' => -$amountInUser,
                    'type' => 'Withdrawal',
                    'description' => $tx->description,
                    'date' => $tx->created_at->format('M d, Y'),
                ];
            });

        return view('affiliate.withdrawals', compact('balance', 'withdrawalFee', 'bankDetails', 'transactions', 'userCurrency', 'toNGN', 'symbols'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100',
            'account_type' => 'required|in:bank,momo',
            'bank_name' => 'required_if:account_type,bank|nullable|string',
            'account_name' => 'required_if:account_type,bank|nullable|string',
            'account_number' => 'required_if:account_type,bank|nullable|string',
            'momo_provider' => 'required_if:account_type,momo|nullable|string',
            'momo_number' => 'required_if:account_type,momo|nullable|string',
        ]);

        $user = Auth::user();
        $amount = $request->amount;
        $userCurrency = $user->currency;
        $amountInNGN = $amount * $this->toNGN[$userCurrency];
        $feeInNGN = 100; // fixed fee
        $totalDeduction = $amountInNGN + $feeInNGN;

        if ($user->affiliate_balance < $totalDeduction) {
            return back()->with('error', 'Insufficient affiliate balance.');
        }

        DB::transaction(function () use ($user, $amountInNGN, $feeInNGN, $amount, $userCurrency, $request) {
            // Save bank details if new
            if ($request->account_type == 'bank') {
                UserBankAccount::updateOrCreate(
                    ['user_id' => $user->id, 'type' => 'bank', 'is_default' => true],
                    [
                        'bank_name' => $request->bank_name,
                        'account_name' => $request->account_name,
                        'account_number' => $request->account_number,
                    ]
                );
            } else {
                UserBankAccount::updateOrCreate(
                    ['user_id' => $user->id, 'type' => 'momo', 'is_default' => true],
                    [
                        'momo_provider' => $request->momo_provider,
                        'momo_number' => $request->momo_number,
                    ]
                );
            }

            $oldBalance = $user->affiliate_balance;
            $user->affiliate_balance -= $totalDeduction;
            $user->save();

            Transaction::create([
                'user_id' => $user->id,
                'type' => 'withdrawal',
                'amount' => $amountInNGN,
                'currency' => 'NGN',
                'balance_type' => 'affiliate',
                'balance_before' => $oldBalance,
                'balance_after' => $user->affiliate_balance,
                'description' => "Withdrawal to " . ($request->account_type == 'bank' ? 'bank' : 'mobile money'),
                'reference' => 'WD_' . uniqid(),
                'status' => 'pending', // admin approval maybe
                'meta' => [
                    'user_currency' => $userCurrency,
                    'user_amount' => $amount,
                    'fee' => $feeInNGN,
                    'account_details' => $request->only(['account_type', 'bank_name', 'account_name', 'account_number', 'momo_provider', 'momo_number']),
                ],
            ]);
        });

        return redirect()->route('affiliate.withdrawal')->with('success', 'Withdrawal request submitted successfully.');
    }
}