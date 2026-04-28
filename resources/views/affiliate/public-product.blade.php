<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $product->name }} - SmartEarn</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
:root {
    --primary-green: #065754;
    --light-green: #0b7a76;
    --soft-gray: #f5f5f5;
    --border-gray: #e0e0e0;
    --gradient-green: linear-gradient(135deg, var(--primary-green), var(--light-green));
}
body { background: var(--soft-gray); }
.product-card { background:white;border-radius:20px;box-shadow:0 8px 20px rgba(0,0,0,.05);}
.product-header { background:var(--gradient-green);color:white;padding:30px;}
.price-box { background:#e8f3f2;padding:20px;border-radius:12px;}
.btn-primary-green { background:var(--primary-green);color:white;border-radius:10px;}
</style>
</head>

<body>
<div class="container py-5">
<div class="row justify-content-center">
<div class="col-md-8">

<div class="product-card">

<div class="product-header text-center">
<h2>{{ $product->name }}</h2>

{{-- 🔥 SMART DISPLAY --}}
@if($affiliate)
<p>Promoted by {{ $affiliate->name }}</p>
@else
<p>Sold by {{ $vendor->name ?? 'Unknown Vendor' }}</p>
@endif
</div>

<div class="p-4">

@if($product->image)
<img src="{{ asset('storage/'.$product->image) }}" class="img-fluid rounded mb-3">
@endif

<p>{{ $product->description }}</p>

<div class="price-box mb-3">
<select id="currencySelect" class="form-select mb-2" onchange="updatePrice()">
<option value="NGN">NGN</option>
<option value="USD">USD</option>
<option value="GHS">GHS</option>
<option value="XAF">XAF</option>
<option value="KES">KES</option>
</select>

<h3 id="priceDisplay"></h3>
</div>

<input type="text" id="buyerName" class="form-control mb-2" placeholder="Full Name">
<input type="email" id="buyerEmail" class="form-control mb-3" placeholder="Email">

<button class="btn btn-primary-green w-100" onclick="pay()">Buy Now</button>

</div>
</div>
</div>
</div>
</div>

<script src="https://checkout.flutterwave.com/v3.js"></script>

<script>
const product = @json($product);
const affiliate = @json($affiliate);
const ref = @json($ref); // 🔥 important
const conversionRates = @json($toNGN);
const symbols = @json($symbols);

const basePrice = parseFloat(product.price);
const baseCurrency = product.currency;

function convert(amount, from, to){
    if(from===to) return amount;
    return (amount * conversionRates[from]) / conversionRates[to];
}

function updatePrice(){
    let c = document.getElementById('currencySelect').value;
    let price = convert(basePrice, baseCurrency, c);
    document.getElementById('priceDisplay').innerText =
        symbols[c] + ' ' + price.toFixed(2);
}
updatePrice();

function pay(){
    let name = document.getElementById('buyerName').value;
    let email = document.getElementById('buyerEmail').value;

    if(!name || !email){
        alert('Fill all fields');
        return;
    }

    let currency = document.getElementById('currencySelect').value;
    let amount = convert(basePrice, baseCurrency, currency);

    let reference = 'SE' + Date.now();

    FlutterwaveCheckout({
        public_key: '{{ config("services.flutterwave.public_key") }}',
        tx_ref: reference,
        amount: amount,
        currency: currency,
        customer: { email, name },

        callback: function(res){
            verifyPayment(res.transaction_id, reference, currency, amount, name, email);
        }
    });
}

function verifyPayment(transactionId, reference, currency, amount, name, email){

    fetch('{{ route("payment.verify") }}', {
        method:'POST',
        headers:{
            'Content-Type':'application/json',
            'X-CSRF-TOKEN':'{{ csrf_token() }}'
        },
        body: JSON.stringify({
            transaction_id: transactionId,
            reference: reference,
            product_id: product.id,
            
            // 🔥 FIXED LOGIC
            ref: ref, 
            affiliate_id: affiliate ? affiliate.id : null,

            amount: amount,
            currency: currency,
            buyer_name: name,
            buyer_email: email
        })
    })
    .then(res=>res.json())
    .then(data=>{
        if(data.success){
            window.location.href = data.redirect;
        }else{
            alert(data.message);
        }
    });
}
</script>
</body>
</html>