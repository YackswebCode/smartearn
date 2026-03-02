<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - SmartEarn</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-green: #065754;
            --primary-white: #FFFFFF;
            --primary-black: #000000;
            --light-green: #0b7a76;
            --soft-gray: #f5f5f5;
            --border-gray: #e0e0e0;
            --gradient-green: linear-gradient(135deg, var(--primary-green) 0%, var(--light-green) 100%);
            --green-light-bg: #e8f3f2;
            --green-extra-light: #f0f9f8;
            --green-dark: #043a38;
        }

        body {
            background-color: var(--soft-gray);
            font-family: 'Segoe UI', Roboto, sans-serif;
        }

        .product-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .product-header {
            background: var(--gradient-green);
            color: white;
            padding: 40px 30px;
        }

        .price-box {
            background: var(--green-light-bg);
            border-radius: 16px;
            padding: 20px;
            border: 1px solid var(--border-gray);
        }

        .btn-primary-green {
            background: var(--primary-green);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary-green:hover {
            background: var(--green-dark);
            color: white;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="product-card">
                    <div class="product-header text-center">
                        <h1 class="fw-bold">{{ $product->name }}</h1>
                        <p class="mb-0">Presented by {{ $affiliate->name }}</p>
                    </div>

                    <div class="p-4">
                        <div class="mb-4">
                            <h5>About this product</h5>
                            <p>{{ $product->description }}</p>
                        </div>

                        <div class="price-box mb-4">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <label for="currencySelect" class="form-label fw-bold">Select Currency</label>
                                    <select id="currencySelect" class="form-select" onchange="updatePrice()">
                                        <option value="NGN" data-symbol="₦">NGN (₦)</option>
                                        <option value="USD" data-symbol="$">USD ($)</option>
                                        <option value="GHS" data-symbol="GH¢">GHS (GH¢)</option>
                                        <option value="XAF" data-symbol="FCFA">XAF (FCFA)</option>
                                        <option value="KES" data-symbol="KES">KES (KES)</option>
                                    </select>
                                </div>
                                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                                    <span class="text-secondary">Price:</span>
                                    <h2 id="priceDisplay" class="mb-0 text-primary-green">...</h2>
                                </div>
                            </div>
                        </div>
                        <!-- Add email field -->
                        <div class="mb-3">
                            <label for="buyerEmail" class="form-label fw-bold">Your Email</label>
                            <input type="email" class="form-control" id="buyerEmail" placeholder="you@example.com" required>
                        </div>

                        <div class="d-grid">
                            <button class="btn btn-primary-green btn-lg" id="payNowBtn" onclick="initiateFlutterwavePayment()">
                                <i class="fas fa-lock me-2"></i> Buy Now
                            </button>
                        </div>

                        <p class="text-muted text-center mt-3 small">
                            Secure payment by Flutterwave
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Flutterwave inline SDK -->
    <script src="https://checkout.flutterwave.com/v3.js"></script>

<script>
    // Product data from backend
    const product = @json($product);
    const affiliate = @json($affiliate);
    const conversionRates = @json($toNGN);
    const symbols = @json($symbols);

    const basePrice = parseFloat(product.price);
    const baseCurrency = product.currency;

    function convertPrice(amount, from, to) {
        if (from === to) return amount;
        const amountInNGN = amount * conversionRates[from];
        const amountInTarget = amountInNGN / conversionRates[to];
        return amountInTarget;
    }

    function updatePrice() {
        const select = document.getElementById('currencySelect');
        const targetCurrency = select.value;
        const converted = convertPrice(basePrice, baseCurrency, targetCurrency);
        const symbol = symbols[targetCurrency];
        document.getElementById('priceDisplay').innerText = symbol + ' ' + converted.toFixed(2);
    }
    updatePrice();

    function initiateFlutterwavePayment() {
        const btn = document.getElementById('payNowBtn');
        const emailInput = document.getElementById('buyerEmail');
        const email = emailInput.value.trim();

        if (!email || !email.includes('@')) {
            alert('Please enter a valid email address.');
            return;
        }

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Loading...';

        const select = document.getElementById('currencySelect');
        const currency = select.value;
        const amount = convertPrice(basePrice, baseCurrency, currency);
        const reference = 'SE' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);

        console.log('Initializing Flutterwave with:', { email, currency, amount, reference });

        setTimeout(() => {
            try {
                FlutterwaveCheckout({
                    public_key: '{{ config("services.flutterwave.public_key") }}',
                    tx_ref: reference,
                    amount: amount,
                    currency: currency,
                    payment_options: 'card, banktransfer, ussd, mobilemoneyghana',
                    customer: {
                        email: email,
                        name: 'Buyer',
                    },
                    customizations: {
                        title: 'SmartEarn',
                        description: `Purchase of ${product.name}`,
                        logo: 'https://flutterwave.com/images/logo/full.svg', // replace with your logo if needed
                    },
                    callback: function(response) {
                        console.log('Flutterwave callback:', response);
                        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Processing...';
                        handlePaymentSuccess(response.transaction_id, reference, currency, amount, email);
                    },
                    onclose: function() {
                        console.log('Flutterwave popup closed');
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fas fa-lock me-2"></i> Buy Now';
                    }
                });
            } catch (e) {
                console.error('Flutterwave error:', e);
                alert('Failed to initialize payment. Check console.');
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-lock me-2"></i> Buy Now';
            }
        }, 100);
    }

    function handlePaymentSuccess(transactionId, reference, currency, amount, email) {
        const btn = document.getElementById('payNowBtn');
        console.log('Sending verification:', { transactionId, reference, currency, amount, email });

        fetch('{{ route("payment.verify") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                transaction_id: transactionId,
                reference: reference,
                product_id: product.id,
                affiliate_id: affiliate.id,
                amount: amount,
                currency: currency,
                buyer_email: email
            })
        })
        .then(response => {
            console.log('Verification response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Verification data:', data);
            if (data.success) {
                window.location.href = data.redirect;
            } else {
                showAlert('danger', data.message || 'Verification failed. Please contact support.');
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-lock me-2"></i> Buy Now';
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            showAlert('danger', 'Network error. Please try again.');
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-lock me-2"></i> Buy Now';
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

        // Helper for alerts
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
</body>
</html>