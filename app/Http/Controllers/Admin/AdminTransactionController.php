<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with('user');

        // Filter by type
        if ($request->has('type') && in_array($request->type, ['funding', 'withdrawal', 'purchase', 'commission', 'subscription', 'refund'])) {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->has('status') && in_array($request->status, ['pending', 'completed', 'failed'])) {
            $query->where('status', $request->status);
        }

        $transactions = $query->latest()->get();

        return view('admin.transactions.index', compact('transactions'));
    }
}