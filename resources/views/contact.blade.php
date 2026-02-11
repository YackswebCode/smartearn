@extends('layouts.app')

@section('title', 'Contact SmartEarn – Get in Touch')

@section('content')

{{-- ===== HERO – gradient green with animated SVGs ===== --}}
<section class="hero">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="z-index: 0; opacity: 0.2; pointer-events: none;">
        <svg width="100%" height="100%" viewBox="0 0 1200 800" xmlns="http://www.w3.org/2000/svg">
            <circle cx="15%" cy="20%" r="80" fill="none" stroke="white" stroke-width="2" class="svg-float" style="animation-delay: 0s;" />
            <circle cx="80%" cy="50%" r="120" fill="none" stroke="white" stroke-width="1.8" class="svg-float" style="animation-delay: 1s;" />
            <circle cx="30%" cy="70%" r="100" fill="none" stroke="white" stroke-width="1.2" class="svg-float" style="animation-delay: 0.7s;" />
        </svg>
    </div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center text-center">
            <div class="col-lg-10">
                <span class="section-tag">📬 Let’s talk</span>
                <h1 class="display-3 fw-bold mb-4 text-white">
                    We’d love to hear from you
                </h1>
                <p class="lead text-white-50 mx-auto" style="max-width: 700px;">
                    Whether you have a question, feedback, or just want to say hello – our team is ready to help.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- ===== CONTACT CARDS + FORM – light green background ===== --}}
<section class="py-5 section-green-light">
    <div class="container">
        {{-- Contact info cards row --}}
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="contact-info-card">
                    <div class="contact-icon">
                        <i class="bi bi-envelope-fill"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Email us</h5>
                    <p class="text-muted mb-2">support@smartearn.com</p>
                    <p class="text-muted small">We reply within 24 hours</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="contact-info-card">
                    <div class="contact-icon">
                        <i class="bi bi-telephone-fill"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Call us</h5>
                    <p class="text-muted mb-2">+234 800 123 4567</p>
                    <p class="text-muted small">Mon–Fri, 9am–5pm WAT</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="contact-info-card">
                    <div class="contact-icon">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Visit us</h5>
                    <p class="text-muted mb-2">Lagos, Nigeria</p>
                    <p class="text-muted small">15B Admiralty Way, Lekki Phase 1</p>
                </div>
            </div>
        </div>

        {{-- Form + Map/Illustration --}}
        <div class="row g-5 align-items-stretch">
            <div class="col-lg-6">
                <div class="form-card h-100">
                    <h4 class="fw-bold mb-4" style="color: var(--primary-green);">
                        <i class="bi bi-chat-text-fill me-2"></i>Send us a message
                    </h4>
                    <form action="#" method="POST" id="contactForm">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="form-label fw-medium">Full name</label>
                            <input type="text" class="form-control custom-input" id="name" placeholder="Enter your name" required>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="form-label fw-medium">Email address</label>
                            <input type="email" class="form-control custom-input" id="email" placeholder="you@example.com" required>
                        </div>
                        <div class="mb-4">
                            <label for="subject" class="form-label fw-medium">Subject</label>
                            <select class="form-select custom-input" id="subject" required>
                                <option selected disabled>Choose a topic</option>
                                <option>Affiliate question</option>
                                <option>Vendor support</option>
                                <option>Payment inquiry</option>
                                <option>Partnership</option>
                                <option>Other</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="message" class="form-label fw-medium">Message</label>
                            <textarea class="form-control custom-input" id="message" rows="5" placeholder="How can we help you?" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold" style="background: var(--primary-green); border: none; border-radius: 50px;">
                            <i class="bi bi-send-fill me-2"></i>Send Message
                        </button>
                    </form>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-card h-100 d-flex flex-column">
                    <h4 class="fw-bold mb-4" style="color: var(--primary-green);">
                        <i class="bi bi-pin-map-fill me-2"></i>Our location
                    </h4>
                    <div class="map-placeholder flex-grow-1 d-flex align-items-center justify-content-center rounded-4" 
                         style="background: rgba(6,87,84,0.05); border: 2px dashed rgba(6,87,84,0.2); min-height: 300px;">
                        <div class="text-center">
                            <i class="bi bi-map fs-1" style="color: var(--primary-green); opacity: 0.5;"></i>
                            <p class="text-muted mt-3 mb-0">Interactive map coming soon</p>
                            <p class="text-muted small">Lagos • Accra • Nairobi</p>
                        </div>
                    </div>
                    {{-- Social links --}}
                    <div class="mt-5">
                        <h6 class="fw-bold mb-3">Connect with us</h6>
                        <div class="d-flex gap-3">
                            <a href="#" class="contact-social-link">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="#" class="contact-social-link">
                                <i class="bi bi-twitter-x"></i>
                            </a>
                            <a href="#" class="contact-social-link">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="#" class="contact-social-link">
                                <i class="bi bi-linkedin"></i>
                            </a>
                            <a href="#" class="contact-social-link">
                                <i class="bi bi-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== CTA – gradient banner ===== --}}
<section class="py-5 section-green-extra-light">
    <div class="container">
        <div class="cta-banner">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-8 text-center text-lg-start">
                    <h3 class="fw-bold mb-2 text-white" style="font-size: 2rem;">Prefer to start right away?</h3>
                    <p class="mb-4 text-white opacity-90 fs-5">Create your free account in under 2 minutes.</p>
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