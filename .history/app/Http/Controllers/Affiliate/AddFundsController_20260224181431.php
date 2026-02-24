<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AddFundsController extends Controller
{
    /**
     * Display the add funds page.
     */
    public function index()
    {
        // Dummy data – replace with actual data from database
        $balance = 10.00; // $10 available

        // Dummy funding transactions (credit entries)
        $transactions = [
            ['currency' => 'NGN', 'amount' => 5000.00, 'type' => 'Credit', 'description' => 'Added via Bank Transfer', 'date' => 'Jan 15 2024, 2:30PM'],
            ['currency' => 'NGN', 'amount' => 2000.00, 'type' => 'Credit', 'description' => 'Added via Card Payment', 'date' => 'Jan 10 2024, 10:15AM'],
            ['currency' => 'USD', 'amount' => 50.00, 'type' => 'Credit', 'description' => 'PayPal deposit', 'date' => 'Jan 5 2024, 8:45PM'],
            ['currency' => 'NGN', 'amount' => 10000.00, 'type' => 'Credit', 'description' => 'Bank Transfer', 'date' => 'Dec 28 2023, 11:20AM'],
        ];

        return view('affiliate.add_funds', compact('balance', 'transactions'));
    }
}