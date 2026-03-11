<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Withdrawal;
use App\Models\Faculty;
use App\Models\Track;
use App\Models\Lecture;
use App\Models\Enrollment;
use App\Models\BusinessFaculty;
use App\Models\BusinessCourse;
use App\Models\BusinessLecture;
use App\Models\BusinessEnrollment;
use App\Models\Commission;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    protected $toNGN = [
        'NGN' => 1,
        'USD' => 1363.33,
        'GHS' => 127.81,
        'XAF' => 2.45,
        'KES' => 10.56,
    ];

    public function index()
    {
        // Basic counts
        $totalUsers = User::count();
        $totalVendors = User::where('vendor_status', 'Active')->count();
        $pendingVendors = User::where('vendor_status', 'Pending')->count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $pendingWithdrawals = Withdrawal::where('status', 'pending')->count();

        // Process completed orders for revenue and sales volume
        $completedOrders = Order::where('status', 'completed')->get();
        $totalRevenueNGN = 0;
        $salesVolume = []; // per currency original amounts

        foreach ($completedOrders as $order) {
            $rate = $this->toNGN[$order->currency] ?? 1;
            $totalRevenueNGN += $order->vendor_earnings * $rate;
            $salesVolume[$order->currency] = ($salesVolume[$order->currency] ?? 0) + $order->amount;
        }

        // Process commissions
        $affiliateCommissionNGN = 0;
        $vendorCommissionNGN = 0;
        $commissions = Commission::all();

        foreach ($commissions as $c) {
            $rate = $this->toNGN[$c->currency] ?? 1;
            $amountNGN = $c->amount * $rate;
            if ($c->type === 'affiliate') {
                $affiliateCommissionNGN += $amountNGN;
            } else {
                $vendorCommissionNGN += $amountNGN;
            }
        }

        // Skill Garage stats
        $totalFaculties = Faculty::count();
        $totalTracks = Track::count();
        $totalLectures = Lecture::count();
        $totalEnrollments = Enrollment::count();

        // Business University stats
        $totalBusinessFaculties = BusinessFaculty::count();
        $totalBusinessCourses = BusinessCourse::count();
        $totalBusinessLectures = BusinessLecture::count();
        $totalBusinessEnrollments = BusinessEnrollment::count();

        // Recent orders and users
        $recentOrders = Order::with('product', 'affiliate', 'vendor')
            ->latest()
            ->take(5)
            ->get();

        $recentUsers = User::latest()
            ->take(5)
            ->get();

        return view('admin.dashboard.index', compact(
            'totalUsers',
            'totalVendors',
            'pendingVendors',
            'totalProducts',
            'totalOrders',
            'pendingWithdrawals',
            'totalRevenueNGN',
            'salesVolume',
            'affiliateCommissionNGN',
            'vendorCommissionNGN',
            'totalFaculties',
            'totalTracks',
            'totalLectures',
            'totalEnrollments',
            'totalBusinessFaculties',
            'totalBusinessCourses',
            'totalBusinessLectures',
            'totalBusinessEnrollments',
            'recentOrders',
            'recentUsers'
        ));
    }
}