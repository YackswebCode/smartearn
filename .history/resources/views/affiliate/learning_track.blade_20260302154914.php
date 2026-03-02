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
                <h4>Course Content</h4>
                @if($track->lectures && $track->lectures->count() > 0)
                    <div class="list-group">
                        @foreach($track->lectures as $lecture)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-play-circle text-success me-2"></i>
                                {{ $lecture->title }}
                                @if($lecture->duration)
                                    <small class="text-muted ms-2">{{ $lecture->duration }} mins</small>
                                @endif
                            </div>
                            <button class="btn btn-sm btn-outline-success" onclick="playVideo('{{ $lecture->video_url }}', '{{ $lecture->title }}')">Play</button>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">No lectures available yet.</p>
                @endif
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