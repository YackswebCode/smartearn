@extends('layouts.customer')

@section('title', 'My Purchases')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">My Purchases</h2>
            <p class="text-muted">All your transactions and purchased items</p>
        </div>
        <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-secondary">
            ← Back to Dashboard
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Item</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                  <tbody>
    @forelse($purchases as $purchase)
        <tr>
            <td>{{ $purchase->created_at->format('M d, Y H:i') }}</td>
            <td>{{ $purchase->track->title ?? 'N/A' }}</td>
            <td>{{ $purchase->currency }} {{ number_format($purchase->amount_paid, 2) }}</td>
            <td>Wallet</td>
            <td><span class="badge bg-success">{{ ucfirst($purchase->plan) }}</span></td>
            <td>
                <a href="{{ route('affiliate.digital.my.learning') }}" class="text-success small">View Track</a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="text-center py-4 text-muted">No purchases found.</td>
        </tr>
    @endforelse
</tbody>
                </table>
            </div>
            <div class="p-3 d-flex justify-content-center">
                {{ $purchases->links() }}
            </div>
        </div>
    </div>
</div>
@endsection