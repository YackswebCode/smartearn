@extends('layouts.admin')

@section('title', 'Commissions')

@push('styles')
<link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Commissions</h2>
        <div>
            <a href="{{ route('admin.commissions.index') }}" class="btn btn-outline-secondary btn-sm">All</a>
            <a href="{{ route('admin.commissions.index', ['type' => 'affiliate']) }}" class="btn btn-outline-primary btn-sm">Affiliate</a>
            <a href="{{ route('admin.commissions.index', ['type' => 'vendor']) }}" class="btn btn-outline-success btn-sm">Vendor</a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <table id="commissionsTable" class="table table-hover align-middle nowrap" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Order Ref</th>
                        <th>Type</th>
                        <th>Recipient</th>
                        <th>Amount</th>
                        <th>Currency</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($commissions as $c)
                    <tr>
                        <td>{{ $c->id }}</td>
                        <td>{{ $c->order->reference ?? 'N/A' }}</td>
                        <td>
                            <span class="badge {{ $c->type == 'affiliate' ? 'bg-primary' : 'bg-success' }}">
                                {{ ucfirst($c->type) }}
                            </span>
                        </td>
                        <td>
                            @if($c->type == 'affiliate' && $c->affiliate)
                                {{ $c->affiliate->name }}<br><small>{{ $c->affiliate->email }}</small>
                            @elseif($c->type == 'vendor' && $c->vendor)
                                {{ $c->vendor->business_name ?? $c->vendor->name }}<br><small>{{ $c->vendor->email }}</small>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>{{ number_format($c->amount, 2) }}</td>
                        <td>{{ $c->currency }}</td>
                        <td>{{ $c->created_at->format('M d, Y H:i') }}</td>
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
        $('#commissionsTable').DataTable({
            responsive: true,
            order: [[0, 'desc']],
            columnDefs: [
                { targets: [1,3], orderable: false } // order ref and recipient
            ]
        });
    });
</script>
@endpush