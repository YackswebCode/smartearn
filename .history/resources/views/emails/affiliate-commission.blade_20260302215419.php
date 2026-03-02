<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commission Earned – SmartEarn</title>
    <style>
        /* Same styles */
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
        .commission-box {
            background-color: #e8f3f2;
            border-radius: 16px;
            padding: 20px;
            margin: 20px 0;
        }
        .commission-box h3 {
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
                        <h1>Congratulations! You Earned a Commission</h1>
                    </div>

                    <!-- Content -->
                    <div class="content">
                        <p style="font-size:16px; color:#4a5568;">Hello <strong style="color:#065754;">{{ $order->affiliate->name }}</strong>,</p>
                        <p style="font-size:16px; color:#4a5568;">A product you promoted just sold! Here's your commission:</p>

                        <div class="commission-box">
                            <h3>{{ $product->name }}</h3>
                            <div class="detail-row">
                                <span>Commission earned:</span>
                                <strong>{{ $order->currency }} {{ number_format($order->affiliate_commission, 2) }}</strong>
                            </div>
                            <div class="detail-row">
                                <span>Order reference:</span>
                                <strong>{{ $order->reference }}</strong>
                            </div>
                            <div class="detail-row">
                                <span>Date:</span>
                                <strong>{{ $order->created_at->format('M d, Y. h:i A') }}</strong>
                            </div>
                        </div>

                        <p style="font-size:16px; color:#4a5568;">Your new affiliate balance is <strong>₦{{ number_format($order->affiliate->affiliate_balance, 2) }}</strong>.</p>

                        <div style="text-align: center;">
                            <a href="{{ route('affiliate.dashboard') }}" class="button">View My Dashboard</a>
                        </div>
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