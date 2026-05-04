@extends('layouts.admin')
@section('title', 'Digital University - Enrollments')
@section('content')
<div class="container-fluid py-4">
    <h2 class="fw-bold mb-4">Enrollments</h2>
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>User</th>
                        <th>Track</th>
                        <th>Plan</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Start</th>
                        <th>End</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($enrollments as $enr)
                    <tr>
                        <td>{{ $enr->user->name ?? 'N/A' }}</td>
                        <td>{{ $enr->track->title ?? 'N/A' }}</td>
                        <td>{{ ucfirst($enr->plan) }}</td>
                        <td>{{ $enr->currency }} {{ number_format($enr->amount_paid, 2) }}</td>
                        <td><span class="badge bg-{{ $enr->status == 'active' ? 'success' : 'secondary' }}">{{ $enr->status }}</span></td>
                        <td>{{ $enr->start_date?->format('M d, Y') }}</td>
                        <td>{{ $enr->end_date?->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $enrollments->links() }}
        </div>
    </div>
</div>
@endsection