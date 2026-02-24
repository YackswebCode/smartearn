@extends('layouts.affiliate')

@section('title', 'Add Funds')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Add Funds</h2>
    </div>

    <div class="row">
        <!-- Left Column: Add Funds Form -->
        <div class="col-lg-7 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h4 class="fw-semibold mb-3">Add funds to your wallet</h4>

                    <form method="POST" action="#">
                        @csrf
                        <div class="mb-3">
                            <label for="amount" class="form-label fw-semibold">Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter amount" min="1" step="0.01">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="payment_method" class="form-label fw-semibold">Payment Method</label>
                            <select class="form-select" id="payment_method" name="payment_method">
                                <option selected disabled>Select payment method</option>
                                <option value="card">Credit/Debit Card</option>
                                <option value="bank">Bank Transfer</option>
                                <option value="paypal">PayPal</option>
                            </select>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">Proceed to Payment</button>
                        </div>
                    </form>

                    <hr class="my-4">

                    <p class="text-muted small">
                        <i class="fas fa-info-circle me-1"></i>
                        Funds added to your wallet can be used for purchases and withdrawals. 
                        Processing times may vary by payment method.
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Column: Available Balance -->
        <div class="col-lg-5 mb-4">
            <div class="card border-0 shadow-sm bg-success text-white">
                <div class="card-body text-center p-4">
                    <h5 class="fw-semibold">Current Balance</h5>
                    <h1 class="display-3 fw-bold">${{ number_format($balance, 2) }}</h1>
                    <a href="{{ route('affiliate.wallet') }}" class="btn btn-outline-light mt-3">View Wallet</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Funding Transactions -->
    <div class="mt-4">
        <h4 class="fw-semibold mb-3">Recent Funding Transactions</h4>

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
                                <td class="text-success">
                                    +${{ number_format($tx['amount'], 2) }}
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

        $('#searchInput').on('keyup', function() {
            table.search(this.value).draw();
        });

        $('#applyFilters').on('click', function() {
            var currency = $('#currencyFilter').val();
            if (currency && currency !== 'All Currencies') {
                table.column(0).search(currency).draw();
            } else {
                table.column(0).search('').draw();
            }
        });
    });
</script>
@endpush