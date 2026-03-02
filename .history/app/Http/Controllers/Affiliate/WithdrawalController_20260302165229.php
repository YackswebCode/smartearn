<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\UserBankAccount;
use App\Models\Withdrawal;          // new model
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

        // Check if there's a pending withdrawal
        $hasPending = Withdrawal::where('user_id', $user->id)
            ->where('status', 'pending')
            ->exists();

        // Get all saved accounts
        $savedAccounts = UserBankAccount::where('user_id', $user->id)->get();

        // Determine which account to display
        $selectedAccountId = $request->get('account_id');
        if ($selectedAccountId) {
            $bankDetails = UserBankAccount::where('user_id', $user->id)->find($selectedAccountId);
        } else {
            $bankDetails = UserBankAccount::where('user_id', $user->id)->where('is_default', true)->first();
        }

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

        // Get **approved** withdrawal transactions (for history)
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

        return view('affiliate.withdrawals', compact(
            'balance',
            'withdrawalFee',
            'bankDetails',
            'savedAccounts',
            'selectedAccountId',
            'transactions',
            'userCurrency',
            'toNGN',
            'symbols',
            'hasPending'
        ));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Check if user already has a pending withdrawal
        if (Withdrawal::where('user_id', $user->id)->where('status', 'pending')->exists()) {
            return back()->with('error', 'You already have a pending withdrawal request. Please wait for it to be processed.');
        }

        $request->validate([
            'amount' => 'required|numeric|min:100',
            'account_type' => 'required|in:bank,momo',
            'bank_name' => 'required_if:account_type,bank|nullable|string',
            'account_name' => 'required_if:account_type,bank|nullable|string',
            'account_number' => 'required_if:account_type,bank|nullable|string',
            'momo_provider' => 'required_if:account_type,momo|nullable|string',
            'momo_number' => 'required_if:account_type,momo|nullable|string',
            'account_id' => 'nullable|exists:user_bank_accounts,id,user_id,' . $user->id,
        ]);

        $amount = $request->amount;
        $userCurrency = $user->currency;
        $amountInNGN = $amount * $this->toNGN[$userCurrency];
        $feeInNGN = 100;
        $totalDeduction = $amountInNGN + $feeInNGN;

        // Check if affiliate balance is sufficient (before any pending)
        if ($user->affiliate_balance < $totalDeduction) {
            return back()->with('error', 'Insufficient affiliate balance.');
        }

        DB::transaction(function () use ($user, $amountInNGN, $feeInNGN, $totalDeduction, $amount, $userCurrency, $request) {
            // Handle account saving (same as before)
            if ($request->account_id) {
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

            // Create pending withdrawal record
            Withdrawal::create([
                'user_id' => $user->id,
                'amount' => $amountInNGN,
                'currency' => 'NGN',
                'status' => 'pending',
                'account_details' => [
                    'type' => $request->account_type,
                    'bank_name' => $request->bank_name,
                    'account_name' => $request->account_name,
                    'account_number' => $request->account_number,
                    'momo_provider' => $request->momo_provider,
                    'momo_number' => $request->momo_number,
                    'fee' => $feeInNGN,
                ],
            ]);

            // No balance deduction yet
        });

        return redirect()->route('affiliate.withdrawals')->with('success', 'Withdrawal request submitted successfully. It will be processed within 24 hours.');
    }
}