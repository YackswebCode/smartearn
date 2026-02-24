@extends('layouts.app')

@section('title', 'About SmartEarn – Our Mission & Team')

@section('content')

{{-- ===== HERO – gradient green with animated SVGs ===== --}}
<section class="hero">
    {{-- Animated floating circles --}}
    <div class="position-absolute top-0 start-0 w-100 h-100" style="z-index: 0; opacity: 0.2; pointer-events: none;">
        <svg width="100%" height="100%" viewBox="0 0 1200 800" xmlns="http://www.w3.org/2000/svg">
            <circle cx="15%" cy="25%" r="90" fill="none" stroke="white" stroke-width="2" class="svg-float" style="animation-delay: 0s;" />
            <circle cx="85%" cy="70%" r="130" fill="none" stroke="white" stroke-width="1.8" class="svg-float" style="animation-delay: 1.5s;" />
            <circle cx="40%" cy="80%" r="70" fill="none" stroke="white" stroke-width="1.2" class="svg-float" style="animation-delay: 0.8s;" />
        </svg>
    </div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center text-center">
            <div class="col-lg-10">
                <span class="section-tag">🚀 Who we are</span>
                <h1 class="display-3 fw-bold mb-4 text-white">
                    Building Africa’s leading<br>hybrid marketplace
                </h1>
                <p class="lead text-white-50 mx-auto" style="max-width: 800px;">
                    SmartEarn was founded to bridge the gap between affiliates and vendors – 
                    creating a transparent, multi‑currency ecosystem where both sides win.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- ===== OUR STORY / MISSION – light green background, white cards ===== --}}
<section class="py-5 section-green-light">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="position-relative">
                    <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80" 
                         alt="SmartEarn team collaborating" 
                         class="img-fluid rounded-4 shadow-lg" 
                         style="border: 4px solid rgba(6,87,84,0.2);">
                    {{-- Floating badge --}}
                    <div class="position-absolute bottom-0 start-0 translate-middle-y bg-white p-3 rounded-4 shadow" 
                         style="left: 20px !important; border-left: 6px solid var(--primary-green);">
                        <span class="fw-bold text-dark">Since 2021</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <span class="section-tag" style="background: var(--primary-green); color: white;">Our story</span>
                <h2 class="display-6 fw-bold mb-4" style="color: var(--primary-green);">From a bold idea to a thriving ecosystem</h2>
                <p class="text-muted fs-5 mb-4">
                    In 2021, we noticed a gap: affiliates in Africa had limited access to high‑commission programs, 
                    while vendors struggled to find trustworthy promoters. We built SmartEarn to solve both problems.
                </p>
                <p class="text-muted mb-4">
                    Today, we power over 10,000 affiliates and 2,500 vendors across Nigeria, Ghana, Kenya, and beyond – 
                    processing millions in commissions every month. Our mission remains simple: democratise earnings through technology.
                </p>
                <div class="d-flex gap-3">
                    <div>
                        <h3 class="fw-bold mb-0" style="color: var(--primary-green);">4+</h3>
                        <span class="text-muted">Years of trust</span>
                    </div>
                    <div class="vr bg-secondary"></div>
                    <div>
                        <h3 class="fw-bold mb-0" style="color: var(--primary-green);">₦120M+</h3>
                        <span class="text-muted">Commissions paid</span>
                    </div>
                    <div class="vr bg-secondary"></div>
                    <div>
                        <h3 class="fw-bold mb-0" style="color: var(--primary-green);">4</h3>
                        <span class="text-muted">Currencies</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== VALUES / CORE PRINCIPLES – extra light green, green cards ===== --}}
<section class="py-5 section-green-extra-light">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <span class="section-tag" style="background: var(--primary-green); color: white;">Our values</span>
                <h2 class="display-6 fw-bold mb-3" style="color: var(--primary-green);">What drives us every day</h2>
                <p class="text-muted fs-5">We built SmartEarn on four foundational pillars.</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="feature-card h-100 text-center">
                    <div class="feature-icon mx-auto">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Transparency</h4>
                    <p class="text-muted">Every click, sale, and commission is trackable in real time – no hidden fees.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-card h-100 text-center">
                    <div class="feature-icon mx-auto">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Community first</h4>
                    <p class="text-muted">We grow when our affiliates and vendors grow. Your success is our success.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-card h-100 text-center">
                    <div class="feature-icon mx-auto">
                        <i class="bi bi-globe"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Pan‑African</h4>
                    <p class="text-muted">Built for Africa, with multi‑currency support and local payment partners.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-card h-100 text-center">
                    <div class="feature-icon mx-auto">
                        <i class="bi bi-lightbulb-fill"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Innovation</h4>
                    <p class="text-muted">We constantly improve our platform – from instant payouts to advanced analytics.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== TIMELINE / MILESTONES – dark green background ===== --}}
<section class="py-5 section-dark">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <span class="section-tag" style="background: rgba(255,255,255,0.2); color: white;">Our journey</span>
                <h2 class="display-6 fw-bold mb-3 text-white">Key milestones</h2>
                <p class="text-white-50 fs-5">From launch to pan‑African expansion.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h4 class="fw-bold text-white">2021 – Launched in Lagos</h4>
                            <p class="text-white-50">Started with 50 beta affiliates and 10 vendors.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h4 class="fw-bold text-white">2022 – ₦10M paid</h4>
                            <p class="text-white-50">Reached first major commission milestone, expanded to Ghana.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h4 class="fw-bold text-white">2023 – Multi‑currency launch</h4>
                            <p class="text-white-50">Added USD, GHS, KES support; integrated Flutterwave & Paystack.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h4 class="fw-bold text-white">2024 – 10,000 affiliates</h4>
                            <p class="text-white-50">Hit 10k active affiliates, opened Nairobi office.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h4 class="fw-bold text-white">2025 – Vendor marketplace</h4>
                            <p class="text-white-50">Launched self‑service vendor dashboard and automated payouts.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== TEAM – light green background, white cards ===== --}}
<section class="py-5 section-green-light">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <span class="section-tag" style="background: var(--primary-green); color: white;">Leadership</span>
                <h2 class="display-6 fw-bold mb-3" style="color: var(--primary-green);">Meet the minds behind SmartEarn</h2>
                <p class="text-muted fs-5">A team passionate about empowering African creators and businesses.</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="team-card">
                    <div class="team-image-wrapper">
                        <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="Chidi Okafor" class="team-image">
                        <div class="team-social">
                            <a href="#" class="team-social-link"><i class="bi bi-linkedin"></i></a>
                            <a href="#" class="team-social-link"><i class="bi bi-twitter-x"></i></a>
                        </div>
                    </div>
                    <h4 class="fw-bold mb-1">Chidi Okafor</h4>
                    <p class="text-muted small mb-0">Co‑founder & CEO</p>
                    <p class="text-muted small">Ex‑Flutterwave, fintech builder</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="team-card">
                    <div class="team-image-wrapper">
                        <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="Ama Asare" class="team-image">
                        <div class="team-social">
                            <a href="#" class="team-social-link"><i class="bi bi-linkedin"></i></a>
                            <a href="#" class="team-social-link"><i class="bi bi-twitter-x"></i></a>
                        </div>
                    </div>
                    <h4 class="fw-bold mb-1">Ama Asare</h4>
                    <p class="text-muted small mb-0">Co‑founder & COO</p>
                    <p class="text-muted small">Operations, ex‑Paystack</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="team-card">
                    <div class="team-image-wrapper">
                        <img src="https://randomuser.me/api/portraits/men/30.jpg" alt="Tunde Bakare" class="team-image">
                        <div class="team-social">
                            <a href="#" class="team-social-link"><i class="bi bi-linkedin"></i></a>
                            <a href="#" class="team-social-link"><i class="bi bi-twitter-x"></i></a>
                        </div>
                    </div>
                    <h4 class="fw-bold mb-1">Tunde Bakare</h4>
                    <p class="text-muted small mb-0">CTO</p>
                    <p class="text-muted small">Full‑stack, scalability expert</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="team-card">
                    <div class="team-image-wrapper">
                        <img src="https://randomuser.me/api/portraits/women/50.jpg" alt="Fatima Suleiman" class="team-image">
                        <div class="team-social">
                            <a href="#" class="team-social-link"><i class="bi bi-linkedin"></i></a>
                            <a href="#" class="team-social-link"><i class="bi bi-twitter-x"></i></a>
                        </div>
                    </div>
                    <h4 class="fw-bold mb-1">Fatima Suleiman</h4>
                    <p class="text-muted small mb-0">Head of Partnerships</p>
                    <p class="text-muted small">Affiliate & vendor growth</p>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ===== CTA – gradient banner on extra light green ===== --}}
<section class="py-5 section-green-extra-light">
    <div class="container">
        <div class="cta-banner">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-8 text-center text-lg-start">
                    <h3 class="fw-bold mb-2 text-white" style="font-size: 2rem;">Be part of our story</h3>
                    <p class="mb-4 text-white opacity-90 fs-5">Join thousands of affiliates and vendors already growing with SmartEarn.</p>
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