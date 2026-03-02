@extends('layouts.affiliate')

@section('title', $course->title)

@section('content')
<style>
    .section-header {
        background-color: #065754;
        color: white;
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
    .section-item {
        border: 1px solid #dee2e6;
        border-radius: 6px;
        margin-bottom: 0.5rem;
    }
    .includes-list {
        list-style: none;
        padding: 0;
    }
    .includes-list li {
        margin-bottom: 0.5rem;
    }
    .includes-list li i {
        color: #28a745;
        width: 1.5rem;
    }
</style>

<div class="container-fluid py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('affiliate.business_university') }}">Business University</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $course->title }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Left column: Course info & lectures -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4 mb-4" style="background-color: #065754; color: white;">
                <h1 class="fw-bold">{{ $course->title }}</h1>
                @if($course->is_diploma)
                    <span class="badge bg-success mb-3">Diploma Program ({{ $course->duration_months }}+ months)</span>
                @endif
                <p>{{ $course->description }}</p>
                <p><strong>Faculty:</strong> {{ $course->faculty->name }}</p>
                <p><strong>Instructors:</strong> {{ $course->instructors }}</p>
                <div class="d-flex align-items-center">
                    <span class="fw-bold me-2">{{ $course->rating }}</span>
                    <div class="rating me-2">
                        @for($i=1; $i<=5; $i++)
                            @if($i <= floor($course->rating))
                                <i class="fas fa-star text-warning"></i>
                            @elseif($i == ceil($course->rating) && $course->rating - floor($course->rating) >= 0.5)
                                <i class="fas fa-star-half-alt text-warning"></i>
                            @else
                                <i class="far fa-star text-warning"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="text-white-50">({{ number_format($course->reviews_count) }} ratings)</span>
                </div>
            </div>

            <!-- What you'll learn accordion -->
            <h4 class="fw-bold mb-3">What you'll learn</h4>
            <div class="accordion" id="detailsAccordion">
                <div class="section-item">
                    <div class="section-header" data-bs-toggle="collapse" data-bs-target="#collapseDetails" aria-expanded="true">
                        <span>Full Details</span>
                        <span><i class="fas fa-chevron-down"></i></span>
                    </div>
                    <div id="collapseDetails" class="collapse show" data-bs-parent="#detailsAccordion">
                        <div class="section-content">
                            {!! nl2br(e($course->detailed_explanation)) !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course Lectures -->
            <h4 class="fw-bold mb-3 mt-4">Course Content</h4>
            <div class="accordion" id="lecturesAccordion">
                @forelse($course->lectures as $index => $lecture)
                <div class="section-item">
                    <div class="section-header" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="{{ $index == 0 ? 'true' : 'false' }}">
                        <span>{{ $lecture->title }}</span>
                        <span>
                            @if($enrollment)
                                <i class="fas fa-play-circle me-2" style="color: #28a745;"></i>
                            @else
                                <i class="fas fa-lock me-2"></i>
                            @endif
                            <i class="fas fa-chevron-down"></i>
                        </span>
                    </div>
                    <div id="collapse{{ $index }}" class="collapse {{ $index == 0 ? 'show' : '' }}" data-bs-parent="#lecturesAccordion">
                        <div class="section-content">
                            <p>{{ $lecture->description }}</p>
                            @if(!$enrollment)
                                <p class="text-muted"><small>Enroll to access this lecture.</small></p>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                    <p class="text-muted">No lectures available yet.</p>
                @endforelse
            </div>
        </div>

        <!-- Sidebar: Enrollment Card -->
        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="card border-0 shadow-sm p-4 sticky-lg-top" style="top: 20px; background-color: #065754; color: white;">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if($enrollment)
                    <div class="alert alert-success">You are enrolled in this course.</div>
                    <a href="{{ route('affiliate.business.learning.course', $enrollment->id) }}" class="btn btn-success btn-lg w-100">Go to Course</a>
                @else
                    <h4 class="fw-semibold mb-3">Enroll Now</h4>
                    <p class="h2 mb-3">{{ $course->currency }} {{ number_format($course->price) }}</p>
                    <div class="alert alert-info small" style="background-color: #e8f3f2; color: #065754; border: none;">
                        Your wallet balance: <strong>{{ $symbols[$userCurrency] }}{{ number_format(Auth::user()->wallet_balance / $toNGN[$userCurrency], 2) }}</strong>
                    </div>
                    <form method="POST" action="{{ route('affiliate.business.enroll', $course->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-success btn-lg w-100">Enroll Now</button>
                    </form>
                @endif

                <hr class="my-4" style="border-color: rgba(255,255,255,0.2);">
                <h5 class="fw-semibold mb-3">This course includes:</h5>
                <ul class="includes-list">
                    <li><i class="fas fa-check-circle text-success me-2"></i> Full access to all lectures</li>
                    <li><i class="fas fa-check-circle text-success me-2"></i> Certificate upon completion</li>
                    <li><i class="fas fa-check-circle text-success me-2"></i> Community access</li>
                    <li><i class="fas fa-check-circle text-success me-2"></i> Job recommendations</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(button => {
        button.addEventListener('click', function() {
            const icon = this.querySelector('i:last-child');
            if (icon) {
                icon.classList.toggle('fa-chevron-down');
                icon.classList.toggle('fa-chevron-up');
            }
        });
    });
</script>
@endsection