@extends('layouts.app')

@section('title', 'Activate Your Account – SmartEarn')

@section('content')

<section class="hero d-flex align-items-center" style="min-height: 80vh; background: var(--gradient-green);">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="z-index: 0; opacity: 0.15; pointer-events: none;">
        <svg width="100%" height="100%" viewBox="0 0 1200 800">
            <circle cx="20%" cy="30%" r="100" fill="none" stroke="white" stroke-width="2" class="svg-float" />
            <circle cx="70%" cy="60%" r="150" fill="none" stroke="white" stroke-width="1.8" class="svg-float" style="animation-delay: 1.2s;" />
            <circle cx="85%" cy="20%" r="80" fill="none" stroke="white" stroke-width="1.2" class="svg-float" style="animation-delay: 0.5s;" />
        </svg>
    </div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="auth-card">
                    {{-- Brand icon --}}
                    <div class="text-center mb-4">
                        <span class="d-inline-flex align-items-center justify-content-center bg-white rounded-3 shadow-sm"
                              style="width: 64px; height: 64px; color: var(--primary-green); font-size: 2rem; font-weight: 800;">
                            SE
                        </span>
                        <h2 class="fw-bold mt-4 mb-2" style="color: var(--primary-green);">Activate Your Account</h2>
                        <p class="text-secondary">One‑time fee of ₦5,000</p>
                    </div>

                    {{-- Error messages (e.g., from session or validation) --}}
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4" role="alert" style="border-radius: 16px; background: rgba(220,53,69,0.1); color: #dc3545; border: none;">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <div class="price-box mb-4 text-center p-4" style="background: var(--green-light-bg); border-radius: 16px;">
                        <h2 class="text-success">₦5,000</h2>
                        <p class="text-muted mb-0">Access to affiliate dashboard & marketplace</p>
                    </div>

                    {{-- Buyer Fields --}}
                    <div class="mb-3">
                        <label for="buyerName" class="form-label fw-medium text-dark">Your Full Name</label>
                        <input type="text" class="form-control custom-input" id="buyerName" value="{{ $user->name }}" readonly>
                    </div>

                    <div class="mb-4">
                        <label for="buyerEmail" class="form-label fw-medium text-dark">Your Email</label>
                        <input type="email" class="form-control custom-input" id="buyerEmail" value="{{ $user->email }}" readonly>
                    </div>

                    {{-- Payment Button --}}
                    <div class="d-grid">
                        <button class="btn btn-primary w-100 py-3 fw-bold" id="payNowBtn" onclick="initiatePayment()">
                            <i class="fas fa-lock me-2"></i> Pay ₦5,000 Now
                        </button>
                    </div>

                    {{-- Login link --}}
                    <div class="text-center mt-4">
                        <span class="text-secondary">Already paid?</span>
                        <a href="{{ route('login') }}" class="text-decoration-none fw-bold ms-1" style="color: var(--primary-green);">
                            Log in
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Include Flutterwave SDK -->
<script src="https://checkout.flutterwave.com/v3.js"></script>

<script>
    const user = @json($user);
    const amount = 5000; // Fixed amount in NGN
    const currency = 'NGN';
    const reference = 'SUB' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);

    function initiatePayment() {
        const btn = document.getElementById('payNowBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Loading...';

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
                    description: 'Account Activation Fee',
                    logo: 'https://flutterwave.com/images/logo/full.svg',
                },
                callback: function(response) {
                    console.log('Flutterwave callback:', response);
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Processing...';
                    handlePaymentSuccess(response.transaction_id, reference, amount, currency, user.name, user.email);
                },
                onclose: function() {
                    console.log('Flutterwave popup closed');
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-lock me-2"></i> Pay ₦5,000 Now';
                }
            });
        } catch (e) {
            console.error('Flutterwave error:', e);
            alert('Failed to initialize payment. Check console.');
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-lock me-2"></i> Pay ₦5,000 Now';
        }
    }

    function handlePaymentSuccess(transactionId, reference, amount, currency, name, email) {
        const btn = document.getElementById('payNowBtn');
        console.log('Sending verification:', { transactionId, reference, amount, currency, name, email });

        fetch('{{ route("subscription.verify") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                transaction_id: transactionId,
                reference: reference,
                amount: amount,
                currency: currency,
                buyer_name: name,
                buyer_email: email
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect;
            } else {
                alert(data.message || 'Verification failed. Please contact support.');
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-lock me-2"></i> Pay ₦5,000 Now';
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('Network error. Please try again.');
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-lock me-2"></i> Pay ₦5,000 Now';
        });
    }
</script>
@endsection