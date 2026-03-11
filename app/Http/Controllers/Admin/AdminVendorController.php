<?php
// app/Http/Controllers/Admin/AdminVendorController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminVendorController extends Controller
{
    public function index(Request $request)
    {
        $query = User::whereIn('vendor_status', ['Pending', 'Active', 'Reject']);

        if ($request->has('status') && in_array($request->status, ['Pending', 'Active', 'Reject'])) {
            $query->where('vendor_status', $request->status);
        }

        // Eager load product count for each vendor
        $vendors = $query->withCount('products')->latest()->get();

        return view('admin.vendors.index', compact('vendors'));
    }

    public function show($id)
    {
        $vendor = User::whereIn('vendor_status', ['Pending', 'Active', 'Reject'])
            ->withCount('products', 'orders') // load counts for stats
            ->findOrFail($id);

        $products = Product::where('vendor_id', $vendor->id)->latest()->take(10)->get();
        $orders = Order::where('vendor_id', $vendor->id)
            ->where('status', 'completed')
            ->latest()
            ->take(10)
            ->get();
        $totalSales = Order::where('vendor_id', $vendor->id)
            ->where('status', 'completed')
            ->sum('amount');
        $totalEarnings = Order::where('vendor_id', $vendor->id)
            ->where('status', 'completed')
            ->sum('vendor_earnings');

        return view('admin.vendors.show', compact('vendor', 'products', 'orders', 'totalSales', 'totalEarnings'));
    }

    public function approve($id)
    {
        $vendor = User::where('vendor_status', 'Pending')->findOrFail($id);
        $vendor->vendor_status = 'Active';
        $vendor->save();

        return redirect()->route('admin.vendors.index')
            ->with('success', 'Vendor approved successfully.');
    }

    public function reject(Request $request, $id)
    {
        $vendor = User::where('vendor_status', 'Pending')->findOrFail($id);
        $vendor->vendor_status = 'Reject';
        $vendor->save();

        return redirect()->route('admin.vendors.index')
            ->with('success', 'Vendor application rejected.');
    }
}