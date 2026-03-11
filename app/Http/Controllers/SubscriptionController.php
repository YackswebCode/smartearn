<?php
// app/Http/Controllers/SubscriptionController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SubscriptionController extends Controller
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

    public function showPaymentForm()
    {
        $email = session('email');
        if (!$email) {
            return redirect()->route('register')
                ->withErrors(['email' => 'Session expired. Please register again.']);
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()->route('register')
                ->withErrors(['email' => 'User not found.']);
        }

        return view('subscription.pay', [
            'user' => $user,
            'toNGN' => $this->toNGN,
            'symbols' => $this->symbols,
        ]);
    }

    public function verifyPayment(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required',
            'reference'      => 'required',
            'amount'         => 'required|numeric',
            'currency'       => 'required|string',
            'buyer_name'     => 'required|string',
            'buyer_email'    => 'required|email',
        ]);

        $user = User::where('email', $request->buyer_email)->first();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found.']);
        }

        // In production, verify the transaction with Flutterwave API here
        // For this example, we assume it's valid.

        // Activate marketplace subscription and mark activation as paid
        $user->marketplace_subscribed = true;
        $user->subscription_expires_at = now()->addYear();
        $user->activation_paid = true; // <-- new column
        $user->save();

        return response()->json([
            'success'  => true,
            'redirect' => route('login'),
            'message'  => 'Payment successful! You can now log in.'
        ]);
    }
}