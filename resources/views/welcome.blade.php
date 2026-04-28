@extends('layouts.app')

@section('title', 'SmartEarn – Monetize Your Expertise, Learn What Pays')

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
                <span class="section-tag">📘 Monetize Your Expertise, Learn What Pays</span>
                <h1 class="display-large fw-bold mb-4">
                    1 Platform. 2 Paths.
                </h1>
                <p class="lead mb-4 text-white-50" style="font-size: 1.25rem;">
                    SmartEarn is an E-commerce X EdTech platform where creators turn their knowledge into income and aspiring builders learn real-world skills that pay.
                </p>
                <div class="d-flex flex-wrap gap-3 mb-5">
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5 fw-bold" style="border-radius: 50px;">
                        <i class="bi bi-arrow-right me-2"></i>Get Started with SmartEarn
                    </a>
                </div>
                <div class="d-flex align-items-center gap-4">
                    <div class="d-flex align-items-center">
                        <div class="d-flex me-2">
                            <img src="https://randomuser.me/api/portraits/women/11.jpg" class="rounded-circle border-2 border-white" width="32" height="32" style="margin-right: -8px;">
                            <img src="https://randomuser.me/api/portraits/men/21.jpg" class="rounded-circle border-2 border-white" width="32" height="32" style="margin-right: -8px;">
                            <img src="https://randomuser.me/api/portraits/women/33.jpg" class="rounded-circle border-2 border-white" width="32" height="32">
                        </div>
                        <span class="text-white fw-semibold">5+ Countries</span>
                    </div>
                    <div class="vr bg-white" style="width: 2px; opacity: 0.3;"></div>
                    <div>
                        <span class="fw-bold text-white">$100K+</span>
                        <span class="text-white-50 ms-1">paid to partners</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mt-5 mt-lg-0 position-relative">
                <div class="hero-image-wrapper text-center">
                    <img src="https://images.unsplash.com/photo-1556761175-b413da4baf72?ixlib=rb-4.0.3&auto=format&fit=crop&w=1074&q=80" 
                         alt="SmartEarn platform dashboard" class="img-fluid rounded-4 shadow-lg" style="max-height: 500px; width: 100%; object-fit: cover; border: 4px solid rgba(255,255,255,0.2);">
                    
                    {{-- Floating stat cards – now with glass effect --}}
                    <div class="stat-card stat-1">
                        <div class="stat-icon">
                            <i class="bi bi-globe fs-4"></i>
                        </div>
                        <div>
                            <small class="text-muted text-uppercase">Countries</small>
                            <p class="mb-0 fw-bold">5+ Across Africa</p>
                        </div>
                    </div>
                    <div class="stat-card stat-2">
                        <div class="stat-icon">
                            <i class="bi bi-people fs-4"></i>
                        </div>
                        <div>
                            <small class="text-muted text-uppercase">Users</small>
                            <p class="mb-0 fw-bold">5,000+ Active</p>
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
                <span class="section-tag" style="background: var(--primary-green); color: white;">One Ecosystem, Multiple Tools</span>
                <h2 class="display-6 fw-bold mb-3" style="color: var(--primary-green);">Everything you need to sell and earn</h2>
                <p class="text-muted fs-5">From hosting digital products to scaling with affiliates, SmartEarn has got you covered.</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-cloud-upload"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Host Digital Products</h4>
                    <p class="text-muted">Never worry about delivery. Ebooks, templates, courses, memberships are accessed with ease.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-currency-exchange"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Multi‑Currency</h4>
                    <p class="text-muted">Get paid in different currencies while we handle the conversion automatically.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Accurate Tracking & Payouts</h4>
                    <p class="text-muted">Sell and receive earnings seamlessly. We keep all records clean for you.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Scale with Affiliates</h4>
                    <p class="text-muted">List products on SmartEarn marketplace and let our super affiliates drive sales.</p>
                </div>
            </div>
        </div>

        {{-- extra CTA after feature cards --}}
        <div class="text-center mt-5">
            <a href="{{ route('register') }}" class="btn btn-success btn-lg px-5 fw-bold" style="border-radius: 50px;">
                Get Started with SmartEarn <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

{{-- ===== DIGITAL UNIVERSITY – dark green background, white steps ===== --}}
<section class="py-5 section-dark">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <span class="section-tag" style="background: rgba(255,255,255,0.2); color: white;">SmartEarn Digital University</span>
                <h2 class="display-6 fw-bold mb-3 text-white">Learn skills that pay – on your terms</h2>
                <p class="text-white-50 fs-5">Join our results-driven EdTech system and get equipped for the modern digital economy.</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="step-item">
                    <div class="step-number">1</div>
                    <h4 class="fw-bold text-white">Practical, Real-World Curriculum</h4>
                    <p class="text-white-50">No theory. Learn skills directly applicable to high-paying jobs and projects.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="step-item">
                    <div class="step-number">2</div>
                    <h4 class="fw-bold text-white">Structured Learning Tracks</h4>
                    <p class="text-white-50">Zero confusion. Master one high-value track at a time until you're job-ready.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="step-item">
                    <div class="step-number">3</div>
                    <h4 class="fw-bold text-white">Certifications & Opportunities</h4>
                    <p class="text-white-50">Earn certificates and get connected to real companies for work opportunities.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== STATS – light green background, green cards ===== --}}
<section class="py-5 section-green-light">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-md-6 col-lg-3">
                <div class="p-4 bg-white rounded-4 shadow-sm h-100 d-flex align-items-center">
                    <div class="rounded-3 p-3" style="background: rgba(6,87,84,0.1);">
                        <i class="bi bi-globe2 fs-1" style="color: var(--primary-green);"></i>
                    </div>
                    <div class="ms-4">
                        <h3 class="fw-bold mb-1" style="color: var(--primary-green);">5+</h3>
                        <p class="text-muted mb-0">Countries</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="p-4 bg-white rounded-4 shadow-sm h-100 d-flex align-items-center">
                    <div class="rounded-3 p-3" style="background: rgba(6,87,84,0.1);">
                        <i class="bi bi-people fs-1" style="color: var(--primary-green);"></i>
                    </div>
                    <div class="ms-4">
                        <h3 class="fw-bold mb-1" style="color: var(--primary-green);">5000+</h3>
                        <p class="text-muted mb-0">Active users</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="p-4 bg-white rounded-4 shadow-sm h-100 d-flex align-items-center">
                    <div class="rounded-3 p-3" style="background: rgba(6,87,84,0.1);">
                        <i class="bi bi-brush fs-1" style="color: var(--primary-green);"></i>
                    </div>
                    <div class="ms-4">
                        <h3 class="fw-bold mb-1" style="color: var(--primary-green);">50+</h3>
                        <p class="text-muted mb-0">Creators</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="p-4 bg-white rounded-4 shadow-sm h-100 d-flex align-items-center">
                    <div class="rounded-3 p-3" style="background: rgba(6,87,84,0.1);">
                        <i class="bi bi-cash-stack fs-1" style="color: var(--primary-green);"></i>
                    </div>
                    <div class="ms-4">
                        <h3 class="fw-bold mb-1" style="color: var(--primary-green);">$100K+</h3>
                        <p class="text-muted mb-0">Paid to partners</p>
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
                <span class="section-tag" style="background: var(--primary-green); color: white;">Testimonials</span>
                <h2 class="display-6 fw-bold mb-3" style="color: var(--primary-green);">SmartEarners say we’re good at what we do</h2>
                <p class="text-muted fs-5">Hear from our community.</p>
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
                    <p class="mb-4 text-white opacity-90 fs-5">Join the platform where creators and learners succeed together.</p>
                </div>
                <div class="col-lg-4 text-center text-lg-end">
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5 py-3 fw-bold" style="border-radius: 50px;">
                        Sign Up Free <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection