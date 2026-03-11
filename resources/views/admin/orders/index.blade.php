@extends('layouts.admin')

@section('title', 'Orders')

@push('styles')
<link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">All Orders</h2>
        <div>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm">All</a>
            <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="btn btn-outline-warning btn-sm">Pending</a>
            <a href="{{ route('admin.orders.index', ['status' => 'completed']) }}" class="btn btn-outline-success btn-sm">Completed</a>
            <a href="{{ route('admin.orders.index', ['status' => 'failed']) }}" class="btn btn-outline-danger btn-sm">Failed</a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <table id="ordersTable" class="table table-hover align-middle nowrap" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Reference</th>
                        <th>Buyer</th>
                        <th>Product</th>
                        <th>Affiliate</th>
                        <th>Vendor</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->reference }}</td>
                        <td>{{ $order->buyer_name }}<br><small>{{ $order->buyer_email }}</small></td>
                        <td>{{ $order->product->name ?? 'N/A' }}</td>
                        <td>{{ $order->affiliate->name ?? 'N/A' }}</td>
                        <td>{{ $order->vendor->business_name ?? $order->vendor->name ?? 'N/A' }}</td>
                        <td>{{ $order->currency }} {{ number_format($order->amount, 2) }}</td>
                        <td>
                            @php
                                $badge = match($order->status) {
                                    'completed' => 'bg-success',
                                    'pending' => 'bg-warning',
                                    'failed' => 'bg-danger',
                                    default => 'bg-secondary'
                                };
                            @endphp
                            <span class="badge {{ $badge }}">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
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
        $('#ordersTable').DataTable({
            responsive: true,
            order: [[0, 'desc']],
            language: {
                search: "Search:",
                emptyTable: "No orders found"
            }
        });
    });
</script>
@endpush