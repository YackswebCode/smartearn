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

                    <div class="mb-3">
                        <label for="amount" class="form-label fw-semibold">Amount ({{ $userCurrency }})</label>
                        <div class="input-group">
                            <span class="input-group-text">{{ $symbols[$userCurrency] }}</span>
                            <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter amount" min="1" step="0.01" value="{{ old('amount') }}">
                        </div>
                    </div>

                    <div class="d-grid">
                        <button class="btn btn-success btn-lg" id="payNowBtn" onclick="initiateFlutterwavePayment()">
                            <i class="fas fa-lock me-2"></i> Proceed to Payment
                        </button>
                    </div>

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
                                <td class="text-success">+{{ $symbols[$userCurrency] }}{{ number_format($tx['amount'], 2) }}</td>
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

<!-- Include Flutterwave SDK -->
<script src="https://checkout.flutterwave.com/v3.js"></script>

<script>
    // User data from backend
    const user = @json(Auth::user());
    const symbols = @json($symbols);
    const conversionRates = @json($toNGN);

    function initiateFlutterwavePayment() {
        const btn = document.getElementById('payNowBtn');
        const amountInput = document.getElementById('amount');
        const amount = parseFloat(amountInput.value);

        if (!amount || amount < 1) {
            alert('Please enter a valid amount (minimum 1).');
            return;
        }

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Loading...';

        const currency = '{{ $userCurrency }}';
        const reference = 'FUND_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);

        setTimeout(() => {
            try {
                FlutterwaveCheckout({
                    public_key: '{{ config("services.flutterwave.public_key") }}',
                    tx_ref: reference,
                    amount: amount,
                    currency: currency,
                    payment_options: 'card, banktransfer, ussd, mobilemoneyghana',
                    customer: {
                        email: user.email,
                        name: user.name,
                    },
                    customizations: {
                        title: 'SmartEarn',
                        description: 'Wallet Funding',
                        logo: '{{ asset("images/logo.png") }}',
                    },
                    callback: function(response) {
                        console.log('Flutterwave callback:', response);
                        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Processing...';
                        handlePaymentSuccess(response.transaction_id, reference, amount, currency);
                    },
                    onclose: function() {
                        console.log('Flutterwave popup closed');
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fas fa-lock me-2"></i> Proceed to Payment';
                    }
                });
            } catch (e) {
                console.error('Flutterwave error:', e);
                alert('Failed to initialize payment. Check console.');
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-lock me-2"></i> Proceed to Payment';
            }
        }, 100);
    }

    function handlePaymentSuccess(transactionId, reference, amount, currency) {
        const btn = document.getElementById('payNowBtn');
        console.log('Sending verification:', { transactionId, reference, amount, currency });

        fetch('{{ route("affiliate.add_funds.verify") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                transaction_id: transactionId,
                reference: reference,
                amount: amount,
                currency: currency
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', 'Funds added successfully!');
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 2000);
            } else {
                showAlert('danger', data.message || 'Verification failed. Please contact support.');
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-lock me-2"></i> Proceed to Payment';
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            showAlert('danger', 'Network error. Please try again.');
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-lock me-2"></i> Proceed to Payment';
        });
    }

    function showAlert(type, message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3`;
        alertDiv.style.zIndex = 9999;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(alertDiv);
        setTimeout(() => alertDiv.remove(), 5000);
    }
</script>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#transactions-table').DataTable({
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
    });
</script>
@endpush