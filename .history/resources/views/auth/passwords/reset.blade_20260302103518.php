@extends('layouts.app')

@section('title', 'Set New Password – SmartEarn')

@section('content')

<section class="hero d-flex align-items-center" style="min-height: 80vh; background: var(--gradient-green);">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="z-index: 0; opacity: 0.15; pointer-events: none;">
        <svg width="100%" height="100%" viewBox="0 0 1200 800">
            <circle cx="20%" cy="25%" r="100" fill="none" stroke="white" stroke-width="2" class="svg-float" />
            <circle cx="80%" cy="65%" r="140" fill="none" stroke="white" stroke-width="1.8" class="svg-float" style="animation-delay: 0.8s;" />
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
                        <h2 class="fw-bold mt-4 mb-2" style="color: var(--primary-green);">Set new password</h2>
                        <p class="text-secondary">Your new password must be different from previous passwords.</p>
                    </div>

                    {{-- Error/Success messages --}}
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4" role="alert" style="border-radius: 16px; background: rgba(220,53,69,0.1); color: #dc3545; border: none;">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        {{-- Email (readonly, from session) --}}
                        <div class="mb-4">
                            <label for="email" class="form-label fw-medium text-dark">Email address</label>
                            <input type="email" class="form-control custom-input @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ $email ?? old('email') }}" required readonly
                                   placeholder="your@email.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Reset Code --}}
                        <div class="mb-4">
                            <label for="code" class="form-label fw-medium text-dark">6‑digit reset code</label>
                            <input type="text" class="form-control custom-input @error('code') is-invalid @enderror"
                                   id="code" name="code" required placeholder="000000" maxlength="6" inputmode="numeric" pattern="[0-9]{6}">
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- New Password --}}
                        <div class="mb-4">
                            <label for="password" class="form-label fw-medium text-dark">New password</label>
                            <input type="password" class="form-control custom-input @error('password') is-invalid @enderror"
                                   id="password" name="password" required placeholder="Min. 8 characters">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Confirm New Password --}}
                        <div class="mb-4">
                            <label for="password-confirm" class="form-label fw-medium text-dark">Confirm new password</label>
                            <input type="password" class="form-control custom-input"
                                   id="password-confirm" name="password_confirmation" required placeholder="Re-enter your password">
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">
                            <i class="bi bi-check2-circle me-2"></i> Reset Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection