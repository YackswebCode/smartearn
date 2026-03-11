@extends('layouts.vendor')

@section('title', 'Orders & Sales')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Orders & Sales</h2>
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

    <!-- Total Volume NGN -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="text-muted mb-0">Total Volume (NGN)</h6>
                    <span class="badge bg-success">{{ $volumeChange }}</span>
                </div>
                <h3 class="fw-bold">₦{{ number_format($volumeNGN, 2) }}</h3>
                <small class="text-muted">vs last period</small>
            </div>
        </div>
    </div>

    <!-- Total Volume USD -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="text-muted mb-0">Total Volume (USD)</h6>
                    <span class="badge bg-success">{{ $volumeChange }}</span>
                </div>
                <h3 class="fw-bold">${{ number_format($volumeUSD, 2) }}</h3>
                <small class="text-muted">vs last period</small>
            </div>
        </div>
    </div>

    <!-- Total Volume GHS -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="text-muted mb-0">Total Volume (GHS)</h6>
                    <span class="badge bg-success">{{ $volumeChange }}</span>
                </div>
                <h3 class="fw-bold">GH¢{{ number_format($volumeGHS, 2) }}</h3>
                <small class="text-muted">vs last period</small>
            </div>
        </div>
    </div>

    <!-- Total Volume XAF -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="text-muted mb-0">Total Volume (XAF)</h6>
                    <span class="badge bg-success">{{ $volumeChange }}</span>
                </div>
                <h3 class="fw-bold">FCFA{{ number_format($volumeXAF, 2) }}</h3>
                <small class="text-muted">vs last period</small>
            </div>
        </div>
    </div>

    <!-- Total Volume KES -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="text-muted mb-0">Total Volume (KES)</h6>
                    <span class="badge bg-success">{{ $volumeChange }}</span>
                </div>
                <h3 class="fw-bold">KES{{ number_format($volumeKES, 2) }}</h3>
                <small class="text-muted">vs last period</small>
            </div>
        </div>
    </div>
</div>

    <!-- Orders Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">All Orders</h5>
            <small class="text-muted">Complete list of transactions</small>
        </div>
        <div class="card-body p-3">
            <table id="ordersTable" class="table table-hover align-middle nowrap" style="width:100%">
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
                    @forelse($ordersList as $order)
                    <tr>
                        <td>{{ $order->product_type }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td>{{ $order->customer_email }}</td>
                        <td>{{ $order->reference }}</td>
                        <td>{{ $order->date->format('Y-m-d H:i') }}</td>
                        <td>{{ $order->amount_formatted }}</td>
                        <td>{{ $order->affiliate_name }}</td>
                        <td>{{ $order->affiliate_email }}</td>
                        <td>{{ $order->commission_formatted }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">No orders found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        new DataTable('#ordersTable', {
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
                emptyTable: "No orders found"
            }
        });
    });
</script>
@endpush