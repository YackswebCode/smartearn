@extends('layouts.affiliate')

@section('title', 'Edit Profile')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="mb-4">
        <h2 class="fw-bold">Edit Profile</h2>
        <p class="text-muted">Update your affiliate information</p>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Profile Form -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('affiliate.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('POST')

                <!-- Profile Picture Upload -->
                <div class="d-flex justify-content-center mb-4">
                    <div class="position-relative" style="width: 150px; height: 150px;">
                        <!-- Profile image preview -->
                        <img src="{{ $profile->profile_picture ?? 'https://via.placeholder.com/150' }}"
                             alt="Profile Picture"
                             class="rounded-circle w-100 h-100 object-fit-cover border"
                             id="profilePreview"
                             style="object-fit: cover;">

                        <!-- Camera icon overlay -->
                        <label for="profile_image" class="position-absolute bottom-0 end-0 bg-success rounded-circle p-2 shadow-sm" style="cursor: pointer; transform: translate(10%, 10%);">
                            <i class="fas fa-camera text-white"></i>
                        </label>
                        <input type="file" class="d-none" id="profile_image" name="profile_image" accept="image/*" onchange="previewImage(event)">
                    </div>
                </div>

                <!-- Currency -->
                <div class="mb-3">
                    <label for="currency" class="form-label fw-semibold">Choose Currency</label>
                    <select class="form-select @error('currency') is-invalid @enderror" id="currency" name="currency">
                        <option value="USD" {{ $profile->currency == 'USD' ? 'selected' : '' }}>USD ($)</option>
                        <option value="EUR" {{ $profile->currency == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                        <option value="GBP" {{ $profile->currency == 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                        <option value="NGN" {{ $profile->currency == 'NGN' ? 'selected' : '' }}>NGN (₦)</option>
                    </select>
                    @error('currency')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Business Name -->
                <div class="mb-3">
                    <label for="business_name" class="form-label fw-semibold">Business Name</label>
                    <input type="text" class="form-control @error('business_name') is-invalid @enderror" id="business_name" name="business_name" value="{{ old('business_name', $profile->business_name) }}">
                    @error('business_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- About Me -->
                <div class="mb-3">
                    <label for="about_me" class="form-label fw-semibold">About Me</label>
                    <textarea class="form-control @error('about_me') is-invalid @enderror" id="about_me" name="about_me" rows="4">{{ old('about_me', $profile->about_me) }}</textarea>
                    @error('about_me')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Business Description -->
                <div class="mb-4">
                    <label for="business_description" class="form-label fw-semibold">Business Description</label>
                    <textarea class="form-control @error('business_description') is-invalid @enderror" id="business_description" name="business_description" rows="4">{{ old('business_description', $profile->business_description) }}</textarea>
                    @error('business_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Update Button (Full Width) -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-success px-4 w-100">Update Profile</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript for Image Preview -->
@push('scripts')
<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('profilePreview');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endpush
@endsection