@extends('layouts.affiliate')

@section('title', 'Affiliate Dashboard')

@section('content')
    @php
        $user = Auth::user();
        $displayName = $user->name ?? 'Guest User';
        $email = $user->email ?? 'guest@example.com';
        $firstName = explode(' ', $displayName)[0];
        $initial = strtoupper(substr($displayName, 0, 1));
    @endphp

<div class="row mb-4">
    <div class="col-12">
        <h3 class="fw-bold d-block mb-0">Welcome, {{ $firstName }}!</h3>
        <small class="text-muted d-block">
            Today <span style="color: #065754;">{{ now()->format('M d') }}</span>
        </small>
    </div>
    <div class="col-12 mt-3">
        <h2>Affiliate Dashboard</h2>
    </div>
</div>

<!-- 1. Overall Sales (single card) -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0" style="color:#48BB78; font-weight:600;">
                <i class="fas fa-chart-bar me-2"></i>Overall Sales
            </div>
            <div class="card-body text-center">
                <h2 class="display-4 fw-bold">{{ $salesCount }}</h2>
                <p class="text-muted mb-0">Total number of sales you've generated</p>
            </div>
        </div>
    </div>
</div>

<!-- 2. Total Volume in Different Currencies (multi‑currency bar) -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header" style="background-color:#48BB78; color:white; font-weight:600;">
                Sales Volume per Currency
            </div>
            <div class="card-body p-3">
                <div class="metrics-scroll d-flex">
                    <div class="metric-item">
                        <small style="color:#48BB78;">NGN</small>
                        <h4>₦{{ number_format($volumeNGN, 2) }}</h4>
                    </div>
                    <div class="metric-item">
                        <small style="color:#48BB78;">USD</small>
                        <h4>${{ number_format($volumeUSD, 2) }}</h4>
                    </div>
                    <div class="metric-item">
                        <small style="color:#48BB78;">GHS</small>
                        <h4>GH¢{{ number_format($volumeGHS, 2) }}</h4>
                    </div>
                    <div class="metric-item">
                        <small style="color:#48BB78;">XAF</small>
                        <h4>FCFA{{ number_format($volumeXAF, 2) }}</h4>
                    </div>
                    <div class="metric-item">
                        <small style="color:#48BB78;">KES</small>
                        <h4>KES{{ number_format($volumeKES, 2) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 3. Today's Sale, Today's Affiliate Earnings, Overall Affiliate Earnings -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-header bg-white border-0" style="color:#48BB78; font-weight:600;">
                <i class="fas fa-calendar-day me-2"></i>Today's Sale
            </div>
            <div class="card-body">
                <h2>{{ $todaySalesCount }}</h2>
                <small class="text-muted">Number of sales today</small>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-header bg-white border-0" style="color:#48BB78; font-weight:600;">
                <i class="fas fa-coins me-2"></i>Today's Affiliate Earnings ({{ $userCurrency }})
            </div>
            <div class="card-body">
                <h2>{{ $symbols[$userCurrency] }}{{ number_format($todayEarningUserCurrency, 2) }}</h2>
                <small class="text-muted">Earnings today</small>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-header bg-white border-0" style="color:#48BB78; font-weight:600;">
                <i class="fas fa-piggy-bank me-2"></i>Overall Affiliate Earnings ({{ $userCurrency }})
            </div>
            <div class="card-body">
                <h2>{{ $symbols[$userCurrency] }}{{ number_format($overallEarningUserCurrency, 2) }}</h2>
                <small class="text-muted">Total earnings since start</small>
            </div>
        </div>
    </div>
</div>

<!-- 4. Total Withdrawal -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0" style="color:#48BB78; font-weight:600;">
                <i class="fas fa-wallet me-2"></i>Total Withdrawal ({{ $userCurrency }})
            </div>
            <div class="card-body text-center">
                <h2 class="display-5 fw-bold">{{ $symbols[$userCurrency] }}{{ number_format($totalWithdrawnUserCurrency, 2) }}</h2>
                <small class="text-muted">Amount you have withdrawn</small>
            </div>
        </div>
    </div>
</div>

<!-- Recent Transactions (simplified – no affiliate/commission columns) -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0">Recent Transactions</h5>
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
                    <th>Total Sale ({{ $userCurrency }})</th>
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