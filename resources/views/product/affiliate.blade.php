<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} | Promoted by {{ $affiliate->name }} – SmartEarn</title>

    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        :root {
            --primary-green: #065754;
            --light-green: #0b7a76;
            --accent: #e8f3f2;
            --gray-bg: #f7f9fb;
            --card-shadow: 0 4px 12px rgba(0,0,0,0.06);
            --border-radius: 16px;
        }

        body {
            background: var(--gray-bg);
            font-family: 'Inter', system-ui, sans-serif;
            color: #222;
            line-height: 1.6;
        }

        .page-wrapper {
            max-width: 960px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .header-bar {
            background: var(--primary-green);
            color: white;
            padding: 1.2rem 1.5rem;
            border-radius: var(--border-radius) var(--border-radius) 0 0;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
        }

        .header-bar h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
            word-break: break-word;
        }

        .affiliate-badge {
            background: rgba(255,255,255,0.2);
            border-radius: 50px;
            padding: 0.3rem 1rem;
            font-size: 0.85rem;
            backdrop-filter: blur(4px);
        }

        .content-card {
            background: white;
            border-radius: 0 0 var(--border-radius) var(--border-radius);
            box-shadow: var(--card-shadow);
            overflow: hidden;
        }

        .product-image-large {
            width: 100%;
            max-height: 420px;
            object-fit: cover;
            border-bottom: 4px solid var(--primary-green);
        }

        .product-body {
            padding: 2rem;
        }

        .description {
            font-size: 1.05rem;
            color: #444;
            margin-bottom: 2rem;
        }

        .currency-box {
            background: var(--accent);
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .currency-box select {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 0.5rem;
            font-weight: 500;
        }

        .price-display {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-green);
            margin: 0.5rem 0 0;
        }

        .buyer-form .form-control {
            border-radius: 8px;
            padding: 0.7rem 1rem;
            border: 1px solid #ced4da;
            margin-bottom: 0.8rem;
        }

        .btn-buy {
            background: var(--primary-green);
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            padding: 0.8rem;
            border: none;
            border-radius: 12px;
            transition: 0.2s;
            width: 100%;
        }

        .btn-buy:hover {
            background: #044d4a;
        }

        .trust-strip {
            display: flex;
            gap: 1.5rem;
            align-items: center;
            margin-top: 1.5rem;
            justify-content: center;
            color: #555;
            font-size: 0.9rem;
        }

        .trust-strip i {
            color: var(--primary-green);
            margin-right: 0.3rem;
        }

        @media (max-width: 576px) {
            .header-bar h1 { font-size: 1.4rem; }
        }
    </style>
</head>
<body>
    <div class="page-wrapper">
        <!-- Header -->
        <div class="header-bar">
            <div>
                <h1>{{ $product->name }}</h1>
            </div>
            <span class="affiliate-badge">
                <i class="fas fa-user-check me-1"></i> Promoted by {{ $affiliate->name }}
            </span>
        </div>

        <!-- Main Card -->
        <div class="content-card">
            @if($product->image)
                <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="product-image-large">
            @endif

            <div class="product-body">
                <!-- Description -->
                <p class="description">{{ $product->description }}</p>

                <!-- Currency & Price -->
                <div class="currency-box">
                    <label class="fw-semibold mb-1">Select Currency</label>
                    <select id="currencySelect" class="form-select" onchange="updatePrice()">
                        <option value="NGN">🇳🇬 NGN</option>
                        <option value="USD">🇺🇸 USD</option>
                        <option value="GHS">🇬🇭 GHS</option>
                        <option value="XAF">🇨🇲/🇨🇮 XAF</option>
                        <option value="KES">🇰🇪 KES</option>
                    </select>
                    <div class="price-display" id="priceDisplay"></div>
                    <small class="text-muted">Price inclusive of all fees</small>
                </div>

                <!-- Buyer Form -->
                <div class="buyer-form">
                    <input type="text" id="buyerName" class="form-control" placeholder="Your Full Name">
                    <input type="email" id="buyerEmail" class="form-control" placeholder="Email Address">
                </div>

                <button class="btn btn-buy" onclick="pay()">
                    <i class="fas fa-shopping-cart me-2"></i> Buy Now – Secure Checkout
                </button>

                <!-- Trust indicators -->
                <div class="trust-strip">
                    <span><i class="fas fa-lock"></i> SSL Secure</span>
                    <span><i class="fas fa-shield-alt"></i> Instant Access</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Flutterwave & Scripts -->
    <script src="https://checkout.flutterwave.com/v3.js"></script>
    <script>
        const product = @json($product);
        const affiliate = @json($affiliate);
        const ref = @json($ref);
        const conversionRates = @json($toNGN);
        const symbols = @json($symbols);
        const basePrice = parseFloat(product.price);
        const baseCurrency = product.currency;

        function convert(amount, from, to){
            if(from === to) return amount;
            return (amount * conversionRates[from]) / conversionRates[to];
        }

        function updatePrice(){
            const c = document.getElementById('currencySelect').value;
            const price = convert(basePrice, baseCurrency, c);
            document.getElementById('priceDisplay').innerText =
                symbols[c] + ' ' + price.toFixed(2);
        }
        updatePrice();

        function pay(){
            const name = document.getElementById('buyerName').value.trim();
            const email = document.getElementById('buyerEmail').value.trim();

            if(!name || !email){
                alert('Please fill in your name and email.');
                return;
            }

            const currency = document.getElementById('currencySelect').value;
            const amount = convert(basePrice, baseCurrency, currency);
            const reference = 'SE_' + Date.now();

            FlutterwaveCheckout({
                public_key: '{{ config("services.flutterwave.public_key") }}',
                tx_ref: reference,
                amount: amount,
                currency: currency,
                customer: { email, name },
                callback: function(res){
                    verifyPayment(res.transaction_id, reference, currency, amount, name, email);
                },
                onclose: function() {
                    // optional: handle close
                }
            });
        }

        function verifyPayment(transactionId, reference, currency, amount, name, email){
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
                    ref: ref,
                    affiliate_id: affiliate ? affiliate.id : null,
                    amount: amount,
                    currency: currency,
                    buyer_name: name,
                    buyer_email: email
                })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    window.location.href = data.redirect;
                } else {
                    alert(data.message || 'Payment verification failed. Please contact support.');
                }
            })
            .catch(() => alert('Network error. Please try again.'));
        }
    </script>
</body>
</html>