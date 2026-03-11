@extends('layouts.admin')

@section('title', 'Withdrawals')

@push('styles')
<link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Withdrawal Requests</h2>
        <div class="d-flex flex-wrap gap-2">
            <!-- Status filters -->
            <div class="btn-group me-2" role="group">
                <a href="{{ route('admin.withdrawals.index') }}" class="btn btn-outline-secondary btn-sm {{ !request('status') && !request('type') ? 'active' : '' }}">All</a>
                <a href="{{ route('admin.withdrawals.index', ['status' => 'pending']) }}" class="btn btn-outline-warning btn-sm {{ request('status') == 'pending' ? 'active' : '' }}">Pending</a>
                <a href="{{ route('admin.withdrawals.index', ['status' => 'approved']) }}" class="btn btn-outline-success btn-sm {{ request('status') == 'approved' ? 'active' : '' }}">Approved</a>
                <a href="{{ route('admin.withdrawals.index', ['status' => 'rejected']) }}" class="btn btn-outline-danger btn-sm {{ request('status') == 'rejected' ? 'active' : '' }}">Rejected</a>
            </div>
            <!-- Type filters -->
            <div class="btn-group" role="group">
                <a href="{{ route('admin.withdrawals.index', ['type' => 'affiliate']) }}" class="btn btn-outline-info btn-sm {{ request('type') == 'affiliate' ? 'active' : '' }}">Affiliate</a>
                <a href="{{ route('admin.withdrawals.index', ['type' => 'vendor']) }}" class="btn btn-outline-info btn-sm {{ request('type') == 'vendor' ? 'active' : '' }}">Vendor</a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <table id="withdrawalsTable" class="table table-hover align-middle nowrap" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Account Details</th>
                        <th>Status</th>
                        <th>Requested</th>
                        <th>Processed</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($withdrawals as $w)
                    <tr>
                        <td>{{ $w->id }}</td>
                        <td>{{ $w->user->name }}<br><small>{{ $w->user->email }}</small></td>
                        <td><span class="badge bg-secondary">{{ ucfirst($w->type) }}</span></td>
                        <td>{{ $w->currency }} {{ number_format($w->amount, 2) }}</td>
                        <td>
                            @php
                                $details = $w->account_details;
                            @endphp
                            @if($details && isset($details['bank_name']))
                                {{ $details['bank_name'] }}<br>
                                {{ $details['account_number'] ?? '' }}
                            @else
                                <span class="text-muted">{{ is_array($details) ? 'Details saved' : 'No details' }}</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $badge = match($w->status) {
                                    'approved' => 'bg-success',
                                    'rejected' => 'bg-danger',
                                    default => 'bg-warning'
                                };
                            @endphp
                            <span class="badge {{ $badge }}">{{ ucfirst($w->status) }}</span>
                        </td>
                        <td>{{ $w->created_at->format('M d, Y') }}</td>
                        <td>{{ $w->processed_at ? $w->processed_at->format('M d, Y') : '—' }}</td>
                        <td>
                            <a href="{{ route('admin.withdrawals.show', $w) }}" class="btn btn-sm btn-outline-info" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if($w->status === 'pending')
                                <form action="{{ route('admin.withdrawals.approve', $w) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Approve" onclick="return confirm('Approve this withdrawal?')">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                <button type="button" class="btn btn-sm btn-outline-danger" title="Reject" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $w->id }}">
                                    <i class="fas fa-times"></i>
                                </button>

                                <!-- Reject Modal -->
                                <div class="modal fade" id="rejectModal{{ $w->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('admin.withdrawals.reject', $w) }}" method="POST">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Reject Withdrawal #{{ $w->id }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <label for="note{{ $w->id }}" class="form-label">Admin Note (optional)</label>
                                                    <textarea name="admin_note" id="note{{ $w->id }}" rows="3" class="form-control" placeholder="Reason for rejection..."></textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger">Reject</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#withdrawalsTable').DataTable({
            responsive: true,
            order: [[0, 'desc']],
            columnDefs: [
                { targets: [8], orderable: false, searchable: false } // actions column index changed
            ]
        });
    });
</script>
@endpush