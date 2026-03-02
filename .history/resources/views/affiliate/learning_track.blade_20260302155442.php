@extends('layouts.affiliate')

@section('title', $track->name)

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm p-4">
                <h2 class="fw-bold">{{ $track->name }}</h2>
                <p>{{ $track->description }}</p>
                <hr>
                <h4>Course Content</h4>
                <p>Video lectures and materials will be available soon. Check back later!</p>
                <!-- In future, list modules/lectures here -->
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-4 sticky-top" style="top: 20px;">
                <h5>About this track</h5>
                <p><strong>Faculty:</strong> {{ $track->faculty->name }}</p>
                <p><strong>Enrolled:</strong> {{ $enrollment->created_at->format('M d, Y') }}</p>
                <p><strong>Plan:</strong> {{ ucfirst($enrollment->plan) }}</p>
                <p><strong>Status:</strong> <span class="badge bg-success">Active</span></p>
            </div>
        </div>
    </div>
</div>
@endsection