@extends('layouts.affiliate')

@section('title', $track->title)

@section('content')
<div class="container-fluid py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('affiliate.digital_university') }}">Digital University</a></li>
            <li class="breadcrumb-item"><a href="{{ route('affiliate.digital.my.learning') }}">My Learning</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $track->title }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Left Sidebar: Lectures List -->
        <div class="col-lg-3">
            <div class="card shadow-sm">
                <div class="card-header bg-white fw-bold">
                    Course Content
                </div>
                <ul class="list-group list-group-flush">
                    @forelse($track->lectures as $index => $lecture)
                        <a href="{{ route('affiliate.digital.lecture.show', ['enrollment' => $enrollment->id, 'lecture' => $lecture->id]) }}" 
                           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span>{{ $index + 1 }}. {{ $lecture->title }}</span>
                            <i class="fas fa-play-circle text-success small"></i>
                        </a>
                    @empty
                        <li class="list-group-item text-muted">No lectures added yet.</li>
                    @endforelse
                </ul>
            </div>
            <div class="mt-3">
                <small class="text-muted">
                    <strong>Plan:</strong> {{ ucfirst($enrollment->plan) }}<br>
                    <strong>End Date:</strong> {{ $enrollment->end_date->format('M d, Y') }}
                </small>
            </div>
        </div>

        <!-- Main Content: Track Description & Features -->
        <div class="col-lg-9">
            <div class="card shadow-sm p-4">
                <h3 class="fw-bold">{{ $track->title }}</h3>
                <p class="text-muted">{{ $track->instructors }}</p>
                <hr>
                <p>{{ $track->description }}</p>

                <div class="mt-4">
                    <h5 class="fw-bold">What you'll get</h5>
                    <ul>
                        <li>✅ Citations</li>
                        <li>🎓 Convocations</li>
                        <li>📜 Certifications</li>
                        <li>🌐 Community for portfolio building</li>
                        <li>💼 Job recommendations</li>
                    </ul>
                </div>

                <div class="mt-4">
                    <h5 class="fw-bold">Lectures</h5>
                    @if($track->lectures->count())
                        <p>Select a lecture from the left to start watching. Your progress will be tracked.</p>
                    @else
                        <p class="text-muted">Lectures will be added soon.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection