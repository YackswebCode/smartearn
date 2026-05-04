@extends('layouts.affiliate')

@section('title', $lecture->title)

@section('content')
<div class="container-fluid py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('affiliate.digital_university') }}">Digital University</a></li>
            <li class="breadcrumb-item"><a href="{{ route('affiliate.digital.my.learning') }}">My Learning</a></li>
            <li class="breadcrumb-item"><a href="{{ route('affiliate.digital.learning.track', $enrollment->id) }}">{{ $track->title }}</a></li>
            <li class="breadcrumb-item active">{{ $lecture->title }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Left Sidebar: Lecture List -->
        <div class="col-lg-3">
            <div class="card shadow-sm">
                <div class="card-header bg-white fw-bold">
                    Course Content
                </div>
                <ul class="list-group list-group-flush">
                    @foreach($lectures as $item)
                        <a href="{{ route('affiliate.digital.lecture.show', ['enrollment' => $enrollment->id, 'lecture' => $item->id]) }}" 
                           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ $item->id == $lecture->id ? 'active' : '' }}">
                            <span>{{ $loop->iteration }}. {{ $item->title }}</span>
                            @if($item->id == $lecture->id)
                                <i class="fas fa-play text-white small"></i>
                            @endif
                        </a>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Main Content: Video Player & Description -->
        <div class="col-lg-9">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="fw-bold mb-3">{{ $lecture->title }}</h4>

                    {{-- Video Player --}}
                    @if($lecture->video_url)
                        <div class="ratio ratio-16x9 mb-4">
                            @php
                                $isYoutube = strpos($lecture->video_url, 'youtube.com') !== false || strpos($lecture->video_url, 'youtu.be') !== false;
                                $isVimeo = strpos($lecture->video_url, 'vimeo.com') !== false;
                            @endphp
                            @if($isYoutube)
                                @php
                                    parse_str(parse_url($lecture->video_url, PHP_URL_QUERY), $query);
                                    $youtubeId = $query['v'] ?? null;
                                    if(!$youtubeId) {
                                        $path = parse_url($lecture->video_url, PHP_URL_PATH);
                                        $youtubeId = basename($path);
                                    }
                                @endphp
                                <iframe src="https://www.youtube.com/embed/{{ $youtubeId }}" 
                                        frameborder="0" allowfullscreen></iframe>
                            @elseif($isVimeo)
                                @php
                                    $vimeoId = basename(parse_url($lecture->video_url, PHP_URL_PATH));
                                @endphp
                                <iframe src="https://player.vimeo.com/video/{{ $vimeoId }}" 
                                        frameborder="0" allowfullscreen></iframe>
                            @else
                                {{-- Direct video file (mp4, etc.) --}}
                                <video controls class="w-100">
                                    <source src="{{ $lecture->video_url }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @endif
                        </div>
                    @else
                        <div class="alert alert-warning">No video available for this lecture.</div>
                    @endif

                    {{-- Lecture Content (Text) --}}
                    @if($lecture->content)
                        <div class="mt-3">
                            <h5>Lecture Notes</h5>
                            <p>{{ $lecture->content }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection