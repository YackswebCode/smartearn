@extends('layouts.affiliate')

@section('title', 'Skill Garage')

@section('content')
<style>
    .bg-teal {
        background-color: #065754 !important;
    }
    .border-light-green {
        border-color: #d4edda !important; /* light green */
    }
    .border-light-green-right-bottom {
        border-right: 4px solid #d4edda;
        border-bottom: 4px solid #d4edda;
    }
    .gear-card {
        background-color: #d4edda; /* light green */
        border-right: 4px solid white;
        border-bottom: 4px solid white;
        border-radius: 20px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: #065754;
    }
    .gear-card i {
        font-size: 2.5rem;
    }
    .rating i {
        color: #ffc107;
    }
    .skill-image {
        width: 100%;
        height: 140px;
        object-fit: cover;
        border-radius: 8px;
        background-color: #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #aaa;
        font-size: 2rem;
    }
</style>

<div class="container-fluid py-4">
    <!-- Hero Section with Teal Background -->
    <div class="bg-teal p-5 rounded-4 mb-5 text-white position-relative">
        <div class="row align-items-center">
            <!-- Left Column: Text and White Card -->
            <div class="col-md-7">
                <h1 class="display-4 fw-bold">Welcome to Smartearn Skill Garage</h1>
                <!-- White Card with border right/bottom -->
                <div class="bg-white p-4 rounded-3 mt-4 border-light-green-right-bottom" style="max-width: 500px;">
                    <h3 class="text-dark fw-semibold">Learning that makes you</h3>
                    <p class="text-dark mb-0">Competencies for the present and the future. Join us now.</p>
                </div>
            </div>

            <!-- Right Column: Single Card with Three Gear Icons -->
            <div class="col-md-5 d-flex justify-content-center justify-content-md-end mt-4 mt-md-0">
                <div class="gear-card w-100" style="max-width: 300px;">
                    <i class="fas fa-cog"></i>
                    <i class="fas fa-cog"></i>
                    <i class="fas fa-cog"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Heading and Subheading -->
    <div class="mb-4 text-center text-md-start">
        <h2 class="fw-bold text-dark">Apply for the skill that best suits you.</h2>
        <p class="text-success fs-5">Smartearn supports your professional development with critical skills and technical topics.</p>
    </div>

    <!-- Two Buttons (Available Skills / Enrolled Skill sets) -->
    <div class="d-flex gap-3 mb-5">
        <a href="#" class="btn btn-success px-4">Available Skills</a>
        <a href="#" class="btn btn-outline-success px-4">Enrolled Skill sets</a>
    </div>

    <!-- Skills Grid -->
    <div class="row g-4">
        @foreach($skills as $skill)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm p-3">
                <!-- Image Placeholder (replace with actual image when available) -->
                <div class="skill-image mb-3">
                    <i class="fas fa-image"></i>
                </div>
                <h5 class="fw-bold">{{ $skill['title'] }}</h5>
                <p class="text-muted small mb-2">{{ $skill['instructors'] }}</p>
                <div class="d-flex align-items-center mb-2">
                    <span class="fw-bold me-2">{{ $skill['rating'] }}</span>
                    <div class="rating">
                        @for($i=1; $i<=5; $i++)
                            @if($i <= floor($skill['rating']))
                                <i class="fas fa-star"></i>
                            @elseif($i == ceil($skill['rating']) && $skill['rating'] - floor($skill['rating']) >= 0.5)
                                <i class="fas fa-star-half-alt"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="text-muted small ms-2">({{ number_format($skill['reviews']) }})</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <span class="fw-bold fs-5">{{ $skill['currency'] }} {{ number_format($skill['price']) }}</span>
                    <a href="#" class="btn btn-outline-success btn-sm">Enroll</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-5">
        <nav aria-label="Skill pagination">
            <ul class="pagination">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                </li>
                <li class="page-item active" aria-current="page"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</div>
@endsection