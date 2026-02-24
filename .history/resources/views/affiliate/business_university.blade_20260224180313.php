@extends('layouts.affiliate')

@section('title', 'Business University')

@section('content')
<style>
    .bg-teal {
        background-color: #065754 !important;
    }
    .border-light-green-right-bottom {
        border-right: 4px solid #d4edda;
        border-bottom: 4px solid #d4edda;
    }
    .grad-card {
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
    .grad-card i {
        font-size: 2.5rem;
    }
    .faculty-chip {
        background-color: #e9ecef;
        color: #065754;
        padding: 0.5rem 1.2rem;
        border-radius: 30px;
        font-weight: 500;
        font-size: 0.9rem;
        white-space: nowrap;
    }
    .rating i {
        color: #ffc107;
    }
    .course-image {
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
                <h1 class="display-4 fw-bold">Welcome to Smartearn Business University</h1>
                <!-- White Card with border right/bottom -->
                <div class="bg-white p-4 rounded-3 mt-4 border-light-green-right-bottom" style="max-width: 500px;">
                    <h3 class="text-dark fw-semibold">Learning that makes you</h3>
                    <p class="text-dark mb-0">Competencies for the present and the future. Join us now.</p>
                </div>
            </div>

            <!-- Right Column: Single Card with Three Graduation Icons -->
            <div class="col-md-5 d-flex justify-content-center justify-content-md-end mt-4 mt-md-0">
                <div class="grad-card w-100" style="max-width: 300px;">
                    <i class="fas fa-user-graduate"></i>
                    <i class="fas fa-user-graduate"></i>
                    <i class="fas fa-user-graduate"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Heading and Subheading -->
    <div class="mb-4 text-center text-md-start">
        <h2 class="fw-bold text-dark">Apply for any business under the Faculties</h2>
        <p class="text-success fs-5">Smartearn supports your professional development with critical skills and technical topics.</p>
    </div>

    <!-- Faculty Chips (scrollable horizontally on mobile) -->
    <div class="d-flex gap-2 mb-5 overflow-auto pb-2">
        @foreach($faculties as $faculty)
            <span class="faculty-chip">{{ $faculty }}</span>
        @endforeach
    </div>

    <!-- Courses Grid -->
    <div class="row g-4">
    @foreach($courses as $course)
<div class="col-md-6 col-lg-4">
    <div class="card h-100 border-0 shadow-sm p-3">
        <!-- Course Image Placeholder -->
        <div class="course-image mb-3">
            <i class="fas fa-image"></i>
        </div>
        <h5 class="fw-bold">{{ $course['title'] }}</h5>
        <p class="text-muted small mb-2">{{ $course['instructors'] }}</p>
        <div class="d-flex align-items-center mb-2">
            <span class="fw-bold me-2">{{ $course['rating'] }}</span>
            <div class="rating">
                @for($i=1; $i<=5; $i++)
                    @if($i <= floor($course['rating']))
                        <i class="fas fa-star"></i>
                    @elseif($i == ceil($course['rating']) && $course['rating'] - floor($course['rating']) >= 0.5)
                        <i class="fas fa-star-half-alt"></i>
                    @else
                        <i class="far fa-star"></i>
                    @endif
                @endfor
            </div>
            <span class="text-muted small ms-2">({{ number_format($course['reviews']) }})</span>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-3">
            <span class="fw-bold fs-5">{{ $course['currency'] }} {{ number_format($course['price']) }}</span>
            <a href="{{ route('affiliate.course.show', ['slug' => \Str::slug($course['title'])]) }}" class="btn btn-outline-success btn-sm">Enroll</a>
        </div>
    </div>
</div>
@endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-5">
        <nav aria-label="Course pagination">
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