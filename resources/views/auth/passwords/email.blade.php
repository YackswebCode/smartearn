@extends('layouts.app')

@section('title', 'Reset Password – SmartEarn')

@section('content')

<section class="hero d-flex align-items-center" style="min-height: 80vh; background: var(--gradient-green);">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="z-index: 0; opacity: 0.15; pointer-events: none;">
        <svg width="100%" height="100%" viewBox="0 0 1200 800">
            <circle cx="15%" cy="35%" r="90" fill="none" stroke="white" stroke-width="2" class="svg-float" />
            <circle cx="75%" cy="55%" r="130" fill="none" stroke="white" stroke-width="1.8" class="svg-float" style="animation-delay: 1.2s;" />
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
                        <h2 class="fw-bold mt-4 mb-2" style="color: var(--primary-green);">Reset password</h2>
                        <p class="text-secondary">Enter your email and we'll send you a reset link.</p>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success mb-4" role="alert" style="border-radius: 16px; background: rgba(6,87,84,0.1); color: var(--primary-green); border: none;">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        {{-- Email --}}
                        <div class="mb-4">
                            <label for="email" class="form-label fw-medium text-dark">Email address</label>
                            <input type="email" class="form-control custom-input @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email') }}" required autofocus
                                   placeholder="you@example.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">
                            <i class="bi bi-envelope-paper-fill me-2"></i> Send Reset Link
                        </button>

                        <div class="text-center mt-4">
                            <a href="{{ route('login') }}" class="text-decoration-none" style="color: var(--primary-green);">
                                <i class="bi bi-arrow-left me-1"></i> Back to login
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection