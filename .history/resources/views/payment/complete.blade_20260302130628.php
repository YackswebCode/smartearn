@extends('layouts.app')

@section('title', 'Payment Successful')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-success text-white text-center py-4">
                    <h3 class="mb-0"><i class="fas fa-check-circle me-2"></i>Payment Successful!</h3>
                </div>
                <div class="card-body p-4">
                    <p class="lead">Thank you for your purchase!</p>
                    <p>Your order has been confirmed. You will receive an email with the product details shortly at <strong>{{ $order->buyer_email }}</strong>.</p>

                    <hr>

                    <h5>Order Summary</h5>
                    <ul class="list-unstyled">
                        <li><strong>Order Reference:</strong> {{ $order->reference }}</li>
                        <li><strong>Product:</strong> {{ $order->product->name }}</li>
                        <li><strong>Amount:</strong> ₦{{ number_format($order->amount, 2) }}</li>
                        <li><strong>Date:</strong> {{ $order->created_at->format('M d, Y. h:i A') }}</li>
                    </ul>

                    <div class="text-center mt-4">
                        <a href="/" class="btn btn-outline-primary">Return to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection