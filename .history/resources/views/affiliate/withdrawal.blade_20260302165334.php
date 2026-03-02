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

                    <!-- Saved Accounts Dropdown -->
                    @if($savedAccounts->count() > 0)
                    <div class="mb-4">
                        <label for="saved_account" class="form-label fw-semibold">Select Saved Account</label>
                        <select class="form-select" id="saved_account" onchange="location.href='?account_id='+this.value;">
                            <option value="">-- Use New Account --</option>
                            @foreach($savedAccounts as $acc)
                                <option value="{{ $acc->id }}" {{ $selectedAccountId == $acc->id ? 'selected' : '' }}>
                                    {{ $acc->type == 'bank' ? $acc->bank_name.' - '.$acc->account_number : $acc->momo_provider.' - '.$acc->momo_number }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <!-- Bank Details (if any) -->
                    @if(isset($bankDetails->bank_name) && $bankDetails->bank_name !== '' && $selectedAccountId)
                    <div class="bg-light p-3 rounded-3 mb-4">
                        <p class="mb-1"><strong>Selected account:</strong></p>
                        @if($bankDetails->type == 'bank')
                            <p class="mb-0">{{ $bankDetails->bank_name }} - {{ $bankDetails->account_number }} - {{ $bankDetails->account_name }}</p>
                        @else
                            <p class="mb-0">{{ $bankDetails->momo_provider }} - {{ $bankDetails->momo_number }}</p>
                        @endif
                    </div>
                    @endif

                    <form method="POST" action="{{ route('affiliate.withdrawals.store') }}">
                        @csrf
                        @if($selectedAccountId)
                            <input type="hidden" name="account_id" value="{{ $selectedAccountId }}">
                        @endif

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
                                    <input class="form-check-input" type="radio" name="account_type" id="typeBank" value="bank" {{ $bankDetails->type == 'bank' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="typeBank">Bank Account</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="account_type" id="typeMomo" value="momo" {{ $bankDetails->type == 'momo' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="typeMomo">Mobile Money (Foreign)</label>
                                </div>
                            </div>
                        </div>

                        <!-- Bank Fields -->
                        <div id="bankFields" style="{{ $bankDetails->type == 'bank' ? 'display:block;' : 'display:none;' }}">
                            <div class="mb-3">
                                <label for="bank_name" class="form-label fw-semibold">Bank Name</label>
                                <input type="text" class="form-control @error('bank_name') is-invalid @enderror" id="bank_name" name="bank_name" value="{{ old('bank_name', $bankDetails->bank_name) }}">
                                @error('bank_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="account_name" class="form-label fw-semibold">Account Name</label>
                                <input type="text" class="form-control @error('account_name') is-invalid @enderror" id="account_name" name="account_name" value="{{ old('account_name', $bankDetails->account_name) }}">
                                @error('account_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="account_number" class="form-label fw-semibold">Account Number</label>
                                <input type="text" class="form-control @error('account_number') is-invalid @enderror" id="account_number" name="account_number" value="{{ old('account_number', $bankDetails->account_number) }}">
                                @error('account_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Momo Fields -->
                        <div id="momoFields" style="{{ $bankDetails->type == 'momo' ? 'display:block;' : 'display:none;' }}">
                            <div class="mb-3">
                                <label for="momo_provider" class="form-label fw-semibold">Mobile Money Provider</label>
                                <select class="form-select @error('momo_provider') is-invalid @enderror" id="momo_provider" name="momo_provider">
                                    <option value="">Select</option>
                                    <option value="MTN" {{ old('momo_provider', $bankDetails->momo_provider) == 'MTN' ? 'selected' : '' }}>MTN</option>
                                    <option value="Vodafone" {{ old('momo_provider', $bankDetails->momo_provider) == 'Vodafone' ? 'selected' : '' }}>Vodafone</option>
                                    <option value="AirtelTigo" {{ old('momo_provider', $bankDetails->momo_provider) == 'AirtelTigo' ? 'selected' : '' }}>AirtelTigo</option>
                                </select>
                                @error('momo_provider') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="momo_number" class="form-label fw-semibold">Mobile Money Number</label>
                                <input type="text" class="form-control @error('momo_number') is-invalid @enderror" id="momo_number" name="momo_number" value="{{ old('momo_number', $bankDetails->momo_number) }}">
                                @error('momo_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                         @if($hasPending)
                        <div class="alert alert-info">
                            <i class="fas fa-clock me-2"></i>
                            You have a pending withdrawal request. You cannot make another withdrawal until it is processed.
                        </div>
                        @endif
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
                        <input type="date" class="form-control" id="fromDate">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">To</label>
                        <input type="date" class="form-control" id="toDate">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Currency</label>
                        <select class="form-select" id="currencyFilter">
                            <option value="">All Currencies</option>
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
                            @forelse($transactions as $tx)
                            <tr>
                                <td>{{ $tx['currency'] }}</td>
                                <td class="text-danger">{{ $symbols[$userCurrency] }}{{ number_format(abs($tx['amount']), 2) }}</td>
                                <td>{{ $tx['type'] }}</td>
                                <td>{{ $tx['description'] }}</td>
                                <td>{{ $tx['date'] }}</td>
                            </tr>
                            @empty
                            @endforelse
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
document.addEventListener('DOMContentLoaded', function() {
    const typeBank = document.getElementById('typeBank');
    const typeMomo = document.getElementById('typeMomo');
    const bankFields = document.getElementById('bankFields');
    const momoFields = document.getElementById('momoFields');

    function toggleFields() {
        if (typeBank.checked) {
            bankFields.style.display = 'block';
            momoFields.style.display = 'none';
            // enable/disable fields if needed (but they're just hidden, no need to disable)
        } else {
            bankFields.style.display = 'none';
            momoFields.style.display = 'block';
        }
    }

    typeBank.addEventListener('change', toggleFields);
    typeMomo.addEventListener('change', toggleFields);

    // DataTable initialization
    const table = $('#transactions-table').DataTable({
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
        const currency = $('#currencyFilter').val();
        if (currency) {
            table.column(0).search(currency).draw();
        } else {
            table.column(0).search('').draw();
        }
    });
});
</script>
@endpush