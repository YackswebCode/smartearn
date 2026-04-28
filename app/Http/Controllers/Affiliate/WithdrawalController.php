<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\UserBankAccount;
use App\Models\Withdrawal;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;     // <-- added for PIN hashing

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

    /**
     * Show the withdrawal form and list of past withdrawals.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $userCurrency = $user->currency;
        $toNGN = $this->toNGN;
        $symbols = $this->symbols;

        // Available balance in user's currency
        $balance = $user->affiliate_balance / $toNGN[$userCurrency];

        // Fixed fee (in NGN, displayed in user currency)
        $withdrawalFee = 100; // NGN

        // Check for any pending withdrawal
        $hasPending = Withdrawal::where('user_id', $user->id)
            ->where('status', 'pending')
            ->exists();

        // User's saved bank accounts
        $savedAccounts = UserBankAccount::where('user_id', $user->id)->get();

        // Selected account from query string (if any)
        $selectedAccountId = $request->get('account_id');

        // If an account is selected, load it; otherwise try the default account
        if ($selectedAccountId) {
            $bankDetails = UserBankAccount::where('user_id', $user->id)->find($selectedAccountId);
        } else {
            $bankDetails = UserBankAccount::where('user_id', $user->id)->where('is_default', true)->first();
        }

        // If no account exists, provide an empty object to avoid undefined property errors
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

        // Fetch all withdrawal requests from the withdrawals table
        $withdrawals = Withdrawal::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $allWithdrawals = $withdrawals->map(function ($wd) use ($userCurrency, $toNGN, $symbols) {
            $amountInUserCurrency = $wd->amount / $toNGN[$userCurrency];
            $statusText = ucfirst($wd->status);

            // account_details is already cast to array by the model
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

        return view('affiliate.withdrawal', compact(
            'balance',
            'withdrawalFee',
            'bankDetails',
            'savedAccounts',
            'selectedAccountId',
            'allWithdrawals',
            'userCurrency',
            'toNGN',
            'symbols',
            'hasPending',
            'user'        // <-- pass $user for PIN check in Blade
        ));
    }

    /**
     * Store a new withdrawal request.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // 1. Check PIN (if set)
        if (!$user->withdrawal_pin) {
            return back()->withErrors(['pin' => 'Please set a withdrawal PIN first.']);
        }

        $request->validate([
            'pin' => 'required|digits:4',
        ]);

        if (!Hash::check($request->pin, $user->withdrawal_pin)) {
            return back()->withErrors(['pin' => 'The PIN is incorrect.']);
        }

        // 2. Check for existing pending withdrawal
        if (Withdrawal::where('user_id', $user->id)->where('status', 'pending')->exists()) {
            return back()->with('error', 'You already have a pending withdrawal request. Please wait for it to be processed.');
        }

        // 3. Validate the rest
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

        // Check if affiliate balance is sufficient (will be deducted later upon approval)
        if ($user->affiliate_balance < $totalDeduction) {
            return back()->with('error', 'Insufficient affiliate balance.');
        }

        DB::transaction(function () use ($user, $amountInNGN, $feeInNGN, $totalDeduction, $amount, $userCurrency, $request) {
            // Handle bank account (update, reuse, or create) – existing logic unchanged
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

            // Create transaction record with status 'pending'
            $oldBalance = $user->affiliate_balance;
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'type' => 'withdrawal',
                'amount' => $amountInNGN,
                'currency' => 'NGN',
                'balance_type' => 'affiliate',
                'balance_before' => $oldBalance,
                'balance_after' => $oldBalance,
                'description' => "Withdrawal request (pending approval) to " . ($request->account_type == 'bank' ? 'bank' : 'mobile money'),
                'reference' => 'WD_' . uniqid(),
                'payment_gateway' => null,
                'status' => 'pending',
                'meta' => [
                    'user_currency' => $userCurrency,
                    'user_amount' => $amount,
                    'fee' => $feeInNGN,
                    'account_details' => $request->only(['account_type', 'bank_name', 'account_name', 'account_number', 'momo_provider', 'momo_number']),
                ],
            ]);

            // Create withdrawal record for admin tracking
            Withdrawal::create([
                'user_id' => $user->id,
                'type' => 'affiliate',
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

        return redirect()->route('affiliate.withdrawals')->with('success', 'Withdrawal request submitted successfully. It will be processed within 24 hours.');
    }

    /**
     * Show form to set withdrawal PIN.
     */
    public function setPinForm()
    {
        return view('affiliate.set_pin');
    }

    /**
     * Store the new PIN.
     */
    public function storePin(Request $request)
    {
        $request->validate([
            'pin' => 'required|digits:4|confirmed',
        ]);

        $user = Auth::user();
        $user->withdrawal_pin = Hash::make($request->pin);
        $user->save();

        return redirect()->route('affiliate.withdrawals')->with('success', 'PIN set successfully. You can now withdraw.');
    }
}