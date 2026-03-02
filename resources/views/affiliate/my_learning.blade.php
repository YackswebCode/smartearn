@extends('layouts.affiliate')

@section('title', 'My Learning')

@section('content')
<div class="container-fluid py-4">
    <h2 class="fw-bold mb-4">My Learning</h2>
    <div class="row">
        @forelse($enrollments as $enrollment)
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold">{{ $enrollment->track->name }}</h5>
                    <p class="text-muted">{{ $enrollment->track->faculty->name }}</p>
                    <p class="small">Enrolled: {{ $enrollment->created_at->format('M d, Y') }}</p>
                    <p class="small">Plan: {{ ucfirst($enrollment->plan) }}</p>
                    <a href="{{ route('affiliate.learning.track', $enrollment->track->id) }}" class="btn btn-success mt-2">Start Learning</a>
                </div>
            </div>
        </div>
        @empty
        <p class="text-muted">You haven't enrolled in any tracks yet.</p>
        @endforelse
    </div>
</div>
@endsection