@extends('layouts.admin')

@section('title', 'Vendors')

@push('styles')
<link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Vendors</h2>
        <div>
            <a href="{{ route('admin.vendors.index', ['status' => 'Pending']) }}" class="btn btn-outline-warning btn-sm">Pending</a>
            <a href="{{ route('admin.vendors.index', ['status' => 'Active']) }}" class="btn btn-outline-success btn-sm">Active</a>
            <a href="{{ route('admin.vendors.index', ['status' => 'Reject']) }}" class="btn btn-outline-danger btn-sm">Rejected</a>
            <a href="{{ route('admin.vendors.index') }}" class="btn btn-outline-secondary btn-sm">All</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <table id="vendorsTable" class="table table-hover align-middle nowrap" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Profile</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Business</th>
                        <th>Status</th>
                        <th>Products</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vendors as $vendor)
                    <tr>
                        <td>{{ $vendor->id }}</td>
                        <td>
                            @if($vendor->profile_image)
                                <img src="{{ asset('storage/'.$vendor->profile_image) }}" class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                            @else
                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white" style="width:40px;height:40px;">
                                    {{ strtoupper(substr($vendor->name, 0, 1)) }}
                                </div>
                            @endif
                        </td>
                        <td>{{ $vendor->name }}</td>
                        <td>{{ $vendor->email }}</td>
                        <td>{{ $vendor->business_name ?? '—' }}</td>
                        <td>
                            @php
                                $badge = match($vendor->vendor_status) {
                                    'Active' => 'bg-success',
                                    'Pending' => 'bg-warning',
                                    'Reject' => 'bg-danger',
                                    default => 'bg-secondary'
                                };
                            @endphp
                            <span class="badge {{ $badge }}">{{ $vendor->vendor_status }}</span>
                        </td>
                        <td>{{ $vendor->products_count }}</td>
                        <td>{{ $vendor->created_at->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('admin.vendors.show', $vendor) }}" class="btn btn-sm btn-outline-info" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if($vendor->vendor_status === 'Pending')
                                <form action="{{ route('admin.vendors.approve', $vendor) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Approve">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.vendors.reject', $vendor) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Reject" onclick="return confirm('Reject this vendor application?')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
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
        $('#vendorsTable').DataTable({
            responsive: true,
            order: [[0, 'desc']],
            columnDefs: [
                { targets: [1,8], orderable: false, searchable: false }
            ]
        });
    });
</script>
@endpush