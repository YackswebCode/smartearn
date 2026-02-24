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
                    <input type="text" class="form-control" placeholder="Search transactions">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">From</label>
                    <input type="date" class="form-control" placeholder="mm/dd/yyyy">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">To</label>
                    <input type="date" class="form-control" placeholder="mm/dd/yyyy">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Currency</label>
                    <select class="form-select">
                        <option selected>All Currencies</option>
                        <option value="NGN">NGN</option>
                        <option value="USD">USD</option>
                        <option value="EUR">EUR</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button class="btn btn-success w-100">Apply Filters</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
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

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <nav aria-label="Transaction pagination">
                    <ul class="pagination mb-0">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                        </li>
                        <li class="page-item active" aria-current="page"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
                <a href="#" class="text-success">View All</a>
            </div>
        </div>
    </div>
</div>
@endsection