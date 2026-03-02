<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful - SmartEarn</title>
    <!-- Bootstrap CSS (optional, but keeps styling consistent) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-green: #065754;
            --primary-white: #FFFFFF;
            --light-green: #0b7a76;
            --soft-gray: #f5f5f5;
            --green-light-bg: #e8f3f2;
        }
        body {
            background-color: var(--soft-gray);
            font-family: 'Segoe UI', Roboto, sans-serif;
            display: flex;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .complete-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
            max-width: 600px;
            margin: 0 auto;
            overflow: hidden;
        }
        .complete-header {
            background: var(--primary-green);
            color: white;
            padding: 40px 30px 20px;
            text-align: center;
        }
        .complete-header h1 {
            font-size: 2rem;
            margin: 10px 0 0;
        }
        .complete-body {
            padding: 30px;
        }
        .order-detail {
            background: var(--green-light-bg);
            border-radius: 16px;
            padding: 20px;
            margin: 20px 0;
        }
        .order-detail p {
            margin: 8px 0;
        }
    </style>
</head>
<body>
    <div class="complete-card">
        <div class="complete-header">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
            <h1>Payment Successful!</h1>
        </div>
        <div class="complete-body">
            <p class="lead">Thank you for your purchase.</p>
            <p>Your order has been confirmed. A confirmation email has been sent to <strong>{{ $order->buyer_email }}</strong>.</p>

            <div class="order-detail">
                <h5>Order Summary</h5>
                <p><strong>Reference:</strong> {{ $order->reference }}</p>
                <p><strong>Product:</strong> {{ $order->product->name }}</p>
                <p><strong>Amount:</strong> {{ $order->currency }} {{ number_format($order->amount, 2) }}</p>
                <p><strong>Date:</strong> {{ $order->created_at->format('M d, Y. h:i A') }}</p>
            </div>

            <p class="text-muted small">You can close this window now.</p>
        </div>
    </div>
</body>
</html>