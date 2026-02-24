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
                        <p class="text-secondary">We've sent a verification link to your email address.</p>
                    </div>

                    @if (session('resent'))
                        <div class="alert alert-success mb-4" role="alert" style="border-radius: 16px; background: rgba(6,87,84,0.1); color: var(--primary-green); border: none;">
                            A fresh verification link has been sent to your email address.
                        </div>
                    @endif

                    <div class="text-secondary mb-4">
                        Before proceeding, please check your email for a verification link. 
                        If you did not receive the email, we can send another.
                    </div>

                    <form method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">
                            <i class="bi bi-envelope-arrow-up-fill me-2"></i> Resend Verification Email
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <a href="{{ route('logout') }}" class="text-decoration-none" style="color: var(--primary-green);"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right me-1"></i> Log out
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection