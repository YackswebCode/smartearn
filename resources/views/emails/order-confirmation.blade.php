<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Confirmation – SmartEarn</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #EEF0F8;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        }
        .header {
            background: linear-gradient(145deg, #065754 0%, #0b7a76 100%);
            padding: 40px 30px 20px;
            text-align: center;
        }
        .brand-icon {
            background-color: #ffffff;
            width: 64px;
            height: 64px;
            border-radius: 16px;
            margin: 0 auto 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: 800;
            color: #065754;
        }
        .header h1 {
            color: #ffffff;
            font-size: 24px;
            font-weight: 600;
            margin: 0;
        }
        .content {
            padding: 40px 30px;
        }
        .product-box {
            background-color: #EEF0F8;
            border-radius: 16px;
            padding: 20px;
            margin: 20px 0;
        }
        .product-box h3 {
            color: #065754;
            margin-top: 0;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin: 8px 0;
        }
        .footer {
            background-color: #065754;
            padding: 20px 30px;
            text-align: center;
            color: #ffffff;
            font-size: 14px;
            opacity: 0.9;
        }
        .button {
            background-color: #48BB78;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#EEF0F8; padding:20px;">
        <tr>
            <td align="center">
                <div class="email-container">
                    <!-- Header -->
                    <div class="header">
                        <div class="brand-icon">SE</div>
                        <h1>Thank You for Your Purchase!</h1>
                    </div>

                    <!-- Content -->
                    <div class="content">
                        <p style="font-size:16px; color:#4a5568;">Hello <strong style="color:#065754;">{{ $order->buyer_name ?? 'Valued Customer' }}</strong>,</p>
                        <p style="font-size:16px; color:#4a5568;">Your order has been confirmed. Here are the details:</p>

                        <div class="product-box">
                            <h3>{{ $product->name }}</h3>
                           <!-- inside the product box -->
                                <div class="detail-row">
                                    <span>Amount paid:</span>
                                    <strong>{{ $order->currency }} {{ number_format($order->amount, 2) }}</strong>
                                </div>
                            <div class="detail-row">
                                <span>Reference:</span>
                                <strong>{{ $order->reference }}</strong>
                            </div>
                            <div class="detail-row">
                                <span>Date:</span>
                                <strong>{{ $order->created_at->format('M d, Y. h:i A') }}</strong>
                            </div>
                        </div>

                        <p style="font-size:16px; color:#4a5568;">A download link or access instructions will be sent to this email shortly.</p>
                    </div>

                    <!-- Footer -->
                    <div class="footer">
                        &copy; {{ date('Y') }} SmartEarn. All rights reserved.
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>