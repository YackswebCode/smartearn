@extends('layouts.app')

@section('title', 'Create Account – SmartEarn')

@section('content')

<section class="hero d-flex align-items-center" style="min-height: 80vh; background: var(--gradient-green);">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="z-index: 0; opacity: 0.15; pointer-events: none;">
        <svg width="100%" height="100%" viewBox="0 0 1200 800">
            <circle cx="20%" cy="30%" r="100" fill="none" stroke="white" stroke-width="2" class="svg-float" />
            <circle cx="70%" cy="60%" r="150" fill="none" stroke="white" stroke-width="1.8" class="svg-float" style="animation-delay: 1.2s;" />
            <circle cx="85%" cy="20%" r="80" fill="none" stroke="white" stroke-width="1.2" class="svg-float" style="animation-delay: 0.5s;" />
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
                        <h2 class="fw-bold mt-4 mb-2" style="color: var(--primary-green);">Get started</h2>
                        <p class="text-secondary">Create your SmartEarn account – it's free</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        {{-- Name --}}
                        <div class="mb-4">
                            <label for="name" class="form-label fw-medium text-dark">Full name</label>
                            <input type="text" class="form-control custom-input @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name') }}" required autofocus
                                   placeholder="Enter your name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-4">
                            <label for="email" class="form-label fw-medium text-dark">Email address</label>
                            <input type="email" class="form-control custom-input @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email') }}" required
                                   placeholder="you@example.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-4">
                            <label for="password" class="form-label fw-medium text-dark">Password</label>
                            <input type="password" class="form-control custom-input @error('password') is-invalid @enderror"
                                   id="password" name="password" required placeholder="Create a password (min. 8 characters)">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div class="mb-4">
                            <label for="password-confirm" class="form-label fw-medium text-dark">Confirm password</label>
                            <input type="password" class="form-control custom-input"
                                   id="password-confirm" name="password_confirmation" required placeholder="Re-enter your password">
                        </div>

                        {{-- Terms agreement --}}
                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                            <label class="form-check-label text-secondary" for="terms">
                                I agree to the <a href="{{ route('terms') }}" class="text-decoration-none" style="color: var(--primary-green);">Terms of Service</a> 
                                and <a href="{{ route('privacy') }}" class="text-decoration-none" style="color: var(--primary-green);">Privacy Policy</a>.
                            </label>
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">
                            <i class="bi bi-person-plus-fill me-2"></i> Create Account
                        </button>

                        {{-- Login link --}}
                        <div class="text-center mt-4">
                            <span class="text-secondary">Already have an account?</span>
                            <a href="{{ route('login') }}" class="text-decoration-none fw-bold ms-1" style="color: var(--primary-green);">
                                Log in
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection