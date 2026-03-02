@extends('layouts.app')

@section('title', 'Confirm Password – SmartEarn')

@section('content')

<section class="hero d-flex align-items-center" style="min-height: 80vh; background: var(--gradient-green);">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="z-index: 0; opacity: 0.15; pointer-events: none;">
        <svg width="100%" height="100%" viewBox="0 0 1200 800">
            <circle cx="10%" cy="20%" r="80" fill="none" stroke="white" stroke-width="2" class="svg-float" />
            <circle cx="90%" cy="70%" r="120" fill="none" stroke="white" stroke-width="1.5" class="svg-float" style="animation-delay: 1s;" />
        </svg>
    </div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="auth-card">
                    <div class="text-center mb-4">
                        <span class="d-inline-flex align-items-center justify-content-center bg-white rounded-3 shadow-sm"
                              style="width: 64px; height: 64px; color: var(--primary-green); font-size: 2rem; font-weight: 800;">
                            SE
                        </span>
                        <h2 class="fw-bold mt-4 mb-2" style="color: var(--primary-green);">Confirm your password</h2>
                        <p class="text-secondary">This is a secure area. Please confirm your password before continuing.</p>
                    </div>

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        {{-- Password --}}
                        <div class="mb-4">
                            <label for="password" class="form-label fw-medium text-dark">Password</label>
                            <input type="password" class="form-control custom-input @error('password') is-invalid @enderror"
                                   id="password" name="password" required placeholder="Enter your password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">
                            <i class="bi bi-shield-lock-fill me-2"></i> Confirm
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection