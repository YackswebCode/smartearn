@extends('layouts.app')

@section('title', 'Terms of Service – SmartEarn')

@section('content')

{{-- ===== HERO – gradient green with animated SVGs ===== --}}
<section class="hero">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="z-index: 0; opacity: 0.2; pointer-events: none;">
        <svg width="100%" height="100%" viewBox="0 0 1200 800" xmlns="http://www.w3.org/2000/svg">
            <circle cx="20%" cy="30%" r="100" fill="none" stroke="white" stroke-width="2" class="svg-float" style="animation-delay: 0s;" />
            <circle cx="70%" cy="60%" r="150" fill="none" stroke="white" stroke-width="1.8" class="svg-float" style="animation-delay: 1.2s;" />
            <circle cx="85%" cy="20%" r="80" fill="none" stroke="white" stroke-width="1.2" class="svg-float" style="animation-delay: 0.5s;" />
        </svg>
    </div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center text-center">
            <div class="col-lg-10">
                <span class="section-tag">📜 Legal</span>
                <h1 class="display-3 fw-bold mb-4 text-white">
                    Terms of Service
                </h1>
                <p class="lead text-white-50 mx-auto" style="max-width: 700px;">
                    By using SmartEarn, you agree to these terms. Please read them carefully.
                </p>
                <p class="text-white-50 small mt-3">Last updated: February 2026</p>
            </div>
        </div>
    </div>
</section>

{{-- ===== TERMS CONTENT – light green background ===== --}}
<section class="py-5 section-green-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                {{-- Introduction --}}
                <div class="policy-card mb-5">
                    <h4 class="fw-bold mb-3" style="color: var(--primary-green);">1. Introduction</h4>
                    <p class="text-muted">
                        Welcome to SmartEarn. These Terms of Service (“Terms”) govern your use of our website, products, and services. 
                        By accessing or using SmartEarn, you agree to be bound by these Terms and our Privacy Policy. 
                        If you do not agree, please do not use our platform.
                    </p>
                </div>

                {{-- Accounts --}}
                <div class="policy-card mb-5">
                    <h4 class="fw-bold mb-3" style="color: var(--primary-green);">2. Accounts</h4>
                    <p class="text-muted">
                        You must be at least 18 years old to create an account. You are responsible for maintaining the security of your account and password. 
                        SmartEarn cannot and will not be liable for any loss or damage from your failure to comply with this security obligation.
                    </p>
                </div>

                {{-- Affiliates & Vendors --}}
                <div class="policy-card mb-5">
                    <h4 class="fw-bold mb-3" style="color: var(--primary-green);">3. Affiliates & Vendors</h4>
                    <p class="text-muted">
                        <strong>Affiliates:</strong> You may promote products listed by vendors and earn commissions as set by each vendor. 
                        Commissions are tracked in real time and paid out instantly upon withdrawal request, subject to minimum thresholds.<br><br>
                        <strong>Vendors:</strong> You may list physical or digital products. You set your own commission rates. 
                        A platform fee of 5% is deducted from each sale, plus the affiliate commission. You are responsible for fulfilling orders and handling customer inquiries.
                    </p>
                </div>

                {{-- Payments & Fees --}}
                <div class="policy-card mb-5">
                    <h4 class="fw-bold mb-3" style="color: var(--primary-green);">4. Payments & Fees</h4>
                    <p class="text-muted">
                        All payments are processed via our PCI‑DSS compliant partners (Paystack, Flutterwave). 
                        SmartEarn does not store your full bank details. Withdrawals are instant for most local currencies. 
                        Fees are clearly displayed before any transaction. We reserve the right to adjust fees with 30 days’ notice.
                    </p>
                </div>

                {{-- Prohibited Activities --}}
                <div class="policy-card mb-5">
                    <h4 class="fw-bold mb-3" style="color: var(--primary-green);">5. Prohibited Activities</h4>
                    <p class="text-muted">
                        You may not use SmartEarn for any illegal or unauthorized purpose. 
                        Prohibited activities include but are not limited to: fraud, money laundering, spamming, 
                        selling counterfeit goods, or any action that may damage, disable, or impair our platform.
                    </p>
                </div>

                {{-- Termination --}}
                <div class="policy-card mb-5">
                    <h4 class="fw-bold mb-3" style="color: var(--primary-green);">6. Termination</h4>
                    <p class="text-muted">
                        We may terminate or suspend your account immediately, without prior notice or liability, 
                        for any reason whatsoever, including without limitation if you breach the Terms. 
                        Upon termination, your right to use the Service will cease immediately.
                    </p>
                </div>

                {{-- Limitation of Liability --}}
                <div class="policy-card mb-5">
                    <h4 class="fw-bold mb-3" style="color: var(--primary-green);">7. Limitation of Liability</h4>
                    <p class="text-muted">
                        In no event shall SmartEarn, nor its directors, employees, partners, agents, suppliers, or affiliates, 
                        be liable for any indirect, incidental, special, consequential or punitive damages, 
                        including without limitation, loss of profits, data, use, goodwill, or other intangible losses, 
                        resulting from (i) your use or inability to use the Service; (ii) any conduct or content of any third party on the Service.
                    </p>
                </div>

                {{-- Changes to Terms --}}
                <div class="policy-card mb-5">
                    <h4 class="fw-bold mb-3" style="color: var(--primary-green);">8. Changes to Terms</h4>
                    <p class="text-muted">
                        We reserve the right, at our sole discretion, to modify or replace these Terms at any time. 
                        If a revision is material, we will try to provide at least 30 days' notice prior to any new terms taking effect. 
                        What constitutes a material change will be determined at our sole discretion.
                    </p>
                </div>

                {{-- Contact --}}
                <div class="policy-card mb-5">
                    <h4 class="fw-bold mb-3" style="color: var(--primary-green);">9. Contact Us</h4>
                    <p class="text-muted">
                        If you have any questions about these Terms, please contact us at:<br>
                        <strong>Email:</strong> legal@smartearn.com<br>
                        <strong>Address:</strong> 15B Admiralty Way, Lekki Phase 1, Lagos, Nigeria
                    </p>
                </div>

                <div class="text-muted small border-top pt-4 mt-4" style="border-color: rgba(6,87,84,0.1) !important;">
                    <p>These Terms of Service are effective as of February 11, 2026.</p>
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
                    <h3 class="fw-bold mb-2 text-white" style="font-size: 2rem;">Ready to start earning?</h3>
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