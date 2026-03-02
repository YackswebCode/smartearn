@extends('layouts.affiliate')

@section('title', 'Digital University')

@section('content')
<div class="container-fluid py-4">
    <!-- Hero Section (same design) -->
    <div class="bg-teal p-5 rounded-4 mb-5 text-white position-relative" style="background-color: #065754 !important;">
        <div class="row align-items-center">
            <div class="col-md-7">
                <h1 class="display-4 fw-bold">Welcome to Digital University</h1>
                <div class="bg-white p-4 rounded-3 mt-4" style="max-width: 500px; border-right: 4px solid #d4edda; border-bottom: 4px solid #d4edda;">
                    <h3 class="text-dark fw-semibold">Learning that makes you</h3>
                    <p class="text-dark mb-0">Competencies for the present and the future. Join us now.</p>
                </div>
            </div>
            <div class="col-md-5 d-flex justify-content-center justify-content-md-end mt-4 mt-md-0">
                <div class="gear-card w-100" style="max-width: 300px; background-color: #d4edda; border-right: 4px solid white; border-bottom: 4px solid white; border-radius: 20px; padding: 1.5rem; display: flex; align-items: center; justify-content: space-between; color: #065754;">
                    <i class="fas fa-cog fa-2x"></i>
                    <i class="fas fa-cog fa-2x"></i>
                    <i class="fas fa-cog fa-2x"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-4 text-center text-md-start">
        <h2 class="fw-bold text-dark">Choose your faculty</h2>
        <p class="text-success fs-5">Select a faculty to explore learning tracks.</p>
    </div>

    <div class="row g-4">
        @foreach($faculties as $faculty)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm p-3">
                <div class="d-flex align-items-center mb-3">
                    <i class="{{ $faculty->icon }} fa-2x me-3" style="color: #065754;"></i>
                    <h5 class="fw-bold mb-0">{{ $faculty->name }}</h5>
                </div>
                <p class="text-muted small">{{ $faculty->description }}</p>
                <a href="{{ route('affiliate.skill_garage.faculty', $faculty->id) }}" class="btn btn-outline-success mt-3">View Tracks</a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection