@extends('layouts.customer')

@section('title', 'Customer Dashboard')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Dashboard</h2>
            <p class="text-muted">Welcome back, {{ Auth::user()->name }}!</p>
        </div>
      
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-5">
        <!-- All Purchases -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">All Purchases</span>
                        <i class="fas fa-shopping-bag text-success fa-2x"></i>
                    </div>
                    <h3 class="fw-bold">{{ $allPurchasesCount }}</h3>
                    <a href="{{ route('customer.purchases') }}" class="text-decoration-none small">View details →</a>
                </div>
            </div>
        </div>

        <!-- Total Investment -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Total Investment</span>
                        <i class="fas fa-coins text-warning fa-2x"></i>
                    </div>
                    <h3 class="fw-bold">{{ $currencySymbol }}{{ number_format($totalInvestment, 2) }}</h3>
                    @if($investmentByCurrency && $investmentByCurrency->count() > 1)
                        <div class="small text-muted">
                            @foreach($investmentByCurrency as $currency => $amount)
                                {{ $currency }} {{ number_format($amount, 2) }}<br>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Link to Edit Profile -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 bg-light">
                <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                    <i class="fas fa-user-circle fa-3x text-success mb-2"></i>
                    <p class="fw-semibold mb-0">Update Your Profile</p>
                    <a href="{{ route('affiliate.edit_profile') }}" class="btn btn-success btn-sm mt-2">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Purchases -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0">Recent Purchases</h5>
            <a href="{{ route('customer.purchases') }}" class="btn btn-outline-success btn-sm">See All</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Product / Track</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                   <tbody>
    @forelse($recentPurchases as $purchase)
        <tr>
            <td>{{ $purchase->created_at->format('M d, Y') }}</td>
            <td>{{ $purchase->track->title ?? 'N/A' }}</td>
            <td>{{ $purchase->currency }} {{ number_format($purchase->amount_paid, 2) }}</td>
            <td><span class="badge bg-success">{{ ucfirst($purchase->plan) }}</span></td>
            <td>
                <a href="{{ route('affiliate.digital.my.learning') }}" class="text-success small">
                    <i class="fas fa-eye"></i> View
                </a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="text-center py-3 text-muted">No purchases yet.</td>
        </tr>
    @endforelse
</tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection