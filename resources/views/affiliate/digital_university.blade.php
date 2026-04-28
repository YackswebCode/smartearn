@extends('layouts.affiliate')

@section('title', 'Digital University')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h2 class="fw-bold">Digital University</h2>
        <p class="text-muted">Choose your learning path</p>
    </div>

    <div class="row g-4 justify-content-center">
        <!-- Skill Garage Card -->
        <div class="col-md-5">
            <a href="{{ route('affiliate.skill_garage') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-card">
                    <div class="card-body text-center p-5">
                        <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                            <i class="fas fa-laptop-code fs-2" style="color: var(--primary-green);"></i>
                        </div>
                        <h4 class="fw-bold" style="color: var(--primary-green);">Skill Garage</h4>
                        <p class="text-muted">Tech skills, coding, design & more. Practical, job‑ready learning.</p>
                        <span class="btn btn-outline-success mt-2">Explore Skill Garage <i class="fas fa-arrow-right ms-1"></i></span>
                    </div>
                </div>
            </a>
        </div>

        <!-- Business University Card -->
        <div class="col-md-5">
            <a href="{{ route('affiliate.business_university') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-card">
                    <div class="card-body text-center p-5">
                        <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                            <i class="fas fa-graduation-cap fs-2" style="color: var(--primary-green);"></i>
                        </div>
                        <h4 class="fw-bold" style="color: var(--primary-green);">Business University</h4>
                        <p class="text-muted">Entrepreneurship, marketing, sales & strategy. Build your business.</p>
                        <span class="btn btn-outline-success mt-2">Enter Business University <i class="fas fa-arrow-right ms-1"></i></span>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .hover-card {
        transition: transform 0.2s, box-shadow 0.2s;
        cursor: pointer;
        border-radius: 16px;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(6, 87, 84, 0.15);
    }
</style>
@endpush