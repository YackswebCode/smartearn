@extends('layouts.affiliate')

@section('title', $track->name)

@section('content')
<style>
    /* (keep all existing styles) */
    .rating i { color: #ffc107; }
    .discount-badge { background-color: #28a745; color: white; padding: 0.2rem 0.6rem; border-radius: 4px; font-size: 0.9rem; font-weight: 600; }
    .original-price { text-decoration: line-through; color: #6c757d; font-size: 1.2rem; }
    .current-price { font-size: 2rem; font-weight: 700; color: #333; }
    .time-left { background-color: #fff3cd; color: #856404; padding: 0.5rem; border-radius: 4px; text-align: center; font-weight: 600; }
    .includes-list { list-style: none; padding: 0; }
    .includes-list li { margin-bottom: 0.5rem; font-size: 0.95rem; }
    .includes-list li i { color: #28a745; width: 1.5rem; }
    .section-item { border: 1px solid #dee2e6; border-radius: 6px; margin-bottom: 0.5rem; }
    .section-header { background-color: #065754; padding: 0.75rem 1rem; cursor: pointer; display: flex; justify-content: space-between; align-items: center; font-weight: 600; border-radius: 6px 6px 0 0; }
    .section-content { padding: 1rem; }
    .lecture-item { display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 0; border-bottom: 1px solid #f1f1f1; }
    .lecture-item:last-child { border-bottom: none; }
    .preview-badge { color: #28a745; font-size: 0.85rem; margin-left: 0.5rem; }
    .duration { color: #6c757d; font-size: 0.9rem; }
    .green-card { background-color: #d4edda; border: none; border-radius: 10px; }
    .green-card .card-body { padding: 1.5rem; }
</style>

<div class="container-fluid py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('affiliate.skill_garage') }}">Digital University</a></li>
            <li class="breadcrumb-item"><a href="{{ route('affiliate.skill_garage.faculty', $track->faculty->id) }}">{{ $track->faculty->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $track->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Main Content (Left Column) -->
        <div class="col-lg-8">
            <!-- Green Card for Track Info -->
            <div class="card green-card mb-4" style="background-color: #065754; color: white;">
                <div class="card-body">
                    <h1 class="fw-bold">{{ $track->name }}</h1>
                    @if($track->is_diploma)
                        <span class="badge bg-success mb-3">Diploma Program ({{ $track->duration_months }}+ months)</span>
                    @endif
                    <p class="text-white">{{ $track->description }}</p>

                    <!-- Faculty & Meta -->
                    <p class="mb-2"><strong>Faculty</strong> {{ $track->faculty->name }}</p>
                    @if($track->duration_months)
                        <p class="mb-2"><strong>Duration</strong> {{ $track->duration_months }} months</p>
                    @endif
                </div>
            </div>

            <!-- What's Included (mobile only) -->
            <div class="d-lg-none mb-4">
                <h5>This program includes:</h5>
                <ul class="includes-list">
                    <li><i class="fas fa-check-circle"></i> Full access to all materials</li>
                    <li><i class="fas fa-check-circle"></i> Certificate upon completion</li>
                    <li><i class="fas fa-check-circle"></i> Community access</li>
                    <li><i class="fas fa-check-circle"></i> Job recommendations</li>
                </ul>
            </div>

          
<!-- Track Curriculum (Lectures) -->
<h4 class="fw-bold mb-3">Course Content</h4>
<div class="accordion" id="lecturesAccordion">
    @forelse($track->lectures as $index => $lecture)
    <div class="section-item">
        <div class="section-header" style="background-color: #065754; color: white;" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="{{ $index == 0 ? 'true' : 'false' }}">
            <span>{{ $lecture->title }}</span>
            <span>
                @if($enrollment)
                    <i class="fas fa-play-circle me-2"></i>
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
                        <!-- Video player (embedded) -->
                        <div class="ratio ratio-16x9">
                            <iframe src="{{ $lecture->video_url }}" title="{{ $lecture->title }}" allowfullscreen></iframe>
                        </div>
                    </div>
                @elseif(!$enrollment)
                    <p class="text-muted"><i class="fas fa-lock me-1"></i> Enroll to access this lecture.</p>
                @endif
            </div>
        </div>
    </div>
    @empty
        <p class="text-muted">No lectures available for this track yet.</p>
    @endforelse
</div>

        <!-- Sidebar (Right Column) – Green Card -->
        <div class="col-lg-4 mt-5 mb-5">
            <div class="card green-card sticky-lg-top" style="top: 2rem; background-color: #065754; color: white; border: solid 4px #89efbfff; ">
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @if($enrollment)
                        <!-- Already enrolled -->
                        <div class="alert alert-success">You are enrolled in this track.</div>
                        <a href="{{ route('affiliate.learning.track', $track->id) }}" class="btn btn-success btn-lg w-100">Go to Course</a>
                    @else
                        <!-- Enrollment form -->
                        <h4 class="fw-semibold mb-4">Tuition Plans</h4>
                        <form method="POST" action="{{ route('affiliate.skill_garage.enroll', $track->id) }}">
                            @csrf
                            @foreach($prices as $plan => $price)
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="plan" id="plan_{{ $plan }}" value="{{ $plan }}" required>
                                <label class="form-check-label w-100 d-flex justify-content-between" for="plan_{{ $plan }}">
                                    <span>{{ ucfirst($plan) }}</span>
                                    <span class="fw-bold">{{ $price['formatted'] }}</span>
                                </label>
                            </div>
                            @endforeach

                            <div class="alert alert-info small mt-3" style="background-color: #e8f3f2; color: #065754; border: none;">
                                Your wallet balance: <strong>{{ $symbols[$userCurrency] }}{{ number_format(Auth::user()->wallet_balance / $toNGN[$userCurrency], 2) }}</strong>
                            </div>

                            <button type="submit" class="btn btn-success btn-lg w-100 mt-3">Enroll Now</button>
                        </form>
                    @endif

                    <!-- This Program Includes (same for both states) -->
                    <hr class="my-4" style="border-color: rgba(255,255,255,0.2);">
                    <h5 class="fw-semibold mb-3">This program includes:</h5>
                    <ul class="includes-list">
                        <li><i class="fas fa-check-circle text-success me-2"></i> Full access to all materials</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Certificate upon completion</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Community access</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Job recommendations</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(button => {
        button.addEventListener('click', function() {
            const icon = this.querySelector('i');
            if (icon) {
                icon.classList.toggle('fa-chevron-down');
                icon.classList.toggle('fa-chevron-up');
            }
        });
    });
</script>
@endsection