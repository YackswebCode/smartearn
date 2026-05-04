@extends('layouts.affiliate')

@section('title', 'Digital University')

@section('content')
<style>
    .bg-digital { background-color: #0b3d3a !important; }
    .faculty-card {
        border-radius: 16px;
        border: none;
        transition: transform 0.2s;
        cursor: pointer;
        background: #f8f9fa;
        height: 100%;
    }
    .faculty-card:hover { transform: translateY(-4px); box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
    .faculty-icon { font-size: 2.5rem; color: #0b3d3a; }
    .track-item {
        padding: 12px 16px;
        border-bottom: 1px solid #eaeaea;
        cursor: pointer;
    }
    .track-item:hover { background-color: #f0f7f6; }
    .track-item:last-child { border-bottom: none; }
    .plan-option { border: 2px solid #dee2e6; border-radius: 10px; padding: 15px; margin-bottom: 10px; }
    .plan-option.selected { border-color: #0b3d3a; background-color: #f0f7f6; }
</style>

<div class="container-fluid py-4">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Hero Section -->
    <div class="bg-digital p-5 rounded-4 mb-5 text-white position-relative">
        <div class="row align-items-center">
            <div class="col-md-7">
                <h1 class="display-4 fw-bold">Digital University</h1>
                <p class="fs-5">Master high‑demand skills. Choose your faculty, pick a learning track, and start your journey.</p>
                <div class="mt-3">
                    <span class="badge bg-light text-dark p-2 px-3">🎓 Diploma Studies – 12+ month tracks</span>
                </div>
            </div>
            <div class="col-md-5 text-center d-none d-md-block">
                <i class="fas fa-laptop-code fa-5x opacity-50"></i>
            </div>
        </div>
        {{-- Link to My Learning --}}
        @auth
        <div class="mt-3">
            <a href="{{ route('affiliate.digital.my.learning') }}" class="btn btn-light">
                <i class="fas fa-book-open me-2"></i> My Digital Learning
            </a>
        </div>
        @endauth
    </div>

    <div class="mb-4">
        <h2 class="fw-bold text-dark">Explore Our Faculties</h2>
        <p class="text-muted">Select a faculty to see available tracks.</p>
    </div>

    <!-- Faculties Grid -->
    <div class="row g-4" id="facultiesContainer">
        @foreach($faculties as $faculty)
        <div class="col-md-6 col-lg-3">
            <div class="faculty-card p-4 text-center" onclick="loadFacultyTracks({{ $faculty->id }}, '{{ $faculty->name }}')">
                <i class="fas {{ $faculty->icon ?? 'fa-graduation-cap' }} faculty-icon mb-3"></i>
                <h5 class="fw-bold">{{ $faculty->name }}</h5>
                <p class="text-muted small">{{ $faculty->tracks_count ?? '' }} Tracks</p>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Modal: Faculty Tracks List -->
    <div class="modal fade" id="facultyTracksModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold" id="facultyModalTitle">Faculty Tracks</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="facultyTracksContent"></div>
            </div>
        </div>
    </div>

    <!-- Modal: Track Detail & Plan Selection -->
    <div class="modal fade" id="trackDetailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="trackDetailTitle">Track Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="trackDetailContent"></div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function loadFacultyTracks(facultyId, facultyName) {
        $('#facultyModalTitle').text(facultyName + ' – Tracks');
        $('#facultyTracksContent').html('<div class="text-center py-5"><div class="spinner-border text-success"></div></div>');
        var modal = new bootstrap.Modal(document.getElementById('facultyTracksModal'));
        modal.show();

        fetch('{{ route("affiliate.digital.faculty.tracks", ":facultyId") }}'.replace(':facultyId', facultyId))
            .then(res => res.json())
            .then(data => {
                let html = '';
                data.tracks.forEach(track => {
                    html += `<div class="track-item d-flex justify-content-between align-items-center" onclick="loadTrackDetail('${track.slug}')">
                                <span>${track.title}</span>
                                <i class="fas fa-arrow-right text-muted"></i>
                             </div>`;
                });
                if (data.tracks.length === 0) html = '<p class="text-muted p-3">No tracks available in this faculty yet.</p>';
                $('#facultyTracksContent').html(html);
            })
            .catch(() => {
                $('#facultyTracksContent').html('<p class="text-danger p-3">Failed to load tracks.</p>');
            });
    }

    function loadTrackDetail(slug) {
        bootstrap.Modal.getInstance(document.getElementById('facultyTracksModal')).hide();
        $('#trackDetailContent').html('<div class="text-center py-5"><div class="spinner-border text-success"></div></div>');
        var modal = new bootstrap.Modal(document.getElementById('trackDetailModal'));
        modal.show();

        fetch('{{ route("affiliate.digital.track.details", ":slug") }}'.replace(':slug', slug))
            .then(res => res.json())
            .then(data => {
                let plansHTML = '';
                for (let [key, plan] of Object.entries(data.plans)) {
                    plansHTML += `
                        <div class="plan-option" onclick="selectPlan('${key}')" id="plan-${key}">
                            <input type="radio" name="plan" value="${key}" class="form-check-input me-2">
                            <strong>${plan.label}</strong>
                            <span class="float-end fw-bold">${data.currency_symbol}${plan.price.toLocaleString()}</span>
                        </div>`;
                }

                let featuresList = data.track.features.map(f => `<li>${f}</li>`).join('');
                let alreadyEnrolledMsg = data.already_enrolled
                    ? '<div class="alert alert-info">You are already enrolled in this track.</div>' : '';

                let html = `
                    <div class="row">
                        <div class="col-md-5">
                            <div class="course-image mb-3" style="height:180px; background:#f8f9fa; border-radius:10px; display:flex; align-items:center; justify-content:center;">
                                ${data.track.image ? `<img src="${data.track.image}" class="img-fluid rounded" style="max-height:100%;">` : '<i class="fas fa-image fa-3x text-muted"></i>'}
                            </div>
                            <div class="mb-2">
                                <span class="fw-bold">${data.track.rating}</span> <i class="fas fa-star text-warning"></i>
                                <span class="text-muted small ms-2">(${data.track.reviews_count} reviews)</span>
                            </div>
                            <p class="text-muted">Instructors: ${data.track.instructors}</p>
                            <p><strong>Duration:</strong> ${data.track.duration} ${data.track.is_diploma ? '<span class="badge bg-dark">Diploma</span>' : ''}</p>
                            <p><strong>Faculty:</strong> ${data.track.faculty}</p>
                        </div>
                        <div class="col-md-7">
                            <h4 class="fw-bold">${data.track.title}</h4>
                            <p>${data.track.description}</p>
                            <hr>
                            <h6>What you get:</h6>
                            <ul>${featuresList}</ul>
                            ${alreadyEnrolledMsg}
                            <h5 class="mt-4">Choose Tuition Plan</h5>
                            <form id="enrollForm" action="{{ route('affiliate.digital.enroll') }}" method="POST">
                                @csrf
                                <input type="hidden" name="track_id" value="${data.track.id}">
                                <div id="planOptions">${plansHTML}</div>
                                <button type="submit" class="btn btn-success w-100 mt-3" ${data.already_enrolled ? 'disabled' : ''}>Enroll Now</button>
                            </form>
                        </div>
                    </div>
                `;
                $('#trackDetailContent').html(html);
                // Auto-select first plan
                if (Object.keys(data.plans).length > 0) {
                    selectPlan(Object.keys(data.plans)[0]);
                }
            })
            .catch(() => {
                $('#trackDetailContent').html('<p class="text-danger p-3">Failed to load track details.</p>');
            });
    }

    function selectPlan(planKey) {
        document.querySelectorAll('.plan-option').forEach(el => el.classList.remove('selected'));
        document.getElementById('plan-' + planKey).classList.add('selected');
        document.querySelector(`input[name="plan"][value="${planKey}"]`).checked = true;
    }
</script>
@endpush
@endsection