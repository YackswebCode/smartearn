@extends('layouts.admin')

@section('title', 'Business Enrollments')

@push('styles')
<link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Course Enrollments</h2>
        <div>
            <a href="{{ route('admin.business-enrollments.index') }}" class="btn btn-outline-secondary btn-sm">All</a>
            <a href="{{ route('admin.business-enrollments.index', ['status' => 'active']) }}" class="btn btn-outline-success btn-sm">Active</a>
            <a href="{{ route('admin.business-enrollments.index', ['status' => 'completed']) }}" class="btn btn-outline-info btn-sm">Completed</a>
            <a href="{{ route('admin.business-enrollments.index', ['status' => 'cancelled']) }}" class="btn btn-outline-danger btn-sm">Cancelled</a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <table id="enrollmentsTable" class="table table-hover align-middle nowrap" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Course</th>
                        <th>Plan</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($enrollments as $e)
                    <tr>
                        <td>{{ $e->id }}</td>
                        <td>{{ $e->user->name }}<br><small>{{ $e->user->email }}</small></td>
                        <td>{{ $e->course->title }}</td>
                        <td>{{ ucfirst($e->plan) }}</td>
                        <td>{{ $e->currency }} {{ number_format($e->amount_paid, 2) }}</td>
                        <td>
                            @php
                                $badge = match($e->status) {
                                    'active' => 'bg-success',
                                    'completed' => 'bg-info',
                                    'cancelled' => 'bg-danger',
                                    default => 'bg-secondary'
                                };
                            @endphp
                            <span class="badge {{ $badge }}">{{ ucfirst($e->status) }}</span>
                        </td>
                        <td>{{ $e->start_date ? $e->start_date->format('M d, Y') : '—' }}</td>
                        <td>{{ $e->end_date ? $e->end_date->format('M d, Y') : '—' }}</td>
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
    $('#enrollmentsTable').DataTable({ order: [[0, 'desc']] });
</script>
@endpush