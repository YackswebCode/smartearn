@extends('layouts.affiliate')

@section('title', 'My Digital Learning')

@section('content')
<div class="container-fluid py-4">
    <h2 class="fw-bold mb-1">My Digital Learning</h2>
    <p class="text-muted mb-4">Your active tracks and courses</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($enrollments->count())
        <div class="row g-4">
            @foreach($enrollments as $enrollment)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-success">{{ $enrollment->track->faculty->name }}</span>
                                <span class="badge bg-secondary">{{ ucfirst($enrollment->plan) }}</span>
                            </div>
                            <h5 class="fw-bold">{{ $enrollment->track->title }}</h5>
                            <p class="text-muted small">{{ $enrollment->track->instructors }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">Ends: {{ $enrollment->end_date->format('M d, Y') }}</small>
                                <a href="{{ route('affiliate.digital.learning.track', $enrollment->id) }}" class="btn btn-outline-success btn-sm">Continue Learning</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-book-open fa-4x text-muted mb-3"></i>
            <h5>No active enrollments yet</h5>
            <a href="{{ route('affiliate.digital_university') }}" class="btn btn-success mt-3">Browse Digital University</a>
        </div>
    @endif
</div>
@endsection