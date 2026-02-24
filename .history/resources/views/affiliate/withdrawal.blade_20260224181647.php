@extends('layouts.affiliate')

@section('title', 'Withdraw Funds')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Wallet</h2>
    </div>

    <div class="row">
        <!-- Left Column: Withdrawal Form & Bank Info -->
        <div class="col-lg-7 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h4 class="fw-semibold mb-3">Withdraw funds to your account</h4>

                    <!-- Bank Details -->
                    <div class="bg-light p-3 rounded-3 mb-4">
                        <p class="mb-1"><strong>Withdrawal will be paid to:</strong></p>
                        <p class="mb-0">
                            {{ $bankDetails['bank'] }} - 
                            {{ $bankDetails['account'] }} - 
                            {{ $bankDetails['name'] }}
                        </p>
                    </div>

                    <!-- Important Note -->
                    <div class="alert alert-warning py-2 small" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        NB: Withdrawals might take up to 24 hours to reflect in your bank account/mobile money.
                    </div>

                    <!-- Withdrawal Form -->
                    <form method="POST" action="#">
                        @csrf
                        <div class="mb-3">
                            <label for="amount" class="form-label fw-semibold">Amount (NGN)</label>
                            <div class="input-group">
                                <span class="input-group-text">₦</span>
                                <input type="number" class="form-control" id="amount" name="amount" value="0" min="0" step="100">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="text-muted">Withdrawal Fee: <strong>N {{ number_format($withdrawalFee) }}</strong></span>
                            <button type="submit" class="btn btn-success px-5">Withdraw</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Column: Available Balance -->
        <div class="col-lg-5 mb-4">
            <div class="card border-0 shadow-sm bg-success text-white">
                <div class="card-body text-center p-4">
                    <h5 class="fw-semibold">Available to withdraw</h5>
                    <h1 class="display-3 fw-bold">${{ number_format($balance, 2) }}</h1>
                    <a href="{{ route('affiliate.wallet') }}" class="btn btn-outline-light mt-3">View Wallet</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction History Section -->
    <div class="mt-4">
        <h4 class="fw-semibold mb-3">Recent Withdrawals</h4>

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
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable for transaction history
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
                paginate: {
                    previous: "Previous",
                    next: "Next"
                }
            }
        });

        // Connect external search filter
        $('#searchInput').on('keyup', function() {
            table.search(this.value).draw();
        });

        // Apply filters (simple currency filter as example)
        $('#applyFilters').on('click', function() {
            var currency = $('#currencyFilter').val();
            if (currency && currency !== 'All Currencies') {
                table.column(0).search(currency).draw();
            } else {
                table.column(0).search('').draw();
            }
            // Date range filtering can be added similarly if needed.
        });
    });
</script>
@endpush