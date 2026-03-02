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

    public function index(Request $request)
    {
        $user = Auth::user();
        $userCurrency = $user->currency;
        $toNGN = $this->toNGN;
        $symbols = $this->symbols;
        $balance = $user->affiliate_balance / $toNGN[$userCurrency];
        $withdrawalFee = 100; // fixed fee in NGN

        // Get all saved accounts for the user
        $savedAccounts = UserBankAccount::where('user_id', $user->id)->get();

        // Determine which account to display (selected or default)
        $selectedAccountId = $request->get('account_id');
        if ($selectedAccountId) {
            $bankDetails = UserBankAccount::where('user_id', $user->id)->find($selectedAccountId);
        } else {
            $bankDetails = UserBankAccount::where('user_id', $user->id)->where('is_default', true)->first();
        }

        // If no account, create a dummy empty object
        if (!$bankDetails) {
            $bankDetails = (object)[
                'type' => 'bank',
                'bank_name' => '',
                'account_number' => '',
                'account_name' => '',
                'momo_provider' => '',
                'momo_number' => '',
            ];
        }

        // Get withdrawal transactions
        $transactions = Transaction::where('user_id', $user->id)
            ->where('type', 'withdrawal')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($tx) use ($userCurrency, $toNGN) {
                $amountInUser = $tx->amount / $toNGN[$userCurrency];
                return [
                    'currency' => $userCurrency,
                    'amount' => -$amountInUser,
                    'type' => 'Withdrawal',
                    'description' => $tx->description,
                    'date' => $tx->created_at->format('M d, Y'),
                ];
            });

        return view('affiliate.withdrawal', compact(
            'balance',
            'withdrawalFee',
            'bankDetails',
            'savedAccounts',
            'selectedAccountId',
            'transactions',
            'userCurrency',
            'toNGN',
            'symbols'
        ));
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
        'account_id' => 'nullable|exists:user_bank_accounts,id,user_id,' . Auth::id(),
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

    DB::transaction(function () use (
        $user,
        $amountInNGN,
        $feeInNGN,
        $totalDeduction,  // <-- added here
        $amount,
        $userCurrency,
        $request
    ) {
        // Handle account saving
        if ($request->account_id) {
            // Update existing account
            $account = UserBankAccount::where('user_id', $user->id)->findOrFail($request->account_id);
            if ($request->account_type == 'bank') {
                $account->update([
                    'type' => 'bank',
                    'bank_name' => $request->bank_name,
                    'account_name' => $request->account_name,
                    'account_number' => $request->account_number,
                    'momo_provider' => null,
                    'momo_number' => null,
                ]);
            } else {
                $account->update([
                    'type' => 'momo',
                    'momo_provider' => $request->momo_provider,
                    'momo_number' => $request->momo_number,
                    'bank_name' => null,
                    'account_name' => null,
                    'account_number' => null,
                ]);
            }
        } else {
            // Create new account, optionally set as default if none exists
            $hasDefault = UserBankAccount::where('user_id', $user->id)->where('is_default', true)->exists();
            if ($request->account_type == 'bank') {
                UserBankAccount::create([
                    'user_id' => $user->id,
                    'type' => 'bank',
                    'bank_name' => $request->bank_name,
                    'account_name' => $request->account_name,
                    'account_number' => $request->account_number,
                    'is_default' => !$hasDefault,
                ]);
            } else {
                UserBankAccount::create([
                    'user_id' => $user->id,
                    'type' => 'momo',
                    'momo_provider' => $request->momo_provider,
                    'momo_number' => $request->momo_number,
                    'is_default' => !$hasDefault,
                ]);
            }
        }

        // Withdrawal logic
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

    return redirect()->route('affiliate.withdrawals')->with('success', 'Withdrawal request submitted successfully.');
}
}