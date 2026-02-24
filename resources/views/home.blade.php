@extends('layouts.app')

@section('title', 'SmartEarn – The Hybrid Affiliate & Vendor Platform')

@section('content')

{{-- ===== HERO SECTION – gradient green with floating SVG animation ===== --}}
<section class="hero">
    {{-- Animated floating circles SVG --}}
    <div class="position-absolute top-0 start-0 w-100 h-100" style="z-index: 0; opacity: 0.2; pointer-events: none;">
        <svg width="100%" height="100%" viewBox="0 0 1200 800" xmlns="http://www.w3.org/2000/svg">
            <circle cx="10%" cy="20%" r="80" fill="none" stroke="white" stroke-width="2" class="svg-float" style="animation-delay: 0s;" />
            <circle cx="80%" cy="60%" r="120" fill="none" stroke="white" stroke-width="1.5" class="svg-float" style="animation-delay: 2s;" />
            <circle cx="30%" cy="80%" r="60" fill="none" stroke="white" stroke-width="1" class="svg-float" style="animation-delay: 1s;" />
        </svg>
    </div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center">
            <div class="col-lg-6 hero-content">
                <span class="section-tag">🚀 Next‑Gen Affiliate Marketing</span>
                <h1 class="display-large fw-bold mb-4">
                    Earn, sell, and grow with 
                    <span style="color: white; text-decoration: underline; text-underline-offset: 12px; text-decoration-thickness: 4px;">SmartEarn</span>
                </h1>
                <p class="lead mb-4 text-white-50" style="font-size: 1.25rem;">
                    The first hybrid platform where affiliates and vendors thrive together. 
                    Multi‑currency, instant payouts, and full transparency – all in one place.
                </p>
                <div class="d-flex flex-wrap gap-3 mb-5">
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5 fw-bold" style="border-radius: 50px;">
                        <i class="bi bi-person-plus-fill me-2"></i>Start Earning
                    </a>
                    <a href="#" class="btn btn-outline-light btn-lg px-5 fw-bold" style="border-radius: 50px;">
                        <i class="bi bi-shop me-2"></i>Become a Vendor
                    </a>
                </div>
                <div class="d-flex align-items-center gap-4">
                    <div class="d-flex align-items-center">
                        <div class="d-flex me-2">
                            <img src="https://randomuser.me/api/portraits/women/11.jpg" class="rounded-circle border-2 border-white" width="32" height="32" style="margin-right: -8px;">
                            <img src="https://randomuser.me/api/portraits/men/21.jpg" class="rounded-circle border-2 border-white" width="32" height="32" style="margin-right: -8px;">
                            <img src="https://randomuser.me/api/portraits/women/33.jpg" class="rounded-circle border-2 border-white" width="32" height="32">
                        </div>
                        <span class="text-white fw-semibold">+2.5k affiliates</span>
                    </div>
                    <div class="vr bg-white" style="width: 2px; opacity: 0.3;"></div>
                    <div>
                        <span class="fw-bold text-white">₦50M+</span>
                        <span class="text-white-50 ms-1">paid this year</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mt-5 mt-lg-0 position-relative">
                <div class="hero-image-wrapper text-center">
                    <img src="https://images.unsplash.com/photo-1556761175-b413da4baf72?ixlib=rb-4.0.3&auto=format&fit=crop&w=1074&q=80" 
                         alt="Affiliate marketer working" class="img-fluid rounded-4 shadow-lg" style="max-height: 500px; width: 100%; object-fit: cover; border: 4px solid rgba(255,255,255,0.2);">
                    
                    {{-- Floating stat cards – now with glass effect --}}
                    <div class="stat-card stat-1">
                        <div class="stat-icon">
                            <i class="bi bi-cash-stack fs-4"></i>
                        </div>
                        <div>
                            <small class="text-muted text-uppercase">Commission</small>
                            <p class="mb-0 fw-bold">Up to 20%</p>
                        </div>
                    </div>
                    <div class="stat-card stat-2">
                        <div class="stat-icon">
                            <i class="bi bi-globe fs-4"></i>
                        </div>
                        <div>
                            <small class="text-muted text-uppercase">Currencies</small>
                            <p class="mb-0 fw-bold">NGN, USD, GHS, KES</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ===== FEATURES – white cards on soft green ===== --}}
<section class="py-5 section-green-extra-light">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <span class="section-tag" style="background: var(--primary-green); color: white;">Why SmartEarn</span>
                <h2 class="display-6 fw-bold mb-3" style="color: var(--primary-green);">Built for both sides of the marketplace</h2>
                <p class="text-muted fs-5">Affiliates get high commissions, vendors get more sales – and you keep full control.</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-link-45deg"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Affiliate First</h4>
                    <p class="text-muted">Share any product, track clicks, and earn up to 20% commission on every sale.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-shop"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Vendor Ready</h4>
                    <p class="text-muted">List digital or physical products, set your own commission, and get paid instantly.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-currency-exchange"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Multi‑Currency</h4>
                    <p class="text-muted">Operate in NGN, USD, GHS, KES, XAF – we handle the conversion automatically.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Admin Controlled</h4>
                    <p class="text-muted">Set fees, commissions, and exchange rates. You’re always in charge.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== HOW IT WORKS – dark green background, white steps ===== --}}
<section class="py-5 section-dark">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <span class="section-tag" style="background: rgba(255,255,255,0.2); color: white;">Simple, transparent, fast</span>
                <h2 class="display-6 fw-bold mb-3 text-white">How SmartEarn works</h2>
                <p class="text-white-50 fs-5">Three steps to start earning – whether you promote or sell.</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="step-item">
                    <div class="step-number">1</div>
                    <h4 class="fw-bold text-white">Create your account</h4>
                    <p class="text-white-50">Sign up for free, choose your path – affiliate or vendor. Takes 1 minute.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="step-item">
                    <div class="step-number">2</div>
                    <h4 class="fw-bold text-white">Start promoting / selling</h4>
                    <p class="text-white-50">Affiliates share links, vendors list products. Both earn in real time.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="step-item">
                    <div class="step-number">3</div>
                    <h4 class="fw-bold text-white">Withdraw anytime</h4>
                    <p class="text-white-50">Your earnings go to your wallet. Withdraw in your preferred currency.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== STATS – light green background, green cards ===== --}}
<section class="py-5 section-green-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="p-4 bg-white rounded-4 shadow-sm h-100 d-flex align-items-center">
                    <div class="rounded-3 p-3" style="background: rgba(6,87,84,0.1);">
                        <i class="bi bi-people fs-1" style="color: var(--primary-green);"></i>
                    </div>
                    <div class="ms-4">
                        <h3 class="fw-bold mb-1" style="color: var(--primary-green);">10,000+</h3>
                        <p class="text-muted mb-0">Active affiliates</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-white rounded-4 shadow-sm h-100 d-flex align-items-center">
                    <div class="rounded-3 p-3" style="background: rgba(6,87,84,0.1);">
                        <i class="bi bi-shop fs-1" style="color: var(--primary-green);"></i>
                    </div>
                    <div class="ms-4">
                        <h3 class="fw-bold mb-1" style="color: var(--primary-green);">2,500+</h3>
                        <p class="text-muted mb-0">Vendors</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-white rounded-4 shadow-sm h-100 d-flex align-items-center">
                    <div class="rounded-3 p-3" style="background: rgba(6,87,84,0.1);">
                        <i class="bi bi-cash-stack fs-1" style="color: var(--primary-green);"></i>
                    </div>
                    <div class="ms-4">
                        <h3 class="fw-bold mb-1" style="color: var(--primary-green);">₦120M+</h3>
                        <p class="text-muted mb-0">Commissions paid</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== TESTIMONIALS – extra light green, white cards ===== --}}
<section class="py-5 section-green-extra-light">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <span class="section-tag" style="background: var(--primary-green); color: white;">Success stories</span>
                <h2 class="display-6 fw-bold mb-3" style="color: var(--primary-green);">Trusted by thousands</h2>
                <p class="text-muted fs-5">Real affiliates and vendors, real results.</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="testimonial-card">
                    <div class="d-flex align-items-center mb-4">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" class="testimonial-avatar me-3" alt="Sarah">
                        <div>
                            <h5 class="fw-bold mb-0">Sarah Johnson</h5>
                            <small class="text-muted">Affiliate, Nigeria</small>
                        </div>
                    </div>
                    <div class="testimonial-quote mb-3">
                        “I’ve tried many affiliate programs, but SmartEarn’s commission rates and instant payouts are unmatched. I made ₦150k in my first month!”
                    </div>
                    <div class="text-warning">
                        ⭐⭐⭐⭐⭐
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="testimonial-card">
                    <div class="d-flex align-items-center mb-4">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" class="testimonial-avatar me-3" alt="Michael">
                        <div>
                            <h5 class="fw-bold mb-0">Michael Osei</h5>
                            <small class="text-muted">Vendor, Ghana</small>
                        </div>
                    </div>
                    <div class="testimonial-quote mb-3">
                        “Listing my digital products was easy. The platform fee is fair, and I love seeing my net earnings in real time. Highly recommended!”
                    </div>
                    <div class="text-warning">
                        ⭐⭐⭐⭐⭐
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="testimonial-card">
                    <div class="d-flex align-items-center mb-4">
                        <img src="https://randomuser.me/api/portraits/women/68.jpg" class="testimonial-avatar me-3" alt="Aisha">
                        <div>
                            <h5 class="fw-bold mb-0">Aisha Bello</h5>
                            <small class="text-muted">Affiliate, Kenya</small>
                        </div>
                    </div>
                    <div class="testimonial-quote mb-3">
                        “The multi-currency support is a game changer. I earn in KES, and the conversion is seamless. SmartEarn is truly international ready.”
                    </div>
                    <div class="text-warning">
                        ⭐⭐⭐⭐⭐
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== CTA BANNER – gradient green banner on extra light green background ===== --}}
<section class="py-5 section-green-extra-light">
    <div class="container">
        <div class="cta-banner">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-8 text-center text-lg-start">
                    <h3 class="fw-bold mb-2 text-white" style="font-size: 2rem;">Ready to grow with SmartEarn?</h3>
                    <p class="mb-4 text-white opacity-90 fs-5">Join the platform where affiliates and vendors succeed together.</p>
                </div>
                <div class="col-lg-4 text-center text-lg-end">
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5 py-3 fw-bold" style="border-radius: 50px;">
                        Get Started Free <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection