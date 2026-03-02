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
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm p-4">
                <h2 class="fw-bold">{{ $course->title }}</h2>
                <p>{{ $course->description }}</p>
                <hr>

                <h4 class="fw-bold mb-3">Course Lectures</h4>
                <div class="accordion" id="lecturesAccordion">
                    @forelse($course->lectures as $index => $lecture)
                    <div class="section-item">
                        <div class="section-header" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="{{ $index == 0 ? 'true' : 'false' }}">
                            <span>{{ $lecture->title }}</span>
                            <span><i class="fas fa-chevron-down"></i></span>
                        </div>
                        <div id="collapse{{ $index }}" class="collapse {{ $index == 0 ? 'show' : '' }}" data-bs-parent="#lecturesAccordion">
                            <div class="section-content">
                                <p>{{ $lecture->description }}</p>
                                @if($lecture->video_url)
                                    <div class="ratio ratio-16x9 mt-3">
                                        <iframe src="{{ $lecture->video_url }}" allowfullscreen></iframe>
                                    </div>
                                @else
                                    <p class="text-muted">Video not available yet.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                        <p class="text-muted">No lectures available for this course yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-4 sticky-top" style="top: 20px;">
                <h5>About this course</h5>
                <p><strong>Faculty:</strong> {{ $course->faculty->name }}</p>
                <p><strong>Instructors:</strong> {{ $course->instructors }}</p>
                <p><strong>Enrolled:</strong> {{ $enrollment->created_at->format('M d, Y') }}</p>
                <p><strong>Status:</strong> <span class="badge bg-success">Active</span></p>
            </div>
        </div>
    </div>
</div>
@endsection