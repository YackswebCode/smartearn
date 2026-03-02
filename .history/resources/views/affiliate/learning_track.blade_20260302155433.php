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
                @if(!$enrollment)
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

<!-- Video Player Modal -->
<div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="videoModalLabel">Lecture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="ratio ratio-16x9">
                    <iframe src="" id="videoFrame" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function playVideo(url, title) {
    document.getElementById('videoFrame').src = url;
    document.getElementById('videoModalLabel').innerText = title;
    var myModal = new bootstrap.Modal(document.getElementById('videoModal'));
    myModal.show();
}
</script>
@endsection