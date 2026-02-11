@extends('layouts.app')

@section('title', 'Frequently Asked Questions – SmartEarn Help Center')

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
                <span class="section-tag">❓ Got questions?</span>
                <h1 class="display-3 fw-bold mb-4 text-white">
                    We’ve got answers
                </h1>
                <p class="lead text-white-50 mx-auto" style="max-width: 700px;">
                    Everything you need to know about SmartEarn – from commissions to withdrawals.
                    Can’t find what you’re looking for? Just reach out.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- ===== FAQ ACCORDION – light green background ===== --}}
<section class="py-5 section-green-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="text-center mb-5">
                    <span class="section-tag" style="background: var(--primary-green); color: white;">FAQ</span>
                    <h2 class="display-6 fw-bold mb-3" style="color: var(--primary-green);">Frequently asked questions</h2>
                    <p class="text-muted fs-5">Quick answers to common questions about our platform.</p>
                </div>

                {{-- Bootstrap 5 Accordion with custom styling --}}
                <div class="accordion custom-accordion" id="faqAccordion">
                    {{-- Category: Getting Started --}}
                    <h5 class="mt-4 mb-3 fw-bold" style="color: var(--primary-green);">
                        <i class="bi bi-rocket-takeoff me-2"></i> Getting Started
                    </h5>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="true">
                                How do I sign up as an affiliate or vendor?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Simply click the <strong>Register</strong> button on the top right. Choose your path – Affiliate or Vendor – fill in your details, and you’re ready to go. It takes less than 2 minutes.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                Is there any cost to join SmartEarn?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Joining as an affiliate is <strong>completely free</strong>. Vendors pay a small commission on sales (from 2% to 5%) – no monthly subscription fees.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                Can I be both an affiliate and a vendor?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Absolutely! You can have both roles under one account. Just visit your dashboard and complete the vendor verification to start selling.
                            </div>
                        </div>
                    </div>

                    {{-- Category: Commissions & Payments --}}
                    <h5 class="mt-5 mb-3 fw-bold" style="color: var(--primary-green);">
                        <i class="bi bi-cash-coin me-2"></i> Commissions & Payments
                    </h5>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                How much commission can I earn as an affiliate?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Commission rates are set by vendors and typically range from 5% to 20% per sale. You can see the exact commission on each product page.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                When do I get paid?
                            </button>
                        </h2>
                        <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Payouts are <strong>instant</strong> once you request a withdrawal from your wallet (minimum ₦1,000 or equivalent). Funds are sent to your bank or mobile money within seconds.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq6">
                                What currencies are supported?
                            </button>
                        </h2>
                        <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                We currently support <strong>NGN, USD, GHS, KES, and XAF</strong>. You can hold multiple currency wallets and withdraw in your local currency.
                            </div>
                        </div>
                    </div>

                    {{-- Category: Vendor Questions --}}
                    <h5 class="mt-5 mb-3 fw-bold" style="color: var(--primary-green);">
                        <i class="bi bi-shop me-2"></i> For Vendors
                    </h5>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq7">
                                How do I list my products?
                            </button>
                        </h2>
                        <div id="faq7" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                After vendor approval, go to your dashboard → Products → Add New Product. Fill in the details, set your price and affiliate commission, and publish. It goes live immediately.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq8">
                                What fees do vendors pay?
                            </button>
                        </h2>
                        <div id="faq8" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Vendors pay a <strong>platform fee of 5%</strong> on each sale + the affiliate commission you set. There are no listing or monthly fees.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq9">
                                Can I sell digital products?
                            </button>
                        </h2>
                        <div id="faq9" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes! Digital products (e‑books, courses, software) are supported. We provide secure file hosting and automatic delivery after purchase.
                            </div>
                        </div>
                    </div>

                    {{-- Category: Account & Security --}}
                    <h5 class="mt-5 mb-3 fw-bold" style="color: var(--primary-green);">
                        <i class="bi bi-shield-lock me-2"></i> Account & Security
                    </h5>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq10">
                                How do I reset my password?
                            </button>
                        </h2>
                        <div id="faq10" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Click <strong>Log in</strong> → <strong>Forgot password?</strong> Enter your email, and we’ll send a reset link within a minute.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq11">
                                Is my payment information secure?
                            </button>
                        </h2>
                        <div id="faq11" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Absolutely. We use bank‑grade encryption, and we never store your full bank details. All payments are processed by PCI‑DSS compliant partners (Paystack, Flutterwave).
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Still have questions? --}}
                <div class="text-center mt-5 pt-4">
                    <div class="p-5 bg-white rounded-4 shadow-sm" style="border: 1px solid rgba(6,87,84,0.1);">
                        <i class="bi bi-chat-dots-fill fs-1" style="color: var(--primary-green);"></i>
                        <h4 class="fw-bold mt-3 mb-2">Still have questions?</h4>
                        <p class="text-muted mb-4">Can’t find the answer you’re looking for? Please chat with our friendly team.</p>
                        <a href="{{ route('contact') }}" class="btn btn-primary btn-lg px-5 fw-bold" style="background: var(--primary-green); border: none; border-radius: 50px;">
                            <i class="bi bi-envelope-paper-fill me-2"></i>Contact Support
                        </a>
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