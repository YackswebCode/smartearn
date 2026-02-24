@extends('layouts.affiliate')

@section('title', $course->title)

@section('content')
<style>
    .rating i {
        color: #ffc107;
    }
    .discount-badge {
        background-color: #28a745;
        color: white;
        padding: 0.2rem 0.6rem;
        border-radius: 4px;
        font-size: 0.9rem;
        font-weight: 600;
    }
    .original-price {
        text-decoration: line-through;
        color: #6c757d;
        font-size: 1.2rem;
    }
    .current-price {
        font-size: 2rem;
        font-weight: 700;
        color: #333;
    }
    .time-left {
        background-color: #fff3cd;
        color: #856404;
        padding: 0.5rem;
        border-radius: 4px;
        text-align: center;
        font-weight: 600;
    }
    .includes-list {
        list-style: none;
        padding: 0;
    }
    .includes-list li {
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }
    .includes-list li i {
        color: #28a745;
        width: 1.5rem;
    }
    .section-item {
        border: 1px solid #dee2e6;
        border-radius: 6px;
        margin-bottom: 0.5rem;
    }
    .section-header {
        background-color: #d4edda; /* light green */
        padding: 0.75rem 1rem;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
        border-radius: 6px 6px 0 0;
    }
    .section-content {
        padding: 1rem;
    }
    .lecture-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        border-bottom: 1px solid #f1f1f1;
    }
    .lecture-item:last-child {
        border-bottom: none;
    }
    .preview-badge {
        color: #28a745;
        font-size: 0.85rem;
        margin-left: 0.5rem;
    }
    .duration {
        color: #6c757d;
        font-size: 0.9rem;
    }
    .green-card {
        background-color: #d4edda; /* light green */
        border: none;
        border-radius: 10px;
    }
    .green-card .card-body {
        padding: 1.5rem;
    }
</style>

<div class="container-fluid py-4">
    <div class="row">
        <!-- Main Content (Left Column) -->
        <div class="col-lg-8">
            <!-- Green Card for Course Info -->
            <div class="card green-card mb-4" style="background-color: #065754; color: white;">
                <div class="card-body">
                    <h1 class="fw-bold">{{ $course->title }}</h1>
                    <p class="text-white">{{ $course->description }}</p>

                    <!-- Rating & Stats -->
                    <div class="d-flex align-items-center flex-wrap gap-3 mb-3">
                        <div class="d-flex align-items-center">
                            <span class="fw-bold me-1">{{ $course->rating }}</span>
                            <div class="rating me-2">
                                @for($i=1; $i<=5; $i++)
                                    @if($i <= floor($course->rating))
                                        <i class="fas fa-star"></i>
                                    @elseif($i == ceil($course->rating) && $course->rating - floor($course->rating) >= 0.5)
                                        <i class="fas fa-star-half-alt"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-muted">({{ number_format($course->reviews_count) }} ratings)</span>
                        </div>
                        <span class="text-muted">{{ number_format($course->students_count) }} students</span>
                    </div>

                    <!-- Instructors & Meta -->
                    <p class="mb-2">
                        <strong>Created by</strong> {{ $course->instructors }}
                    </p>
                    <p class="mb-2">
                        <strong>Last Updated</strong> {{ $course->last_updated }}
                    </p>
                    <p class="mb-4">
                        <strong>Language</strong> {{ $course->language }}
                        <a href="#" class="btn btn-outline-secondary btn-sm ms-3">Preview This Course</a>
                    </p>
                </div>
            </div>

            <!-- What's Included (visible only on mobile, hidden on large screens because sidebar shows it) -->
            <div class="d-lg-none mb-4">
                <h5>This course includes:</h5>
                <ul class="includes-list">
                    @foreach($course->includes as $item)
                        <li><i class="fas fa-check-circle"></i> {{ $item }}</li>
                    @endforeach
                </ul>
            </div>

            <!-- Course Content -->
            <h4 class="fw-bold mb-3">Course Content</h4>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span>{{ count($course->sections) }} sections • 430 Lectures • 28h 11m total length</span>
                <a href="#" class="text-success">Expand All Sections</a>
            </div>

            <!-- Accordion Sections (green headers) -->
            <div class="accordion" id="courseAccordion">
                @foreach($course->sections as $index => $section)
                <div class="section-item">
                    <div class="section-header" style="background-color: #065754; color: white;" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="true">
                        <span>{{ $section['title'] }}</span>
                        <span>{{ $section['lectures'] }} Lectures • {{ $section['length'] }}</span>
                    </div>
                    <div id="collapse{{ $index }}" class="collapse show" data-bs-parent="#courseAccordion">
                        <div class="section-content">
                            @foreach($section['items'] as $lecture)
                            <div class="lecture-item">
                                <div>
                                    <i class="fas fa-play-circle text-success me-2"></i>
                                    {{ $lecture['title'] }}
                                    @if($lecture['preview'])
                                        <span class="preview-badge">Preview</span>
                                    @endif
                                </div>
                                <span class="duration">{{ $lecture['duration'] }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Sidebar (Right Column) – Green Card -->
        <div class="col-lg-4 mt-5 mb-5">
            <div class="card green-card sticky-lg-top" style="top: 2rem; background-color: #065754; color: white;">
                <div class="card-body">
                    <!-- Price and Discount -->
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <span class="current-price">{{ $course->currency ?? 'N' }}{{ number_format($course->discounted_price) }}</span>
                        <span class="original-price">{{ $course->currency ?? 'N' }}{{ number_format($course->price) }}</span>
                        <span class="discount-badge">{{ $course->discount_percent }}% off</span>
                    </div>
                    <div class="time-left mb-4">
                        <i class="far fa-clock me-1"></i> {{ $course->time_left }}
                    </div>

                    <!-- Buy Now Button -->
                    <a href="#" class="btn btn-success btn-lg w-100 mb-4">Buy Now</a>

                    <!-- This Course Includes -->
                    <h5 class="fw-semibold mb-3">This course includes:</h5>
                    <ul class="includes-list">
                        @foreach($course->includes as $item)
                            <li><i class="fas fa-check-circle text-success me-2"></i> {{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Bootstrap collapse works via data attributes
</script>
@endsection