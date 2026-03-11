@extends('layouts.admin')

@section('title', 'Withdrawal Receipt')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Withdrawal Receipt #{{ $withdrawal->id }}</h2>
        <a href="{{ route('admin.withdrawals.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Withdrawals
        </a>
    </div>

    <div class="row">
        <!-- Receipt Card -->
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-lg" style="background: #fafafa; border-radius: 20px;">
                <!-- Header with SmartEarn branding -->
                <div class="card-header bg-white border-0 pt-4 px-4" style="border-radius: 20px 20px 0 0;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="fw-bold text-success" style="font-size: 1.5rem;">SmartEarn</span>
                            <p class="text-muted small mb-0">Withdrawal Receipt</p>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-success p-2 px-3 rounded-pill">#{{ $withdrawal->id }}</span>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Status Badge -->
                    <div class="text-center mb-4">
                        @php
                            $badgeClass = match($withdrawal->status) {
                                'approved' => 'bg-success',
                                'rejected' => 'bg-danger',
                                default => 'bg-warning'
                            };
                            $statusText = match($withdrawal->status) {
                                'approved' => '✓ Approved',
                                'rejected' => '✗ Rejected',
                                default => '⏳ Pending'
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }} p-3 px-4 rounded-pill fs-6">{{ $statusText }}</span>
                    </div>

                    <!-- Amount Display -->
                    <div class="text-center mb-4">
                        <small class="text-muted text-uppercase tracking-wide">Amount</small>
                        <h1 class="display-4 fw-bold" style="font-family: 'Courier New', monospace;">
                            {{ $withdrawal->currency }} {{ number_format($withdrawal->amount, 2) }}
                        </h1>
                    </div>

                    <!-- Details Grid (Receipt Style) -->
                    <div class="row g-3 mb-4">
                        <div class="col-sm-6">
                            <div class="border-bottom pb-2">
                                <small class="text-muted">User</small>
                                <p class="fw-semibold mb-0">{{ $withdrawal->user->name }}</p>
                                <small class="text-muted">{{ $withdrawal->user->email }}</small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="border-bottom pb-2">
                                <small class="text-muted">Type</small>
                                <p class="fw-semibold mb-0">{{ ucfirst($withdrawal->type) }}</p>
                                <small class="text-muted">Balance source</small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="border-bottom pb-2">
                                <small class="text-muted">Requested On</small>
                                <p class="fw-semibold mb-0">{{ $withdrawal->created_at->format('M d, Y') }}</p>
                                <small class="text-muted">{{ $withdrawal->created_at->format('h:i A') }}</small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="border-bottom pb-2">
                                <small class="text-muted">Processed On</small>
                                <p class="fw-semibold mb-0">{{ $withdrawal->processed_at ? $withdrawal->processed_at->format('M d, Y') : '—' }}</p>
                                <small class="text-muted">{{ $withdrawal->processed_at ? $withdrawal->processed_at->format('h:i A') : '' }}</small>
                            </div>
                        </div>
                    </div>

                    <!-- Account Details (JSON) -->
                    <div class="bg-light p-3 rounded-3 mb-4">
                        <h6 class="fw-bold mb-3"><i class="fas fa-university me-2"></i>Account Details</h6>
                        @php $details = $withdrawal->account_details; @endphp
                        @if($details)
                            <div class="row small">
                                @if(isset($details['bank_name']))
                                    <div class="col-6 mb-2"><span class="text-muted">Bank:</span> {{ $details['bank_name'] }}</div>
                                @endif
                                @if(isset($details['account_name']))
                                    <div class="col-6 mb-2"><span class="text-muted">Account Name:</span> {{ $details['account_name'] }}</div>
                                @endif
                                @if(isset($details['account_number']))
                                    <div class="col-6 mb-2"><span class="text-muted">Account Number:</span> {{ $details['account_number'] }}</div>
                                @endif
                                @if(isset($details['momo_provider']))
                                    <div class="col-6 mb-2"><span class="text-muted">Momo Provider:</span> {{ $details['momo_provider'] }}</div>
                                @endif
                                @if(isset($details['momo_number']))
                                    <div class="col-6 mb-2"><span class="text-muted">Momo Number:</span> {{ $details['momo_number'] }}</div>
                                @endif
                            </div>
                        @else
                            <p class="text-muted small mb-0">No account details stored.</p>
                        @endif
                    </div>

                    <!-- Admin Note (if any) -->
                    @if($withdrawal->admin_note)
                        <div class="bg-warning bg-opacity-10 p-3 rounded-3 mb-4">
                            <h6 class="fw-bold mb-2"><i class="fas fa-sticky-note me-2"></i>Admin Note</h6>
                            <p class="mb-0">{{ $withdrawal->admin_note }}</p>
                        </div>
                    @endif

                    <!-- Balance Information (only if approved, show updated balances) -->
                    @if($withdrawal->status === 'approved')
                        <div class="alert alert-success rounded-3 mb-0">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Balance updated:</strong>
                            The {{ $withdrawal->type }} balance has been deducted.
                            @if($withdrawal->type === 'affiliate')
                                New affiliate balance: {{ $withdrawal->user->currency ?? 'NGN' }} {{ number_format($withdrawal->user->affiliate_balance, 2) }}
                            @elseif($withdrawal->type === 'vendor')
                                New vendor balance: {{ $withdrawal->user->currency ?? 'NGN' }} {{ number_format($withdrawal->user->vendor_balance, 2) }}
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Footer with actions (if pending) -->
                @if($withdrawal->status === 'pending')
                <div class="card-footer bg-white border-0 p-4 pt-0 d-flex justify-content-end gap-2">
                    <form action="{{ route('admin.withdrawals.approve', $withdrawal) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success px-4" onclick="return confirm('Approve this withdrawal? This will deduct from user\'s balance.')">
                            <i class="fas fa-check me-2"></i>Approve
                        </button>
                    </form>
                    <button type="button" class="btn btn-outline-danger px-4" data-bs-toggle="modal" data-bs-target="#rejectModal">
                        <i class="fas fa-times me-2"></i>Reject
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.withdrawals.reject', $withdrawal) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Reject Withdrawal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label for="admin_note" class="form-label">Admin Note (optional)</label>
                    <textarea name="admin_note" id="admin_note" rows="3" class="form-control" placeholder="Reason for rejection..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection