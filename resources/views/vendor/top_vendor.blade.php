@extends('layouts.vendor')

@section('title', 'Top Vendors')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="mb-4">
        <h2 class="fw-bold">Top Vendors Leaderboard</h2>
        <p class="text-muted">Ranking based on total sales, performance, and earnings</p>
    </div>


    @if($topVendor)
        <!-- #1 Vendor Card -->
        <div class="card border-0 shadow-lg mb-4 overflow-hidden" style="background: linear-gradient(135deg, #065754 0%, #0a8a7a 100%);">
            <div class="card-body p-4 text-white">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="badge bg-warning text-dark px-3 py-2 fs-6">#1 Vendor</span>
                            <span class="badge bg-light text-dark px-3 py-2 fs-6">Top Performer</span>
                        </div>
                        <h2 class="display-5 fw-bold mb-2">{{ $topVendor['vendor']->name }}</h2>
                        <div class="row g-3 mt-2">
                            <div class="col-6 col-md-3">
                                <small>Total Sales</small>
                                <h4>{{ $symbols[$userCurrency] }}{{ number_format($topVendor['total_sales'], 0) }}</h4>
                            </div>
                            <div class="col-6 col-md-3">
                                <small>Earnings</small>
                                <h4>{{ $symbols[$userCurrency] }}{{ number_format($topVendor['total_earnings'], 0) }}</h4>
                            </div>
                            <div class="col-6 col-md-3">
                                <small>Transactions</small>
                                <h4>{{ number_format($topVendor['transactions']) }}</h4>
                            </div>
                            <div class="col-6 col-md-3">
                                <small>Conversion</small>
                                <h4>{{ number_format($topVendor['conversion'], 1) }}%</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-center text-md-end mt-3 mt-md-0">
                        <i class="fas fa-crown fa-5x" style="opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>

       <!-- Rankings Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold">Complete Rankings</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="rankingsTable" class="table table-hover align-middle nowrap" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th>Rank</th>
                        <th>Vendor</th>
                        <th>Sales</th>
                        <th>Earnings</th>
                        <th>Volume*</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rankings as $index => $vendorData)
                    <tr>
                        <td><span class="badge bg-secondary bg-opacity-10 text-dark px-3 py-2">#{{ $index + 2 }}</span></td>
                        <td>
                            <div class="fw-semibold">{{ $vendorData['vendor']->name }}</div>
                            <small class="text-muted">{{ $vendorData['vendor']->business_name ?? '' }}</small>
                        </td>
                        <td>{{ $symbols[$userCurrency] }}{{ number_format($vendorData['total_sales'], 0) }}</td>
                        <td>{{ $symbols[$userCurrency] }}{{ number_format($vendorData['total_earnings'], 0) }}</td>
                        <td>
                            <span class="badge {{ $vendorData['conversion'] >= 10 ? 'bg-success' : ($vendorData['conversion'] >= 5 ? 'bg-warning' : 'bg-secondary') }} bg-opacity-10 text-dark px-3 py-2">
                                {{ number_format($vendorData['conversion'], 1) }}%
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white text-muted small">
        * Volume represents conversion rate (earnings / sales)
    </div>
</div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-trophy fa-4x text-muted mb-3"></i>
            <h4>No active vendors found</h4>
            <p class="text-muted">Once vendors start selling, they will appear here.</p>
        </div>
    @endif
</div>
@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        new DataTable('#rankingsTable', {
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
                emptyTable: "No rankings found"
            }
        });
    });
</script>
@endpush
@endsection