<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    /**
     * Display the withdrawal page.
     */
    public function index()
    {
        // Dummy data – replace with actual data from database
        $balance = 10.00; // $10 available
        $bankDetails = [
            'bank'   => 'First Bank PLC',
            'account' => '3143061985',
            'name'    => 'AWONUSI TEMITOPE'
        ];
        $withdrawalFee = 50; // NGN 50

        // Dummy transaction history (withdrawals)
        $transactions = [
            ['currency' => 'NGN', 'amount' => -50.00, 'type' => 'Debit', 'description' => 'Withdrawal Fee', 'date' => 'Jan 16 2024, 8:16PM'],
            ['currency' => 'NGN', 'amount' => -50.00, 'type' => 'Debit', 'description' => 'Withdrawal Fee', 'date' => 'Jan 16 2024, 8:16PM'],
            ['currency' => 'NGN', 'amount' => -50.00, 'type' => 'Debit', 'description' => 'Withdrawal Fee', 'date' => 'Jan 16 2024, 8:16PM'],
            ['currency' => 'NGN', 'amount' => -50.00, 'type' => 'Debit', 'description' => 'Withdrawal Fee', 'date' => 'Jan 16 2024, 8:16PM'],
            ['currency' => 'NGN', 'amount' => -50.00, 'type' => 'Debit', 'description' => 'Withdrawal Fee', 'date' => 'Jan 16 2024, 8:16PM'],
            ['currency' => 'NGN', 'amount' => -50.00, 'type' => 'Debit', 'description' => 'Withdrawal Fee', 'date' => 'Jan 16 2024, 8:16PM'],
        ];

        return view('affiliate.withdrawal', compact('balance', 'bankDetails', 'withdrawalFee', 'transactions'));
    }
}