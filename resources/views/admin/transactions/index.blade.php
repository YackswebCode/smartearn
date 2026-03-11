@extends('layouts.admin')

@section('title', 'Transactions')

@push('styles')
<link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">All Transactions</h2>
        <div class="d-flex gap-2 flex-wrap">
            <!-- Type Filters -->
            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    Filter by Type
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('admin.transactions.index') }}">All</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.transactions.index', ['type' => 'funding']) }}">Funding</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.transactions.index', ['type' => 'withdrawal']) }}">Withdrawal</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.transactions.index', ['type' => 'purchase']) }}">Purchase</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.transactions.index', ['type' => 'commission']) }}">Commission</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.transactions.index', ['type' => 'subscription']) }}">Subscription</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.transactions.index', ['type' => 'refund']) }}">Refund</a></li>
                </ul>
            </div>
            <!-- Status Filters -->
            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    Filter by Status
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('admin.transactions.index') }}">All</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.transactions.index', ['status' => 'completed']) }}">Completed</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.transactions.index', ['status' => 'pending']) }}">Pending</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.transactions.index', ['status' => 'failed']) }}">Failed</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <table id="transactionsTable" class="table table-hover align-middle nowrap" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Balance Type</th>
                        <th>Description</th>
                        <th>Reference</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $t)
                    <tr>
                        <td>{{ $t->id }}</td>
                        <td>{{ $t->user->name ?? 'N/A' }}<br><small>{{ $t->user->email ?? '' }}</small></td>
                        <td>
                            @php
                                $typeBadge = match($t->type) {
                                    'funding' => 'bg-success',
                                    'withdrawal' => 'bg-danger',
                                    'purchase' => 'bg-info',
                                    'commission' => 'bg-primary',
                                    'subscription' => 'bg-warning',
                                    'refund' => 'bg-secondary',
                                    default => 'bg-secondary'
                                };
                            @endphp
                            <span class="badge {{ $typeBadge }}">{{ ucfirst($t->type) }}</span>
                        </td>
                        <td>{{ $t->currency }} {{ number_format($t->amount, 2) }}</td>
                        <td>{{ ucfirst($t->balance_type) }}</td>
                        <td>{{ $t->description ?? '—' }}</td>
                        <td>{{ $t->reference ?? '—' }}</td>
                        <td>
                            @php
                                $statusBadge = match($t->status) {
                                    'completed' => 'bg-success',
                                    'pending' => 'bg-warning',
                                    'failed' => 'bg-danger',
                                    default => 'bg-secondary'
                                };
                            @endphp
                            <span class="badge {{ $statusBadge }}">{{ ucfirst($t->status) }}</span>
                        </td>
                        <td>{{ $t->created_at->format('M d, Y H:i') }}</td>
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
        $('#transactionsTable').DataTable({
            responsive: true,
            order: [[0, 'desc']],
            columnDefs: [
                { targets: [5,6], orderable: false } // description & reference
            ]
        });
    });
</script>
@endpush