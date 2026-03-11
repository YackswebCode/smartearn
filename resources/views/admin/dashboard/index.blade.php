@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Admin Dashboard</h2>
    </div>

    <!-- Row 1: Core Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-3 p-3 me-3">
                            <i class="fas fa-users fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Total Users</h6>
                            <h3 class="fw-bold mb-0">{{ number_format($totalUsers) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 rounded-3 p-3 me-3">
                            <i class="fas fa-store fa-2x text-success"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Active Vendors</h6>
                            <h3 class="fw-bold mb-0">{{ number_format($totalVendors) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 rounded-3 p-3 me-3">
                            <i class="fas fa-clock fa-2x text-warning"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Pending Vendors</h6>
                            <h3 class="fw-bold mb-0">{{ number_format($pendingVendors) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-info bg-opacity-10 rounded-3 p-3 me-3">
                            <i class="fas fa-box fa-2x text-info"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Total Products</h6>
                            <h3 class="fw-bold mb-0">{{ number_format($totalProducts) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-secondary bg-opacity-10 rounded-3 p-3 me-3">
                            <i class="fas fa-shopping-cart fa-2x text-secondary"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Total Orders</h6>
                            <h3 class="fw-bold mb-0">{{ number_format($totalOrders) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-danger bg-opacity-10 rounded-3 p-3 me-3">
                            <i class="fas fa-money-bill-wave fa-2x text-danger"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Pending Withdrawals</h6>
                            <h3 class="fw-bold mb-0">{{ number_format($pendingWithdrawals) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 rounded-3 p-3 me-3">
                            <i class="fas fa-chart-line fa-2x text-success"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Total Revenue (NGN)</h6>
                            <h3 class="fw-bold mb-0">₦{{ number_format($totalRevenueNGN, 2) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: Sales Volume per Currency -->
    <div class="row g-3 mb-4">
        @php
            $currencies = ['NGN' => '₦', 'USD' => '$', 'GHS' => 'GH¢', 'XAF' => 'FCFA', 'KES' => 'KES'];
        @endphp
        @foreach($currencies as $code => $symbol)
        <div class="col-md-2-4 col-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted mb-1">Sales Volume ({{ $code }})</h6>
                    <h4 class="fw-bold mb-0">{{ $symbol }}{{ number_format($salesVolume[$code] ?? 0, 2) }}</h4>
                    <small class="text-muted">From completed orders</small>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Row 3: Skill Garage & Business University -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Skill Garage</h5>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="p-3 bg-light rounded-3 text-center">
                                <h6 class="text-muted mb-1">Faculties</h6>
                                <h3 class="fw-bold mb-0">{{ number_format($totalFaculties) }}</h3>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-light rounded-3 text-center">
                                <h6 class="text-muted mb-1">Tracks</h6>
                                <h3 class="fw-bold mb-0">{{ number_format($totalTracks) }}</h3>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-light rounded-3 text-center">
                                <h6 class="text-muted mb-1">Lectures</h6>
                                <h3 class="fw-bold mb-0">{{ number_format($totalLectures) }}</h3>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-light rounded-3 text-center">
                                <h6 class="text-muted mb-1">Enrollments</h6>
                                <h3 class="fw-bold mb-0">{{ number_format($totalEnrollments) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Business University</h5>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="p-3 bg-light rounded-3 text-center">
                                <h6 class="text-muted mb-1">Faculties</h6>
                                <h3 class="fw-bold mb-0">{{ number_format($totalBusinessFaculties) }}</h3>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-light rounded-3 text-center">
                                <h6 class="text-muted mb-1">Courses</h6>
                                <h3 class="fw-bold mb-0">{{ number_format($totalBusinessCourses) }}</h3>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-light rounded-3 text-center">
                                <h6 class="text-muted mb-1">Lectures</h6>
                                <h3 class="fw-bold mb-0">{{ number_format($totalBusinessLectures) }}</h3>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-light rounded-3 text-center">
                                <h6 class="text-muted mb-1">Enrollments</h6>
                                <h3 class="fw-bold mb-0">{{ number_format($totalBusinessEnrollments) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 4: Recent Orders Table (unchanged) -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Recent Orders</h5>
            <a href="#" class="btn btn-sm btn-outline-success">View All</a>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Reference</th>
                        <th>Product</th>
                        <th>Buyer</th>
                        <th>Affiliate</th>
                        <th>Vendor</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                    <tr>
                        <td>{{ $order->reference }}</td>
                        <td>{{ $order->product->name ?? 'N/A' }}</td>
                        <td>{{ $order->buyer_name }}</td>
                        <td>{{ $order->affiliate->name ?? 'N/A' }}</td>
                        <td>{{ $order->vendor->name ?? 'N/A' }}</td>
                        <td>{{ $order->currency }} {{ number_format($order->amount, 2) }}</td>
                        <td><span class="badge bg-success">{{ $order->status }}</span></td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Row 5: Recent Users Table (unchanged) -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Recent Users</h5>
            <a href="#" class="btn btn-sm btn-outline-success">View All</a>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentUsers as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->vendor_status === 'Active')
                                Vendor
                            @elseif($user->vendor_status === 'Pending')
                                Pending Vendor
                            @else
                                Affiliate
                            @endif
                        </td>
                        <td>
                            @if($user->activation_paid)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-warning">Inactive</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .col-md-2-4 {
        flex: 0 0 auto;
        width: 20%;
    }
    @media (max-width: 768px) {
        .col-md-2-4 {
            width: 50%;
        }
    }
</style>
@endpush