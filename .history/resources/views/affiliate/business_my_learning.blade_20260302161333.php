@extends('layouts.affiliate')

@section('title', 'My Business Learning')

@section('content')
<div class="container-fluid py-4">
    <h2 class="fw-bold mb-4">My Business Courses</h2>
    <div class="row">
        @forelse($enrollments as $enrollment)
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold">{{ $enrollment->course->title }}</h5>
                    <p class="text-muted">{{ $enrollment->course->faculty->name }}</p>
                    <p class="small">Enrolled: {{ $enrollment->created_at->format('M d, Y') }}</p>
                    <a href="{{ route('affiliate.business.learning.course', $enrollment->id) }}" class="btn btn-success mt-2">Continue Learning</a>
                </div>
            </div>
        </div>
        @empty
        <p class="text-muted">You haven't enrolled in any business courses yet.</p>
        @endforelse
    </div>
</div>
@endsection