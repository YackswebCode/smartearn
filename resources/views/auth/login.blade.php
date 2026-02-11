@extends('layouts.app')

@section('title', 'Log In – SmartEarn')

@section('content')

{{-- Gradient hero with animated SVGs --}}
<section class="hero d-flex align-items-center" style="min-height: 80vh; background: var(--gradient-green);">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="z-index: 0; opacity: 0.15; pointer-events: none;">
        <svg width="100%" height="100%" viewBox="0 0 1200 800">
            <circle cx="15%" cy="25%" r="90" fill="none" stroke="white" stroke-width="2" class="svg-float" />
            <circle cx="80%" cy="55%" r="140" fill="none" stroke="white" stroke-width="1.8" class="svg-float" style="animation-delay: 1.5s;" />
            <circle cx="35%" cy="75%" r="70" fill="none" stroke="white" stroke-width="1.2" class="svg-float" style="animation-delay: 0.9s;" />
        </svg>
    </div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="auth-card">
                    {{-- Brand icon --}}
                    <div class="text-center mb-4">
                        <span class="d-inline-flex align-items-center justify-content-center bg-white rounded-3 shadow-sm"
                              style="width: 64px; height: 64px; color: var(--primary-green); font-size: 2rem; font-weight: 800;">
                            SE
                        </span>
                        <h2 class="fw-bold mt-4 mb-2" style="color: var(--primary-green);">Welcome back</h2>
                        <p class="text-secondary">Log in to your SmartEarn account</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
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

                        {{-- Password --}}
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <label for="password" class="form-label fw-medium text-dark">Password</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-decoration-none small" style="color: var(--primary-green);">
                                        Forgot?
                                    </a>
                                @endif
                            </div>
                            <input type="password" class="form-control custom-input @error('password') is-invalid @enderror"
                                   id="password" name="password" required placeholder="••••••••">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Remember me --}}
                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label text-secondary" for="remember">Remember me</label>
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Log In
                        </button>

                        {{-- Register link --}}
                        <div class="text-center mt-4">
                            <span class="text-secondary">Don't have an account?</span>
                            <a href="{{ route('register') }}" class="text-decoration-none fw-bold ms-1" style="color: var(--primary-green);">
                                Sign up
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection