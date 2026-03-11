<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['product', 'affiliate', 'vendor']);

        // Optional filter by status
        if ($request->has('status') && in_array($request->status, ['pending', 'completed', 'failed'])) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->get();

        return view('admin.orders.index', compact('orders'));
    }
}