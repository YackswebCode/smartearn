{{-- resources/views/affiliate/dashboard.blade.php --}}
@extends('layouts.affiliate')

@section('title', 'Affiliate Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2>Affiliate Dashboard</h2>
    </div>
</div>

<!-- First row: multi-currency volumes (Single Horizontal Card) -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header" style="background-color:#48BB78; color:white; font-weight:600;">
                Sales & Volume Overview
            </div>
            <div class="card-body p-3">
                <div class="metrics-scroll d-flex">
                    <div class="metric-item">
                        <small style="color:#48BB78;">No of sales</small>
                        <h4>{{ $salesCount }}</h4>
                    </div>
                    <div class="metric-item">
                        <small style="color:#48BB78;">Total Volume (NGN)</small>
                        <h4>₦{{ number_format($totalVolumeNGN, 2) }}</h4>
                    </div>
                    <div class="metric-item">
                        <small style="color:#48BB78;">Total Volume (USD)</small>
                        <h4>${{ number_format($totalVolumeUSD, 2) }}</h4>
                    </div>
                    <div class="metric-item">
                        <small style="color:#48BB78;">Total Volume (GHS)</small>
                        <h4>GH¢{{ number_format($totalVolumeGHS, 2) }}</h4>
                    </div>
                    <div class="metric-item">
                        <small style="color:#48BB78;">Total Volume (XAF)</small>
                        <h4>FCFA{{ number_format($totalVolumeXAF, 2) }}</h4>
                    </div>
                    <div class="metric-item">
                        <small style="color:#48BB78;">Total Volume (KES)</small>
                        <h4>KES{{ number_format($totalVolumeKES, 2) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Second row: additional stats (converted to user's currency) -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-header bg-white border-0" style="color:#48BB78; font-weight:600;">
                <i class="fas fa-shopping-cart me-2"></i>No of sales
            </div>
            <div class="card-body">
                <h2>{{ $salesCount }}</h2>
                <small class="text-muted">Updated Few minutes ago</small>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-header bg-white border-0" style="color:#48BB78; font-weight:600;">
                <i class="fas fa-chart-line me-2"></i>Total Volume ({{ $userCurrency }})
            </div>
            <div class="card-body">
                <h2>{{ $symbols[$userCurrency] }}{{ number_format($totalVolumeUserCurrency, 2) }}</h2>
                <small class="text-muted">Updated Few minutes ago</small>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-header bg-white border-0" style="color:#48BB78; font-weight:600;">
                <i class="fas fa-wallet me-2"></i>Total Withdrawal ({{ $userCurrency }})
            </div>
            <div class="card-body">
                <h2>{{ $symbols[$userCurrency] }}{{ number_format($totalWithdrawnUserCurrency, 2) }}</h2>
                <small class="text-muted">Updated Few minutes ago</small>
            </div>
        </div>
    </div>
</div>

<!-- Third row: earnings (converted to user's currency) -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-header bg-white border-0" style="color:#48BB78; font-weight:600;">
                <i class="fas fa-coins me-2"></i>Overall Affiliate Earning ({{ $userCurrency }})
            </div>
            <div class="card-body">
                <h2>{{ $symbols[$userCurrency] }}{{ number_format($overallEarningUserCurrency, 2) }}</h2>
                <small class="text-muted">Updated Few minutes ago</small>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-header bg-white border-0" style="color:#48BB78; font-weight:600;">
                <i class="fas fa-dollar me-2"></i>Today Affiliate Earning ({{ $userCurrency }})
            </div>
            <div class="card-body">
                <h2>{{ $symbols[$userCurrency] }}{{ number_format($todayEarningUserCurrency, 2) }}</h2>
                <small class="text-muted">Updated Few minutes ago</small>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-header bg-white border-0" style="color:#48BB78; font-weight:600;">
                <i class="fas fa-bolt me-2"></i>Today Sales
            </div>
            <div class="card-body">
                <h2>{{ $todaySalesCount }}</h2>
                <small class="text-muted">Updated Few minutes ago</small>
            </div>
        </div>
    </div>
</div>

<!-- Recent Transactions Table (unchanged, amounts in NGN for simplicity) -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0">Recent Transaction</h5>
    </div>
    <div class="card-body p-3">
        <table id="transactionsTable" class="table table-hover align-middle mb-0 nowrap" style="width:100%">
            <thead class="table-dark">
                <tr>
                    <th>Product(s)</th>
                    <th>Customer Full Name</th>
                    <th>Customer Email</th>
                    <th>Reference</th>
                    <th>Transaction Date</th>
                    <th>Total ({{ $userCurrency }})</th>
                    <th>Affiliate Name</th>
                    <th>Affiliate Mail</th>
                    <th>Commission ({{ $userCurrency }})</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentTransactions as $transaction)
                <tr>
                    <td>{{ $transaction->product_name }}</td>
                    <td>{{ $transaction->customer_name }}</td>
                    <td>{{ $transaction->customer_email }}</td>
                    <td>{{ $transaction->reference }}</td>
                    <td>{{ $transaction->transaction_date->format('M d, Y. h:i A') }}</td>
                    <td>{{ $symbols[$userCurrency] }}{{ number_format($transaction->total / $toNGN[$userCurrency], 2) }}</td>
                    <td>{{ $transaction->affiliate_name }}</td>
                    <td>{{ $transaction->affiliate_email }}</td>
                    <td>{{ $transaction->commission_percent }}%<br>{{ $symbols[$userCurrency] }}{{ number_format($transaction->commission_amount / $toNGN[$userCurrency], 2) }}</td>
                </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    new DataTable('#transactionsTable', {
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
            emptyTable: "No recent transactions"
        }
    });
});
</script>
@endpush
@endsection