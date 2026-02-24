<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    /**
     * Display the wallet page.
     */
    public function index()
    {
        // Dummy transaction data
        $transactions = [
            ['currency' => 'NGN', 'amount' => -50.00, 'type' => 'Debit', 'description' => 'Withdrawal Fee', 'date' => 'Jan 16 2024, 8:16PM'],
            ['currency' => 'NGN', 'amount' => -50.00, 'type' => 'Debit', 'description' => 'Withdrawal Fee', 'date' => 'Jan 16 2024, 8:16PM'],
            ['currency' => 'NGN', 'amount' => -50.00, 'type' => 'Debit', 'description' => 'Withdrawal Fee', 'date' => 'Jan 16 2024, 8:16PM'],
            ['currency' => 'NGN', 'amount' => -50.00, 'type' => 'Debit', 'description' => 'Withdrawal Fee', 'date' => 'Jan 16 2024, 8:16PM'],
            ['currency' => 'NGN', 'amount' => -50.00, 'type' => 'Debit', 'description' => 'Withdrawal Fee', 'date' => 'Jan 16 2024, 8:16PM'],
            ['currency' => 'NGN', 'amount' => -50.00, 'type' => 'Debit', 'description' => 'Withdrawal Fee', 'date' => 'Jan 16 2024, 8:16PM'],
        ];

        $balance = 10.00; // $10
        $available = "Available to withdraw";

        return view('affiliate.wallet', compact('transactions', 'balance', 'available'));
    }
}