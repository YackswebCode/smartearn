<?php
// app/Http/Controllers/Admin/AdminWithdrawalController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use App\Models\Transaction;
use App\Mail\WithdrawalApprovedMail;
use App\Mail\WithdrawalRejectedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class AdminWithdrawalController extends Controller
{
    public function index(Request $request)
    {
        $query = Withdrawal::with('user');

        if ($request->has('status') && in_array($request->status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $request->status);
        }

        $withdrawals = $query->latest()->get();

        return view('admin.withdrawals.index', compact('withdrawals'));
    }

    public function show($id)
    {
        $withdrawal = Withdrawal::with('user')->findOrFail($id);
        return view('admin.withdrawals.show', compact('withdrawal'));
    }

    public function approve(Request $request, $id)
    {
        $withdrawal = Withdrawal::where('status', 'pending')->findOrFail($id);

        DB::transaction(function () use ($withdrawal) {
            $user = $withdrawal->user;

            // Deduct from the appropriate balance
            if ($withdrawal->type === 'affiliate') {
                $user->affiliate_balance -= $withdrawal->amount;
            } else { // vendor
                $user->vendor_balance -= $withdrawal->amount;
            }
            $user->save();

            // Update the linked transaction if it exists and is still pending
            if ($withdrawal->transaction_id) {
                $transaction = Transaction::find($withdrawal->transaction_id);
                if ($transaction && $transaction->status === 'pending') {
                    $transaction->status = 'completed';
                    // Update balance_after to the new balance after deduction
                    if ($withdrawal->type === 'affiliate') {
                        $transaction->balance_after = $user->affiliate_balance;
                    } else {
                        $transaction->balance_after = $user->vendor_balance;
                    }
                    $transaction->save();
                }
            }

            $withdrawal->status = 'approved';
            $withdrawal->processed_at = now();
            $withdrawal->save();
        });

        // Send email
        Mail::to($withdrawal->user->email)->send(new WithdrawalApprovedMail($withdrawal));

        return redirect()->route('admin.withdrawals.index')
            ->with('success', 'Withdrawal approved successfully.');
    }

    public function reject(Request $request, $id)
    {
        $withdrawal = Withdrawal::where('status', 'pending')->findOrFail($id);

        $request->validate([
            'admin_note' => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use ($withdrawal, $request) {
            // Update the linked transaction if it exists and is still pending
            if ($withdrawal->transaction_id) {
                $transaction = Transaction::find($withdrawal->transaction_id);
                if ($transaction && $transaction->status === 'pending') {
                    $transaction->status = 'failed';
                    // Optionally, you could add a note to meta, but not required
                    $transaction->save();
                }
            }

            $withdrawal->status = 'rejected';
            $withdrawal->admin_note = $request->admin_note;
            $withdrawal->processed_at = now();
            $withdrawal->save();
        });

        // Send email
        Mail::to($withdrawal->user->email)->send(new WithdrawalRejectedMail($withdrawal, $request->admin_note));

        return redirect()->route('admin.withdrawals.index')
            ->with('success', 'Withdrawal rejected.');
    }
}