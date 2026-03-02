@extends('layouts.affiliate')

@section('title', $track->name)

@section('content')
<style>
    .section-item {
        border: 1px solid #dee2e6;
        border-radius: 6px;
        margin-bottom: 0.5rem;
    }
    .section-header {
        background-color: #065754;
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
    .green-card {
        background-color: #d4edda;
        border: none;
        border-radius: 10px;
    }
    .green-card .card-body {
        padding: 1.5rem;
    }
</style>

<div class="container-fluid py-4">
    <div class="row">
        <!-- Main Content -->
        <div class="col-md-8">
            <!-- Top card (your design) -->
            <div class="card green-card mb-4" style="background-color: #065754; color: white;">
                <div class="card-body">
                    <h1 class="fw-bold">{{ $track->name }}</h1>
                    <p class="text-white">{{ $track->description }}</p>
                </div>
            </div>

            <!-- Course Curriculum -->
            <h4 class="fw-bold mb-3">Course Content</h4>
            <div class="accordion" id="lecturesAccordion">
                @forelse($track->lectures as $index => $lecture)
                <div class="section-item">
                    <div class="section-header" style="background-color: #065754; color: white;" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="{{ $index == 0 ? 'true' : 'false' }}">
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
                            @if($enrollment && $lecture->video_url)
                                <div class="mt-3">
                                    <video controls class="w-100" style="max-height: 300px;">
                                        <source src="{{ $lecture->video_url }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            @elseif(!$enrollment)
                                <p class="text-muted"><small>Enroll to access this lecture.</small></p>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                    <p class="text-muted">No lectures available for this track yet.</p>
                @endforelse
            </div>
        </div>

        <!-- Sidebar (your design) -->
        <div class="col-md-4">
            <div class="card green-card sticky-lg-top" style="top: 20px; background-color: #065754; color: white; border: solid 4px #89efbfff;">
                <div class="card-body">
                    <h5 class="fw-semibold mb-3">About this track</h5>
                    <p><strong>Faculty:</strong> {{ $track->faculty->name }}</p>
                    <p><strong>Enrolled:</strong> {{ $enrollment->created_at->format('M d, Y') }}</p>
                    <p><strong>Plan:</strong> {{ ucfirst($enrollment->plan) }}</p>
                    <p><strong>Status:</strong> <span class="badge bg-success">Active</span></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(button => {
        button.addEventListener('click', function() {
            const icon = this.querySelector('i.fa-chevron-down, i.fa-chevron-up');
            if (icon) {
                icon.classList.toggle('fa-chevron-down');
                icon.classList.toggle('fa-chevron-up');
            }
        });
    });
</script>
@endsection