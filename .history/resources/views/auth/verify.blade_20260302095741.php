@extends('layouts.app')

@section('title', 'Verify Email – SmartEarn')

@section('content')

<section class="hero d-flex align-items-center" style="min-height: 80vh; background: var(--gradient-green);">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="z-index: 0; opacity: 0.15; pointer-events: none;">
        <svg width="100%" height="100%" viewBox="0 0 1200 800">
            <circle cx="25%" cy="30%" r="90" fill="none" stroke="white" stroke-width="2" class="svg-float" />
            <circle cx="65%" cy="70%" r="130" fill="none" stroke="white" stroke-width="1.8" class="svg-float" style="animation-delay: 1s;" />
            <circle cx="80%" cy="25%" r="70" fill="none" stroke="white" stroke-width="1.2" class="svg-float" style="animation-delay: 0.5s;" />
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
                        <h2 class="fw-bold mt-4 mb-2" style="color: var(--primary-green);">Verify your email</h2>
                        <p class="text-secondary">We've sent a 6‑digit code to your email address.</p>
                    </div>

                    @if (session('resent'))
                        <div class="alert alert-success mb-4" role="alert" style="border-radius: 16px; background: rgba(6,87,84,0.1); color: var(--primary-green); border: none;">
                            A fresh verification code has been sent to your email.
                        </div>
                    @endif

                    {{-- Code verification form --}}
                    <form method="POST" action="{{ route('verification.verify') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="code" class="form-label fw-medium text-dark">6‑digit verification code</label>
                            <input type="text" class="form-control custom-input @error('code') is-invalid @enderror"
                                   id="code" name="code" required placeholder="000000" maxlength="6" inputmode="numeric" pattern="[0-9]{6}">
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">
                            <i class="bi bi-check-circle-fill me-2"></i> Verify Email
                        </button>
                    </form>

                    <div class="text-secondary mt-4 text-center">
                        Didn't receive the code?
                    </div>

                    {{-- Resend button (separate form) --}}
                    <form method="POST" action="{{ route('verification.resend') }}" class="mt-2">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary w-100 py-3 fw-bold" style="border-width: 2px;">
                            <i class="bi bi-envelope-arrow-up-fill me-2"></i> Resend Code
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection