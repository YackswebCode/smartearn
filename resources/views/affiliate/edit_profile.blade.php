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
            <form method="POST" action="{{ route('affiliate.update_profile') }}" enctype="multipart/form-data">
                @csrf

                <!-- Profile Picture Upload -->
                <div class="d-flex justify-content-center mb-4">
                    <div class="position-relative" style="width: 150px; height: 150px;">
                        <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : 'https://via.placeholder.com/150' }}"
                             alt="Profile Picture"
                             class="rounded-circle w-100 h-100 border"
                             id="profilePreview"
                             style="object-fit: cover;">

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
                        <option value="NGN" {{ old('currency', $user->currency) == 'NGN' ? 'selected' : '' }}>NGN (₦)</option>
                        <option value="USD" {{ old('currency', $user->currency) == 'USD' ? 'selected' : '' }}>USD ($)</option>
                        <option value="GHS" {{ old('currency', $user->currency) == 'GHS' ? 'selected' : '' }}>GHS (GH¢)</option>
                        <option value="XAF" {{ old('currency', $user->currency) == 'XAF' ? 'selected' : '' }}>XAF (FCFA)</option>
                        <option value="KES" {{ old('currency', $user->currency) == 'KES' ? 'selected' : '' }}>KES (KES)</option>
                    </select>
                    @error('currency')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Business Name (defaults to user's name if empty) -->
                <div class="mb-3">
                    <label for="business_name" class="form-label fw-semibold">Business Name</label>
                    <input type="text" class="form-control @error('business_name') is-invalid @enderror" id="business_name" name="business_name" value="{{ old('business_name', $user->business_name ?? $user->name) }}">
                    @error('business_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- About Me -->
                <div class="mb-3">
                    <label for="about_me" class="form-label fw-semibold">About Me</label>
                    <textarea class="form-control @error('about_me') is-invalid @enderror" id="about_me" name="about_me" rows="4">{{ old('about_me', $user->about_me) }}</textarea>
                    @error('about_me')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Business Description -->
                <div class="mb-4">
                    <label for="business_description" class="form-label fw-semibold">Business Description</label>
                    <textarea class="form-control @error('business_description') is-invalid @enderror" id="business_description" name="business_description" rows="4">{{ old('business_description', $user->business_description) }}</textarea>
                    @error('business_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Update Button -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-success px-4 w-100">Update Profile</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Become a Vendor Section -->
    @if($user->vendor_status === 'Not_Yet' || $user->vendor_status === 'Reject')
        <hr class="my-4">
        <div class="text-center">
            <h4 class="fw-bold">Ready to become a vendor?</h4>
            <p class="text-muted">Pay a one-time fee of ₦1,000 to start selling your products.</p>
            <button type="button" class="btn btn-success btn-lg" data-bs-toggle="modal" data-bs-target="#becomeVendorModal">
                <i class="fas fa-store me-2"></i>Become a Vendor
            </button>
        </div>
    @elseif($user->vendor_status === 'Pending')
        <hr class="my-4">
        <div class="alert alert-info text-center">
            <i class="fas fa-clock me-2"></i>Your vendor application is pending admin approval.
        </div>
    @elseif($user->vendor_status === 'Active')
        <hr class="my-4">
        <div class="alert alert-success text-center">
            <i class="fas fa-check-circle me-2"></i>You are already an active vendor.
        </div>
    @endif
</div>

<!-- Become Vendor Modal -->
<div class="modal fade" id="becomeVendorModal" tabindex="-1" aria-labelledby="becomeVendorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="becomeVendorModalLabel">
                    <i class="fas fa-store me-2"></i>Become a Vendor
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('affiliate.become_vendor') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Please review the following conditions before proceeding:</p>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> You must be an active affiliate.</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> One-time fee of <strong>₦1,000</strong> will be deducted from your wallet.</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Your application will be reviewed by admin (usually within 24-48 hours).</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Once approved, you can start adding products.</li>
                    </ul>

                    <!-- Current Wallet Balance -->
                    <div class="alert alert-info">
                        <strong>Your Wallet Balance:</strong> ₦{{ number_format($user->wallet_balance, 2) }}
                        @if($user->wallet_balance < 1000)
                            <div class="text-danger mt-2">Insufficient balance. Please fund your wallet first.</div>
                        @endif
                    </div>

                    <!-- Business Information Preview (already entered) -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Business Name</label>
                        <input type="text" class="form-control" value="{{ $user->business_name ?? $user->name }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Business Description</label>
                        <textarea class="form-control" rows="2" readonly>{{ $user->business_description ?? 'Not provided' }}</textarea>
                    </div>

                    <!-- Terms Agreement -->
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="agree_terms" id="agreeTerms" required {{ $user->wallet_balance < 1000 ? 'disabled' : '' }}>
                        <label class="form-check-label" for="agreeTerms">
                            I agree to the <a href="#" target="_blank">Vendor Terms & Conditions</a> and confirm that the information provided is correct.
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" {{ $user->wallet_balance < 1000 ? 'disabled' : '' }}>
                        <i class="fas fa-credit-card me-2"></i>Pay ₦1,000
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            document.getElementById('profilePreview').src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endpush
@endsection