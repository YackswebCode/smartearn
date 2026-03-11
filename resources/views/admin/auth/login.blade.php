@extends('layouts.app') {{-- We can reuse the same app layout for login page --}}

@section('title', 'Admin Login – SmartEarn')

@section('content')
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
                    <div class="text-center mb-4">
                        <span class="d-inline-flex align-items-center justify-content-center bg-white rounded-3 shadow-sm"
                              style="width: 64px; height: 64px; color: var(--primary-green); font-size: 2rem; font-weight: 800;">
                            SE
                        </span>
                        <h2 class="fw-bold mt-4 mb-2" style="color: var(--primary-green);">Admin Login</h2>
                        <p class="text-secondary">Access the admin dashboard</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger mb-4" role="alert" style="border-radius: 16px; background: rgba(220,53,69,0.1); color: #dc3545; border: none;">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.login') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label fw-medium text-dark">Email address</label>
                            <input type="email" class="form-control custom-input" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@example.com">
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-medium text-dark">Password</label>
                            <input type="password" class="form-control custom-input" id="password" name="password" required placeholder="••••••••">
                        </div>

                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label text-secondary" for="remember">Remember me</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">
                            <i class="fas fa-lock me-2"></i> Log In
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection