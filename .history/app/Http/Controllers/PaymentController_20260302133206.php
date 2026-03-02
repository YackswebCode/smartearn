<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Mail\OrderConfirmationMail;
use App\Mail\AffiliateCommissionMail;
use App\Mail\VendorSaleMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    protected $toNGN = [
        'NGN' => 1,
        'USD' => 1363.33,
        'GHS' => 127.81,
        'XAF' => 2.45,
        'KES' => 10.56,
    ];

public function verify(Request $request)
{
    \Log::info('Payment verification started', $request->all());

    try {
        $request->validate([
            'transaction_id' => 'required',
            'reference' => 'required|string',
            'product_id' => 'required|exists:products,id',
            'affiliate_id' => 'required|exists:users,id',
            'amount' => 'required|numeric',
            'currency' => 'required|in:NGN,USD,GHS,XAF,KES',
            'buyer_email' => 'required|email',
            'buyer_name' => 'required|string|max:255',
        ]);

        // TEMPORARY: bypass verification for testing
        // $verified = $this->verifyFlutterwaveTransaction(...);
        $verified = true; // force success for now

        if (!$verified) {
            return response()->json(['success' => false, 'message' => 'Transaction verification failed.']);
        }

        $product = Product::find($request->product_id);
        $affiliate = User::find($request->affiliate_id);
        $vendor = User::find($product->vendor_id);

        if (!$vendor) {
            return response()->json(['success' => false, 'message' => 'Vendor not found.']);
        }

        $productPriceNGN = $product->price * $this->toNGN[$product->currency];
        $affiliateCommissionNGN = $productPriceNGN * ($product->commission_percent / 100);
        $vendorEarningsNGN = $productPriceNGN - $affiliateCommissionNGN;

        DB::beginTransaction();

        $order = Order::create([
            'user_id' => null,
            'buyer_email' => $request->buyer_email,
            'buyer_name' => null,
            'product_id' => $product->id,
            'affiliate_id' => $affiliate->id,
            'vendor_id' => $vendor->id,
            'amount' => $productPriceNGN,
            'currency' => 'NGN',
            'affiliate_commission' => $affiliateCommissionNGN,
            'vendor_earnings' => $vendorEarningsNGN,
            'reference' => $request->reference,
            'payment_gateway' => 'flutterwave',
            'status' => 'completed',
        ]);

        $affiliate->affiliate_balance += $affiliateCommissionNGN;
        $affiliate->save();

        $vendor->vendor_balance += $vendorEarningsNGN;
        $vendor->save();

        DB::commit();

        // Queue emails (use queue:work if possible)
        Mail::to($request->buyer_email)->send(new OrderConfirmationMail($order, $product));
        Mail::to($affiliate->email)->send(new AffiliateCommissionMail($order, $product));
        Mail::to($vendor->email)->send(new VendorSaleMail($order, $product));

        return response()->json([
            'success' => true,
            'redirect' => route('payment.complete', ['order' => $order->id])
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Payment verification error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
        return response()->json(['success' => false, 'message' => 'Server error: ' . $e->getMessage()], 500);
    }
}

    public function complete(Order $order)
    {
        // No authentication required – anyone with the link can view
        // But ensure the order exists
        return view('payment.complete', compact('order'));
    }

    private function verifyFlutterwaveTransaction($transactionId, $expectedAmount, $expectedCurrency)
    {
        // TODO: Implement actual Flutterwave verification
        // For now, return true for testing
        return true;
    }
}