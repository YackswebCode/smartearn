@extends('layouts.affiliate')

@section('title', $faculty->name)

@section('content')
<div class="container-fluid py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('affiliate.skill_garage') }}">Digital University</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $faculty->name }}</li>
        </ol>
    </nav>

    <div class="mb-4">
        <h2 class="fw-bold">{{ $faculty->name }}</h2>
        <p class="text-muted">{{ $faculty->description }}</p>
    </div>

    <div class="row g-4">
        @foreach($faculty->tracks as $track)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm p-3">
                <div class="skill-image mb-3 bg-light d-flex align-items-center justify-content-center" style="height: 140px; border-radius: 8px;">
                    @if($track->image)
                        <img src="{{ asset('storage/'.$track->image) }}" class="img-fluid rounded" style="height: 100%; object-fit: cover;">
                    @else
                        <i class="fas fa-graduation-cap fa-3x text-muted"></i>
                    @endif
                </div>
                <h5 class="fw-bold">{{ $track->name }}</h5>
                <p class="text-muted small">{{ Str::limit($track->description, 80) }}</p>
                <div class="mt-3">
                    <a href="{{ route('affiliate.skill_garage.track', $track->id) }}" class="btn btn-outline-success w-100">View Details</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection