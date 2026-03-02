<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Commission;
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
        $request->validate([
            'transaction_id' => 'required',
            'reference' => 'required|string',
            'product_id' => 'required|exists:products,id',
            'affiliate_id' => 'required|exists:users,id',
            'amount' => 'required|numeric',
            'currency' => 'required|in:NGN,USD,GHS,XAF,KES',
        ]);

        // Verify transaction with Flutterwave (server-side)
        $verified = $this->verifyFlutterwaveTransaction($request->transaction_id, $request->amount, $request->currency);

        if (!$verified) {
            return response()->json(['success' => false, 'message' => 'Transaction verification failed.']);
        }

        $product = Product::find($request->product_id);
        $affiliate = User::find($request->affiliate_id);
        $vendor = User::find($product->vendor_id);
        $buyer = auth()->user();

        if (!$vendor) {
            return response()->json(['success' => false, 'message' => 'Vendor not found.']);
        }

        // Calculate earnings
        // Commission is based on product's commission_percent (affiliate's share)
        // Convert product price to NGN for consistent calculation
        $productPriceNGN = $product->price * $this->toNGN[$product->currency];
        $affiliateCommissionNGN = $productPriceNGN * ($product->commission_percent / 100);
        $vendorEarningsNGN = $productPriceNGN - $affiliateCommissionNGN;

        // Convert to the currency of payment (if needed for storage, we store in NGN for simplicity)
        // But we can store amounts in NGN as base.

        DB::beginTransaction();

        try {
            // Create order
            $order = Order::create([
                'user_id' => $buyer->id,
                'product_id' => $product->id,
                'affiliate_id' => $affiliate->id,
                'vendor_id' => $vendor->id,
                'amount' => $productPriceNGN, // store in NGN
                'currency' => 'NGN',
                'affiliate_commission' => $affiliateCommissionNGN,
                'vendor_earnings' => $vendorEarningsNGN,
                'reference' => $request->reference,
                'payment_gateway' => 'flutterwave',
                'status' => 'completed',
            ]);

            // Update balances
            $affiliate->affiliate_balance += $affiliateCommissionNGN;
            $affiliate->save();

            $vendor->vendor_balance += $vendorEarningsNGN;
            $vendor->save();

            // Create commission records
            Commission::create([
                'user_id' => $affiliate->id,
                'order_id' => $order->id,
                'type' => 'affiliate',
                'amount' => $affiliateCommissionNGN,
                'currency' => 'NGN',
            ]);

            Commission::create([
                'user_id' => $vendor->id,
                'order_id' => $order->id,
                'type' => 'vendor',
                'amount' => $vendorEarningsNGN,
                'currency' => 'NGN',
            ]);

            DB::commit();

            // Send emails (queueable)
            Mail::to($buyer->email)->send(new OrderConfirmationMail($order, $product));
            Mail::to($affiliate->email)->send(new AffiliateCommissionMail($order, $product));
            Mail::to($vendor->email)->send(new VendorSaleMail($order, $product));

            return response()->json([
                'success' => true,
                'redirect' => route('affiliate.dashboard') // or product page
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to process order: ' . $e->getMessage()]);
        }
    }

    private function verifyFlutterwaveTransaction($transactionId, $expectedAmount, $expectedCurrency)
    {
        // Implement actual verification using Flutterwave API
        // For now, return true for testing
        return true;
    }
}