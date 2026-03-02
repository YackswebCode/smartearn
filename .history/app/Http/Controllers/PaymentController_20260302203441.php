<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Commission;
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
                'amount' => 'required|numeric|min:0.01', // amount in selected currency
                'currency' => 'required|in:NGN,USD,GHS,XAF,KES',
                'buyer_email' => 'required|email',
                'buyer_name' => 'required|string|max:255',
            ]);

            // TEMPORARY: bypass verification for testing
            $verified = true;

            if (!$verified) {
                return response()->json(['success' => false, 'message' => 'Transaction verification failed.']);
            }

            $product = Product::find($request->product_id);
            $affiliate = User::find($request->affiliate_id);
            $vendor = User::find($product->vendor_id);

            if (!$vendor) {
                return response()->json(['success' => false, 'message' => 'Vendor not found.']);
            }

            // Amount in selected currency
            $amountInSelected = $request->amount;
            $selectedCurrency = $request->currency;

            // Calculate commission in selected currency
            $commissionInSelected = $amountInSelected * ($product->commission_percent / 100);
            $vendorEarningsInSelected = $amountInSelected - $commissionInSelected;

            // Convert to NGN for balance updates
            $toNGN = $this->toNGN;
            $commissionNGN = $commissionInSelected * $toNGN[$selectedCurrency];
            $vendorEarningsNGN = $vendorEarningsInSelected * $toNGN[$selectedCurrency];

            DB::beginTransaction();

            // Create order (amount in selected currency)
            $order = Order::create([
                'buyer_email' => $request->buyer_email,
                'buyer_name' => $request->buyer_name,
                'product_id' => $product->id,
                'affiliate_id' => $affiliate->id,
                'vendor_id' => $vendor->id,
                'amount' => $amountInSelected,
                'currency' => $selectedCurrency,
                'affiliate_commission' => $commissionInSelected,
                'vendor_earnings' => $vendorEarningsInSelected,
                'reference' => $request->reference,
                'payment_gateway' => 'flutterwave',
                'status' => 'completed',
            ]);

            // Update affiliate balance (NGN)
            $affiliate->affiliate_balance += $commissionNGN;
            $affiliate->save();

            // Update vendor balance (NGN)
            $vendor->vendor_balance += $vendorEarningsNGN;
            $vendor->save();

            // Insert affiliate commission record (in selected currency)
            Commission::create([
                'order_id' => $order->id,
                'affiliate_id' => $affiliate->id,
                'vendor_id' => null,
                'type' => 'affiliate',
                'amount' => $commissionInSelected,
                'currency' => $selectedCurrency,
            ]);

            // Insert vendor commission record (in selected currency)
            Commission::create([
                'order_id' => $order->id,
                'affiliate_id' => null,
                'vendor_id' => $vendor->id,
                'type' => 'vendor',
                'amount' => $vendorEarningsInSelected,
                'currency' => $selectedCurrency,
            ]);

            DB::commit();

            // Send emails
            Mail::to($request->buyer_email)->send(new OrderConfirmationMail($order, $product));
            Mail::to($affiliate->email)->send(new AffiliateCommissionMail($order, $product));
            Mail::to($vendor->email)->send(new VendorSaleMail($order, $product));

            return response()->json([
                'success' => true,
                'redirect' => route('payment.complete', ['reference' => $order->reference])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Payment verification error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    public function complete($reference)
    {
        $order = Order::where('reference', $reference)->firstOrFail();
        return view('payment.complete', compact('order'));
    }

    private function verifyFlutterwaveTransaction($transactionId, $expectedAmount, $expectedCurrency)
    {
        // TODO: Implement actual Flutterwave verification
        return true;
    }
}