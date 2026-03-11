@extends('layouts.admin')

@section('title', 'Skill Garage - Enrollments')

@push('styles') ... @endpush

@section('content')
<div class="container-fluid py-4">
    <h2 class="fw-bold mb-4">Enrollments</h2>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <table id="enrollmentsTable" class="table table-hover align-middle nowrap" style="width:100%">
                <thead class="table-light">
                    <tr><th>ID</th><th>User</th><th>Track</th><th>Plan</th><th>Amount</th><th>Status</th><th>Start</th><th>End</th></tr>
                </thead>
                <tbody>
                @foreach($enrollments as $e)
                    <tr>
                        <td>{{ $e->id }}</td>
                        <td>{{ $e->user->name }}</td>
                        <td>{{ $e->track->name }}</td>
                        <td>{{ ucfirst($e->plan) }}</td>
                        <td>{{ $e->currency }} {{ number_format($e->amount_paid,2) }}</td>
                        <td><span class="badge bg-{{ $e->status=='active'?'success':($e->status=='cancelled'?'danger':'secondary') }}">{{ ucfirst($e->status) }}</span></td>
                        <td>{{ $e->start_date?->format('Y-m-d') }}</td>
                        <td>{{ $e->end_date?->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>$(document).ready(function(){ $('#enrollmentsTable').DataTable({ order:[[0,'desc']] }); });</script>
@endpush