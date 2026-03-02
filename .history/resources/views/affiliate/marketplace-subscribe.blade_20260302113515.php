@extends('layouts.affiliate')

@section('title', 'Subscribe to Marketplace')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-success text-white text-center py-3">
                <h4 class="mb-0"><i class="fas fa-store me-2"></i>Access Marketplace</h4>
            </div>
            <div class="card-body p-4">
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <p class="text-center">To browse and promote products, you need to pay a yearly subscription fee of <strong>₦5,000</strong>.</p>
                <div class="bg-light p-3 rounded mb-4">
                    <div class="d-flex justify-content-between">
                        <span>Your wallet balance:</span>
                        <strong class="text-success">₦{{ number_format($user->wallet_balance, 2) }}</strong>
                    </div>
                </div>
                @if($user->wallet_balance >= 5000)
                    <form method="POST" action="{{ route('affiliate.marketplace.subscribe') }}">
                        @csrf
                        <button type="submit" class="btn btn-success btn-lg w-100">
                            <i class="fas fa-lock-open me-2"></i> Pay ₦5,000 from Wallet
                        </button>
                    </form>
                @else
                    <div class="alert alert-warning text-center mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Insufficient balance. Please <a href="{{ route('affiliate.add_funds') }}" class="alert-link">add funds</a> to your wallet.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection