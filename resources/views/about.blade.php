@extends('layouts.app')

@section('title', 'About SmartEarn – Monetize Your Knowledge, Learn What Pays')

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
                <span class="section-tag">📘 Next-Gen Skills-to-Income Platform</span>
                <h1 class="display-3 fw-bold mb-4 text-white">
                    Bridging the gap between<br>learning and earning
                </h1>
                <p class="lead text-white-50 mx-auto" style="max-width: 800px;">
                    SmartEarn empowers creators to turn knowledge into income and provides a gateway 
                    for aspiring builders to learn real-world, income-driven skills.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- ===== PROBLEM & SOLUTION – light green background, white cards ===== --}}
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
                <span class="section-tag" style="background: var(--primary-green); color: white;">The Problem we saw</span>
                <h2 class="display-6 fw-bold mb-3" style="color: var(--primary-green);">Talent without a structured platform</h2>
                <p class="text-muted fs-5 mb-4">
                    Many talented Africans have valuable skills but lack structured platforms to monetize them. 
                    Traditional education often teaches theory, not real-world, income-generating skills. 
                    Millions of young Africans want to earn online but don’t know what skills to learn or where to start.
                </p>
                <span class="section-tag mt-3" style="background: var(--primary-green); color: white;">The solution we’re bringing</span>
                <h2 class="display-6 fw-bold mb-3 mt-3" style="color: var(--primary-green);">Learning tied directly to earning opportunities</h2>
                <p class="text-muted mb-4">
                    We give creators a platform to turn their valuable skills, knowledge and solutions into a profitable business. 
                    We provide learners with accessible, practical, and results-driven education, creating a system where 
                    learning is directly tied to earning opportunities.
                </p>
                <div class="d-flex gap-3">
                    <div>
                        <h3 class="fw-bold mb-0" style="color: var(--primary-green);">5+</h3>
                        <span class="text-muted">Countries</span>
                    </div>
                    <div class="vr bg-secondary"></div>
                    <div>
                        <h3 class="fw-bold mb-0" style="color: var(--primary-green);">5000+</h3>
                        <span class="text-muted">Active Users</span>
                    </div>
                    <div class="vr bg-secondary"></div>
                    <div>
                        <h3 class="fw-bold mb-0" style="color: var(--primary-green);">$100K+</h3>
                        <span class="text-muted">Paid to Partners</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== WHAT DRIVES US – extra light green, green cards ===== --}}
<section class="py-5 section-green-extra-light">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <span class="section-tag" style="background: var(--primary-green); color: white;">What drives us</span>
                <h2 class="display-6 fw-bold mb-3" style="color: var(--primary-green);">The pillars behind every decision</h2>
                <p class="text-muted fs-5">Our commitment is built on four core principles.</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="feature-card h-100 text-center">
                    <div class="feature-icon mx-auto">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Bridging income & education gaps</h4>
                    <p class="text-muted">Getting paid for what you know and learning what only matters – closing the divide between skills and income.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-card h-100 text-center">
                    <div class="feature-icon mx-auto">
                        <i class="bi bi-diagram-3-fill"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Structure</h4>
                    <p class="text-muted">Helping every creator make money while pushing out solutions and running the whole process as a real business.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-card h-100 text-center">
                    <div class="feature-icon mx-auto">
                        <i class="bi bi-globe"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Pan‑African</h4>
                    <p class="text-muted">Built for Africa, with multi-currency support and local payment partners.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-card h-100 text-center">
                    <div class="feature-icon mx-auto">
                        <i class="bi bi-lightbulb-fill"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Innovation</h4>
                    <p class="text-muted">SmartEarn is constantly improved to ensure that users get the best experience.</p>
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
                <h2 class="display-6 fw-bold mb-3 text-white">From idea to ecosystem</h2>
                <p class="text-white-50 fs-5">Key milestones that shaped SmartEarn.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h4 class="fw-bold text-white">2021 – Problem Identified</h4>
                            <p class="text-white-50">Recognised the massive gap between learning and earning across Africa.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h4 class="fw-bold text-white">2022 – Platform Launch</h4>
                            <p class="text-white-50">Launched the SmartEarn marketplace for creators to sell digital products.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h4 class="fw-bold text-white">2023 – Multi‑currency Expansion</h4>
                            <p class="text-white-50">Added support for multiple currencies and expanded to Ghana and Kenya.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h4 class="fw-bold text-white">2024 – EdTech Integration</h4>
                            <p class="text-white-50">Launched SmartEarn Digital University to teach income‑driven skills.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h4 class="fw-bold text-white">2025 – Pan‑African Growth</h4>
                            <p class="text-white-50">5,000+ active users, $100K+ paid to partners, operations in 5 countries.</p>
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
                <p class="text-muted fs-5">A team passionate about empowering African creators and learners.</p>
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
                    <p class="text-muted small">Affiliate & creator growth</p>
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
                    <h3 class="fw-bold mb-2 text-white" style="font-size: 2rem;">Monetize your knowledge, learn what pays</h3>
                    <p class="mb-4 text-white opacity-90 fs-5">Join creators and learners already growing with SmartEarn.</p>
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