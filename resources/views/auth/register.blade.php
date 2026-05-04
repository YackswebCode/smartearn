@extends('layouts.app')

@section('title', 'Create Account – SmartEarn')

@section('content')
<section class="hero d-flex align-items-center" style="min-height: 100vh; background: var(--gradient-green); position: relative;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="z-index: 0; opacity: 0.15; pointer-events: none;">
        <svg width="100%" height="100%" viewBox="0 0 1200 800">
            <circle cx="20%" cy="30%" r="100" fill="none" stroke="white" stroke-width="2" class="svg-float" />
            <circle cx="70%" cy="60%" r="150" fill="none" stroke="white" stroke-width="1.8" class="svg-float" style="animation-delay: 1.2s;" />
            <circle cx="85%" cy="20%" r="80" fill="none" stroke="white" stroke-width="1.2" class="svg-float" style="animation-delay: 0.5s;" />
        </svg>
    </div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-8 col-xl-7">
                <div class="auth-card p-4 p-md-5 bg-white rounded-4 shadow-lg">
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="SmartEarn"  height="40">
                        <h2 class="fw-bold mt-4 mb-2" style="color: var(--primary-green);">Get started</h2>
                        <p class="text-secondary mb-0">Create your SmartEarn account — it is free</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark d-block mb-3">
                                What is your best use of SmartEarn today?
                            </label>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="account-option w-100">
                                        <input type="radio"
                                               name="account_type"
                                               value="ecommerce"
                                               class="account-type-input d-none"
                                               {{ old('account_type') === 'ecommerce' ? 'checked' : '' }}>
                                        <div class="option-card h-100 p-4 rounded-4 border bg-light">
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <div class="option-icon rounded-circle d-inline-flex align-items-center justify-content-center"
                                                     style="width: 52px; height: 52px; background: rgba(0,0,0,0.06);">
                                                    <i class="bi bi-bag-check fs-4" style="color: var(--primary-green);"></i>
                                                </div>
                                                <span class="badge rounded-pill text-bg-success-subtle text-success">Option 1</span>
                                            </div>
                                            <h5 class="fw-bold mb-2 text-dark">E-commerce</h5>
                                            <p class="text-secondary mb-0">Creator, Affiliate, Customer</p>
                                        </div>
                                    </label>
                                </div>

                                <div class="col-md-6">
                                    <label class="account-option w-100">
                                        <input type="radio"
                                               name="account_type"
                                               value="edtech"
                                               class="account-type-input d-none"
                                               {{ old('account_type') === 'edtech' ? 'checked' : '' }}>
                                        <div class="option-card h-100 p-4 rounded-4 border bg-light">
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <div class="option-icon rounded-circle d-inline-flex align-items-center justify-content-center"
                                                     style="width: 52px; height: 52px; background: rgba(0,0,0,0.06);">
                                                    <i class="bi bi-mortarboard fs-4" style="color: var(--primary-green);"></i>
                                                </div>
                                                <span class="badge rounded-pill text-bg-primary-subtle text-primary">Option 2</span>
                                            </div>
                                            <h5 class="fw-bold mb-2 text-dark">Edtech</h5>
                                            <p class="text-secondary mb-0">Business University</p>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            @error('account_type')
                                <div class="text-danger mt-2 small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="name" class="form-label fw-medium text-dark">Full name</label>
                            <input type="text"
                                   class="form-control custom-input @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name') }}"
                                   required
                                   autofocus
                                   placeholder="Enter your name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label fw-medium text-dark">Email address</label>
                            <input type="email"
                                   class="form-control custom-input @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   placeholder="you@example.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-medium text-dark">Password</label>
                            <input type="password"
                                   class="form-control custom-input @error('password') is-invalid @enderror"
                                   id="password"
                                   name="password"
                                   required
                                   placeholder="Create a password (min. 8 characters)">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password-confirm" class="form-label fw-medium text-dark">Confirm password</label>
                            <input type="password"
                                   class="form-control custom-input"
                                   id="password-confirm"
                                   name="password_confirmation"
                                   required
                                   placeholder="Re-enter your password">
                        </div>

                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                            <label class="form-check-label text-secondary" for="terms">
                                I agree to the
                                <a href="{{ route('terms') }}" class="text-decoration-none" style="color: var(--primary-green);">Terms of Service</a>
                                and
                                <a href="{{ route('privacy') }}" class="text-decoration-none" style="color: var(--primary-green);">Privacy Policy</a>.
                            </label>
                            @error('terms')
                                <div class="text-danger mt-2 small">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">
                            <i class="bi bi-person-plus-fill me-2"></i> Create Account
                        </button>

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

<style>
    .account-option {
        cursor: pointer;
    }

    .option-card {
        transition: all .25s ease;
        border: 1px solid #e9ecef;
        background: #f8f9fa;
    }

    .account-option input:checked + .option-card {
        border-color: var(--primary-green);
        background: rgba(25, 135, 84, 0.08);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        transform: translateY(-2px);
    }

    .account-option:hover .option-card {
        border-color: var(--primary-green);
    }

    .custom-input {
        border-radius: 14px;
        padding: 0.9rem 1rem;
    }

    .custom-input:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.15);
    }
</style>
@endsection