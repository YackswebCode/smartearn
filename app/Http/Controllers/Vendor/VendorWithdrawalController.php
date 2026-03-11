<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\UserBankAccount;
use App\Models\Withdrawal;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VendorWithdrawalController extends Controller
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

        // Available vendor balance in user's currency
        $balance = $user->vendor_balance / $toNGN[$userCurrency];

        // Fixed fee (in NGN, but displayed in user currency)
        $withdrawalFee = 100; // NGN

        // Check for any pending withdrawal
        $hasPending = Withdrawal::where('user_id', $user->id)
            ->where('status', 'pending')
            ->where('type', 'vendor')
            ->exists();

        // User's saved bank accounts
        $savedAccounts = UserBankAccount::where('user_id', $user->id)->get();

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

        // Fetch all vendor withdrawal requests from the withdrawals table (type = vendor)
        $withdrawals = Withdrawal::where('user_id', $user->id)
            ->where('type', 'vendor')
            ->orderBy('created_at', 'desc')
            ->get();

        $allWithdrawals = $withdrawals->map(function ($wd) use ($userCurrency, $toNGN, $symbols) {
            $amountInUserCurrency = $wd->amount / $toNGN[$userCurrency];
            $statusText = ucfirst($wd->status);
            $details = $wd->account_details ?? [];
            $type = $details['type'] ?? 'bank';
            $description = $type === 'bank'
                ? ($details['bank_name'] ?? 'Bank') . ' - ' . ($details['account_number'] ?? '')
                : ($details['momo_provider'] ?? 'Momo') . ' - ' . ($details['momo_number'] ?? '');

            return [
                'currency' => $userCurrency,
                'amount' => -$amountInUserCurrency,
                'type' => 'Withdrawal',
                'description' => $description,
                'date' => $wd->created_at->format('M d, Y'),
                'status' => $statusText,
            ];
        });

        return view('vendor.withdrawal', compact(
            'balance',
            'withdrawalFee',
            'bankDetails',
            'savedAccounts',
            'selectedAccountId',
            'allWithdrawals',
            'userCurrency',
            'toNGN',
            'symbols',
            'hasPending'
        ));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Check if user already has a pending vendor withdrawal
        if (Withdrawal::where('user_id', $user->id)->where('type', 'vendor')->where('status', 'pending')->exists()) {
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

        // Check if vendor balance is sufficient
        if ($user->vendor_balance < $totalDeduction) {
            return back()->with('error', 'Insufficient vendor balance.');
        }

        DB::transaction(function () use ($user, $amountInNGN, $feeInNGN, $totalDeduction, $amount, $userCurrency, $request) {
            // Handle bank account (same as affiliate)
            $account = null;

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
                $existingAccount = null;
                if ($request->account_type == 'bank') {
                    $existingAccount = UserBankAccount::where('user_id', $user->id)
                        ->where('type', 'bank')
                        ->where('bank_name', $request->bank_name)
                        ->where('account_number', $request->account_number)
                        ->first();
                } else {
                    $existingAccount = UserBankAccount::where('user_id', $user->id)
                        ->where('type', 'momo')
                        ->where('momo_provider', $request->momo_provider)
                        ->where('momo_number', $request->momo_number)
                        ->first();
                }

                if ($existingAccount) {
                    $account = $existingAccount;
                } else {
                    $hasDefault = UserBankAccount::where('user_id', $user->id)->where('is_default', true)->exists();
                    if ($request->account_type == 'bank') {
                        $account = UserBankAccount::create([
                            'user_id' => $user->id,
                            'type' => 'bank',
                            'bank_name' => $request->bank_name,
                            'account_name' => $request->account_name,
                            'account_number' => $request->account_number,
                            'is_default' => !$hasDefault,
                        ]);
                    } else {
                        $account = UserBankAccount::create([
                            'user_id' => $user->id,
                            'type' => 'momo',
                            'momo_provider' => $request->momo_provider,
                            'momo_number' => $request->momo_number,
                            'is_default' => !$hasDefault,
                        ]);
                    }
                }
            }

            // Create transaction record with status 'pending' (no balance change)
            $oldBalance = $user->vendor_balance;
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'type' => 'withdrawal',
                'amount' => $amountInNGN,
                'currency' => 'NGN',
                'balance_type' => 'vendor',
                'balance_before' => $oldBalance,
                'balance_after' => $oldBalance,
                'description' => "Vendor withdrawal request (pending approval) to " . ($request->account_type == 'bank' ? 'bank' : 'mobile money'),
                'reference' => 'WD_V_' . uniqid(),
                'payment_gateway' => null,
                'status' => 'pending',
                'meta' => [
                    'user_currency' => $userCurrency,
                    'user_amount' => $amount,
                    'fee' => $feeInNGN,
                    'account_details' => $request->only(['account_type', 'bank_name', 'account_name', 'account_number', 'momo_provider', 'momo_number']),
                ],
            ]);

            // Create withdrawal record for admin tracking, type = 'vendor'
            Withdrawal::create([
                'user_id' => $user->id,
                'type' => 'vendor',
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
                'processed_at' => null,
            ]);
        });

        return redirect()->route('vendor.withdrawals')->with('success', 'Withdrawal request submitted successfully. It will be processed within 24 hours.');
    }
}