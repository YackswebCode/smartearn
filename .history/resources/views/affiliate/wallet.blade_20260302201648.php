@extends('layouts.affiliate')

@section('title', 'Wallet')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Wallet</h2>
    </div>

    <!-- Two Balance Cards -->
    <div class="row mb-4">
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm bg-success text-white">
                <div class="card-body">
                    <h5 class="fw-semibold">Wallet Balance (Funds)</h5>
                    <h1 class="display-4 fw-bold">{{ $symbols[$userCurrency] }}{{ number_format($walletBalance, 2) }}</h1>
                    <p class="mb-0">Money you've added</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm bg-info text-white">
                <div class="card-body">
                    <h5 class="fw-semibold">Affiliate Balance (Earnings)</h5>
                    <h1 class="display-4 fw-bold">{{ $symbols[$userCurrency] }}{{ number_format($affiliateBalance, 2) }}</h1>
                    <p class="mb-0">Commissions earned</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mb-4">
        <a href="{{ route('affiliate.add_funds') }}" class="btn btn-success me-2">Add Funds</a>
        <a href="{{ route('affiliate.withdrawals') }}" class="btn btn-outline-success">Withdraw from Affiliate Balance</a>
    </div>

    <!-- Filters & Transactions Table (unchanged) -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Search</label>
                    <input type="text" class="form-control" id="searchInput" placeholder="Search transactions">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">From</label>
                    <input type="date" class="form-control" id="fromDate">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">To</label>
                    <input type="date" class="form-control" id="toDate">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Type</label>
                    <select class="form-select" id="typeFilter">
                        <option value="">All</option>
                        <option value="Funding">Funding</option>
                        <option value="Withdrawal">Withdrawal</option>
                        <option value="Commission">Commission</option>
                        <option value="Purchase">Purchase</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button class="btn btn-success w-100" id="applyFilters">Apply Filters</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="transactions-table" class="table table-hover align-middle">
                    <thead class="table-success">
                        <tr>
                            <th>Currency</th>
                            <th>Amount</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $tx)
                        <tr>
                            <td>{{ $tx['currency'] }}</td>
                            <td class="{{ $tx['amount'] < 0 ? 'text-danger' : 'text-success' }}">
                                {{ $tx['amount'] < 0 ? '-' : '+' }}{{ $symbols[$userCurrency] }}{{ number_format(abs($tx['amount']), 2) }}
                            </td>
                            <td>{{ $tx['type'] }}</td>
                            <td>{{ $tx['description'] }}</td>
                            <td>{{ $tx['date'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    var table = $('#transactions-table').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        pageLength: 10,
        lengthChange: false,
        autoWidth: false,
        scrollX: true,
        language: {
            paginate: { previous: "Previous", next: "Next" }
        }
    });

    $('#searchInput').on('keyup', function() {
        table.search(this.value).draw();
    });

    $('#applyFilters').on('click', function() {
        var type = $('#typeFilter').val();
        // Simple column search for type (column index 2)
        table.column(2).search(type).draw();
    });
});
</script>
@endpush