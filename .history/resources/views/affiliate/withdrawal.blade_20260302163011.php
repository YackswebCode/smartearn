@extends('layouts.affiliate')

@section('title', 'Withdraw Funds')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Withdraw from Affiliate Balance</h2>
    </div>

    <div class="row">
        <div class="col-lg-7 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h4 class="fw-semibold mb-3">Withdraw funds to your account</h4>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <!-- Important Note -->
                    <div class="alert alert-warning py-2 small" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        Withdrawals might take up to 24 hours to process. For foreign withdrawals we only accept Momo account.
                    </div>

                    <!-- Bank Details (if any) -->
                    @if(isset($bankDetails->bank_name))
                    <div class="bg-light p-3 rounded-3 mb-4">
                        <p class="mb-1"><strong>Default withdrawal account:</strong></p>
                        @if($bankDetails->type == 'bank')
                            <p class="mb-0">{{ $bankDetails->bank_name }} - {{ $bankDetails->account_number }} - {{ $bankDetails->account_name }}</p>
                        @else
                            <p class="mb-0">{{ $bankDetails->momo_provider }} - {{ $bankDetails->momo_number }}</p>
                        @endif
                    </div>
                    @endif

                    <form method="POST" action="{{ route('affiliate.withdrawals.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="amount" class="form-label fw-semibold">Amount ({{ $userCurrency }})</label>
                            <div class="input-group">
                                <span class="input-group-text">{{ $symbols[$userCurrency] }}</span>
                                <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" value="{{ old('amount', 0) }}" min="100" step="100">
                            </div>
                            @error('amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Account Type</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="account_type" id="typeBank" value="bank" checked>
                                    <label class="form-check-label" for="typeBank">Bank Account</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="account_type" id="typeMomo" value="momo">
                                    <label class="form-check-label" for="typeMomo">Mobile Money (Foreign)</label>
                                </div>
                            </div>
                        </div>

                        <!-- Bank Fields -->
                        <div id="bankFields">
                            <div class="mb-3">
                                <label for="bank_name" class="form-label fw-semibold">Bank Name</label>
                                <input type="text" class="form-control @error('bank_name') is-invalid @enderror" id="bank_name" name="bank_name" value="{{ old('bank_name') }}">
                                @error('bank_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="account_name" class="form-label fw-semibold">Account Name</label>
                                <input type="text" class="form-control @error('account_name') is-invalid @enderror" id="account_name" name="account_name" value="{{ old('account_name') }}">
                                @error('account_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="account_number" class="form-label fw-semibold">Account Number</label>
                                <input type="text" class="form-control @error('account_number') is-invalid @enderror" id="account_number" name="account_number" value="{{ old('account_number') }}">
                                @error('account_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Momo Fields (hidden initially) -->
                        <div id="momoFields" style="display: none;">
                            <div class="mb-3">
                                <label for="momo_provider" class="form-label fw-semibold">Mobile Money Provider</label>
                                <select class="form-select @error('momo_provider') is-invalid @enderror" id="momo_provider" name="momo_provider">
                                    <option value="">Select</option>
                                    <option value="MTN">MTN</option>
                                    <option value="Vodafone">Vodafone</option>
                                    <option value="AirtelTigo">AirtelTigo</option>
                                </select>
                                @error('momo_provider') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="momo_number" class="form-label fw-semibold">Mobile Money Number</label>
                                <input type="text" class="form-control @error('momo_number') is-invalid @enderror" id="momo_number" name="momo_number" value="{{ old('momo_number') }}">
                                @error('momo_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="text-muted">Withdrawal Fee: <strong>{{ $symbols[$userCurrency] }}{{ number_format($withdrawalFee / $toNGN[$userCurrency], 2) }}</strong></span>
                            <button type="submit" class="btn btn-success px-5">Withdraw</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5 mb-4">
            <div class="card border-0 shadow-sm bg-success text-white">
                <div class="card-body text-center p-4">
                    <h5 class="fw-semibold">Available to withdraw</h5>
                    <h1 class="display-3 fw-bold">{{ $symbols[$userCurrency] }}{{ number_format($balance, 2) }}</h1>
                    <a href="{{ route('affiliate.wallet') }}" class="btn btn-outline-light mt-3">View Wallet</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Withdrawal Transactions -->
    <div class="mt-4">
        <h4 class="fw-semibold mb-3">Recent Withdrawals</h4>
        <!-- Filters and table – similar to wallet but filtered to withdrawals -->
        <!-- ... -->
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeBank = document.getElementById('typeBank');
        const typeMomo = document.getElementById('typeMomo');
        const bankFields = document.getElementById('bankFields');
        const momoFields = document.getElementById('momoFields');

        function toggleFields() {
            if (typeBank.checked) {
                bankFields.style.display = 'block';
                momoFields.style.display = 'none';
                // disable momo fields to prevent validation errors
                document.querySelectorAll('#momoFields input, #momoFields select').forEach(el => el.disabled = true);
                document.querySelectorAll('#bankFields input').forEach(el => el.disabled = false);
            } else {
                bankFields.style.display = 'none';
                momoFields.style.display = 'block';
                document.querySelectorAll('#bankFields input').forEach(el => el.disabled = true);
                document.querySelectorAll('#momoFields input, #momoFields select').forEach(el => el.disabled = false);
            }
        }

        typeBank.addEventListener('change', toggleFields);
        typeMomo.addEventListener('change', toggleFields);
        toggleFields(); // initial
    });
</script>
@endpush