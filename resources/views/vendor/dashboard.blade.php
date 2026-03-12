{{-- resources/views/vendor/dashboard.blade.php --}}
@extends('layouts.vendor')

@section('title', 'Vendor Dashboard')

@section('content')

 @php
        $user = Auth::user();
        $displayName = $user->name ?? 'Guest User';
        $email = $user->email ?? 'guest@example.com';
        $firstName = explode(' ', $displayName)[0];
        $initial = strtoupper(substr($displayName, 0, 1));
    @endphp
<div class="container-fluid py-4">
     <div class="col-12 mb-4">
    <h3 class="fw-bold d-block mb-0">Welcome, {{ $firstName }}!</h3>
      <small class="text-muted d-block">
       Today <span style="color: #065754;">{{ now()->format('M d') }}</span>
    </small>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Vendor Dashboard</h2>
    </div>
    <!-- Performance Metrics -->
    <div class="row g-3 mb-4">
        <!-- Number of Sales -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="text-muted mb-0">Number of Sales</h6>
                        <span class="badge bg-success">{{ $salesChange }}</span>
                    </div>
                    <h3 class="fw-bold">{{ number_format($salesCount) }}</h3>
                    <small class="text-muted">vs last period</small>
                </div>
            </div>
        </div>
        <!-- Total Volume (converted to user's currency) -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="text-muted mb-0">Total Volume</h6>
                        <span class="badge bg-success">{{ $volumeChange }}</span>
                    </div>
                    <h3 class="fw-bold">{{ $symbols[$userCurrency] }}{{ number_format($totalVolumeUserCurrency, 2) }}</h3>
                    <small class="text-muted">vs last period</small>
                </div>
            </div>
        </div>
        <!-- Total Withdrawal -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="text-muted mb-0">Total Withdrawal</h6>
                        <span class="badge bg-success">{{ $withdrawalChange }}</span>
                    </div>
                    <h3 class="fw-bold">{{ $symbols[$userCurrency] }}{{ number_format($totalWithdrawnUserCurrency, 2) }}</h3>
                    <small class="text-muted">vs last period</small>
                </div>
            </div>
        </div>
        <!-- Total Vendor Earnings -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="text-muted mb-0">Total Vendor Earnings</h6>
                        <span class="badge bg-success">{{ $earningsChange }}</span>
                    </div>
                    <h3 class="fw-bold">{{ $symbols[$userCurrency] }}{{ number_format($totalEarningsUserCurrency, 2) }}</h3>
                    <small class="text-muted">vs last period</small>
                </div>
            </div>
        </div>
        <!-- Today's Vendor Earnings -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="text-muted mb-0">Today's Vendor Earnings</h6>
                        <span class="badge bg-success">{{ $todayEarningsChange }}</span>
                    </div>
                    <h3 class="fw-bold">{{ $symbols[$userCurrency] }}{{ number_format($todayEarningsUserCurrency, 2) }}</h3>
                    <small class="text-muted">vs last period</small>
                </div>
            </div>
        </div>
        <!-- Total Sales (same as Number of Sales, but can be different if you want) -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="text-muted mb-0">Total Sales</h6>
                        <span class="badge bg-success">{{ $totalSalesChange }}</span>
                    </div>
                    <h3 class="fw-bold">{{ number_format($salesCount) }}</h3>
                    <small class="text-muted">vs last period</small>
                </div>
            </div>
        </div>
    </div>

<!-- Top Performing Products -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold">Top Performing Products</h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            @forelse($topProducts as $index => $product)
            <div class="col-lg-2-4 col-md-4 col-6">
                <div class="border rounded p-3 h-100">
                    <!-- Product Image -->
                    <div class="product-image-wrapper mb-2" style="height: 120px; overflow: hidden; border-radius: 0.5rem;">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-100 h-100" 
                                 style="object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center h-100 text-muted">
                                <i class="fas fa-image fa-2x"></i>
                            </div>
                        @endif
                    </div>
                    
                    <span class="badge {{ $index == 0 ? 'bg-warning text-dark' : 'bg-secondary text-white' }} mb-2">
                        #{{ $index + 1 }} @if($index == 0) 🔥 Popular @endif
                    </span>
                    <h6 class="fw-bold text-truncate">{{ $product->name }}</h6>
                    <div class="d-flex justify-content-between mt-2">
                        <small>Units Sold: <strong>{{ number_format($product->units_sold) }}</strong></small>
                        <small>Revenue: <strong>{{ $symbols[$userCurrency] }}{{ number_format($product->revenue, 2) }}</strong></small>
                    </div>
                    <small class="text-success"><i class="fas fa-arrow-up me-1"></i>Trending Up</small>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-4">
                <p class="text-muted">No products sold yet.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

    <!-- Recent Sales Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Recent Sales</h5>
            <small class="text-muted">Latest transactions from your digital products</small>
        </div>
        <div class="card-body p-3">
            <table id="recentSalesTable" class="table table-hover align-middle nowrap" style="width:100%">
                <thead class="table-dark">
                    <tr>
                        <th>Product Type</th>
                        <th>Customer Name</th>
                        <th>Customer Email</th>
                        <th>Transaction Ref</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Affiliate Name</th>
                        <th>Affiliate Email</th>
                        <th>Commission</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentSales as $sale)
                    <tr>
                        <td>{{ $sale->product_type }}</td>
                        <td>{{ $sale->customer_name }}</td>
                        <td>{{ $sale->customer_email }}</td>
                        <td>{{ $sale->reference }}</td>
                        <td>{{ $sale->date->format('Y-m-d H:i') }}</td>
                        <td>{{ $sale->amount_formatted }}</td>
                        <td>{{ $sale->affiliate_name }}</td>
                        <td>{{ $sale->affiliate_email }}</td>
                        <td>{{ $sale->commission_formatted }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">No recent sales</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .col-lg-2-4 { flex: 0 0 auto; width: 20%; }
    @media (max-width: 992px) { .col-lg-2-4 { width: 50%; } }
    @media (max-width: 576px) { .col-lg-2-4 { width: 100%; } }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        new DataTable('#recentSalesTable', {
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            pageLength: 10,
            lengthChange: false,
            autoWidth: false,
            scrollX: true,
            language: {
                search: "Search:",
                emptyTable: "No recent sales"
            }
        });
    });
</script>
@endpush