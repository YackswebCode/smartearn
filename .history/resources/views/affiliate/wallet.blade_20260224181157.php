@extends('layouts.affiliate')

@section('title', 'Wallet')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Wallet</h2>
    </div>

    <!-- Balance Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="display-4 fw-bold">${{ number_format($balance, 2) }}</h1>
                    <p class="text-muted mb-0">{{ $available }}</p>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <a href="#" class="btn btn-success me-2">Withdraw</a>
                    <a href="#" class="btn btn-outline-success">Add Funds</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Search</label>
                    <input type="text" class="form-control" id="searchInput" placeholder="Search transactions">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">From</label>
                    <input type="date" class="form-control" id="fromDate" placeholder="mm/dd/yyyy">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">To</label>
                    <input type="date" class="form-control" id="toDate" placeholder="mm/dd/yyyy">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Currency</label>
                    <select class="form-select" id="currencyFilter">
                        <option selected>All Currencies</option>
                        <option value="NGN">NGN</option>
                        <option value="USD">USD</option>
                        <option value="EUR">EUR</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button class="btn btn-success w-100" id="applyFilters">Apply Filters</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="transactions-table" class="table table-hover align-middle">
                    <thead class="table-light">
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
                                {{ $tx['amount'] < 0 ? '-' : '+' }}${{ number_format(abs($tx['amount']), 2) }}
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
        // Initialize DataTable
        var table = $('#transactions-table').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            lengthChange: true,
            pageLength: 10,
            scrollX: true,        // Enables horizontal scrolling on small screens
            responsive: false,     // scrollX is used instead of responsive
            language: {
                paginate: {
                    previous: "Previous",
                    next: "Next"
                }
            },
            columnDefs: [
                { orderable: false, targets: [] } // all columns sortable
            ]
        });

        // Optional: connect the external search filter to DataTable's search
        $('#searchInput').on('keyup', function() {
            table.search(this.value).draw();
        });

        // Optional: you can also implement custom filters for date range and currency
        // For simplicity, we'll just leave the filters as UI placeholders.
        // To fully integrate them, you'd need to use DataTable's column().search() or custom filtering.
        $('#applyFilters').on('click', function() {
            // Example: filter by currency (simple column search)
            var currency = $('#currencyFilter').val();
            if (currency && currency !== 'All Currencies') {
                table.column(0).search(currency).draw();
            } else {
                table.column(0).search('').draw();
            }

            // Date range filtering would require a custom filter function.
            // For brevity, not implemented here, but can be added if needed.
        });
    });
</script>
@endpush