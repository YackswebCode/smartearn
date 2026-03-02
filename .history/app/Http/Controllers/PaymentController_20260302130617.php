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
        $request->validate([
            'transaction_id' => 'required',
            'reference' => 'required|string',
            'product_id' => 'required|exists:products,id',
            'affiliate_id' => 'required|exists:users,id',
            'amount' => 'required|numeric',
            'currency' => 'required|in:NGN,USD,GHS,XAF,KES',
            'buyer_email' => 'required|email',
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
        $productPriceNGN = $product->price * $this->toNGN[$product->currency];
        $affiliateCommissionNGN = $productPriceNGN * ($product->commission_percent / 100);
        $vendorEarningsNGN = $productPriceNGN - $affiliateCommissionNGN;

        DB::beginTransaction();

        try {
            // Create order
            $order = Order::create([
                'user_id' => null, // or create a guest user?
                'buyer_email' => $request->buyer_email,
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

            // Update balances
            $affiliate->affiliate_balance += $affiliateCommissionNGN;
            $affiliate->save();

            $vendor->vendor_balance += $vendorEarningsNGN;
            $vendor->save();

            DB::commit();

            // Send emails
            Mail::to($buyer->email)->send(new OrderConfirmationMail($order, $product));
            Mail::to($affiliate->email)->send(new AffiliateCommissionMail($order, $product));
            Mail::to($vendor->email)->send(new VendorSaleMail($order, $product));

            // Return success with redirect to payment complete page
            return response()->json([
                'success' => true,
                'redirect' => route('payment.complete', ['order' => $order->id])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to process order: ' . $e->getMessage()]);
        }
    }

        public function complete(Order $order)
        {
            return view('payment.complete', compact('order'));
        }

    private function verifyFlutterwaveTransaction($transactionId, $expectedAmount, $expectedCurrency)
    {
        // TODO: Implement actual Flutterwave verification
        // For now, return true for testing
        return true;
    }
}