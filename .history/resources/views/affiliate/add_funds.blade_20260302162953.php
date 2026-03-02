@extends('layouts.affiliate')

@section('title', 'Add Funds')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Add Funds</h2>
    </div>

    <div class="row">
        <div class="col-lg-7 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h4 class="fw-semibold mb-3">Add funds to your wallet</h4>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form method="POST" action="{{ route('affiliate.add_funds.process') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="amount" class="form-label fw-semibold">Amount ({{ $userCurrency }})</label>
                            <div class="input-group">
                                <span class="input-group-text">{{ $symbols[$userCurrency] }}</span>
                                <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" placeholder="Enter amount" min="1" step="0.01" value="{{ old('amount') }}">
                            </div>
                            @error('amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="payment_method" class="form-label fw-semibold">Payment Method</label>
                            <select class="form-select @error('payment_method') is-invalid @enderror" id="payment_method" name="payment_method">
                                <option selected disabled>Select payment method</option>
                                <option value="card">Credit/Debit Card</option>
                                <option value="bank">Bank Transfer</option>
                                <option value="paypal">PayPal</option>
                            </select>
                            @error('payment_method') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">Proceed to Payment</button>
                        </div>
                    </form>

                    <hr class="my-4">
                    <p class="text-muted small">
                        <i class="fas fa-info-circle me-1"></i>
                        Funds added to your wallet can be used for purchases and marketplace subscriptions.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-5 mb-4">
            <div class="card border-0 shadow-sm bg-success text-white">
                <div class="card-body text-center p-4">
                    <h5 class="fw-semibold">Current Wallet Balance</h5>
                    <h1 class="display-3 fw-bold">{{ $symbols[$userCurrency] }}{{ number_format($balance, 2) }}</h1>
                    <a href="{{ route('affiliate.wallet') }}" class="btn btn-outline-light mt-3">View Wallet</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Funding Transactions -->
    <div class="mt-4">
        <h4 class="fw-semibold mb-3">Recent Funding Transactions</h4>
        <!-- Filters and table – same as wallet but filtered to funding -->
        <!-- ... (copy from wallet but keep funding only) -->
    </div>
</div>
@endsection