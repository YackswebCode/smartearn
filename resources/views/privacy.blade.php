@extends('layouts.app')

@section('title', 'Privacy Policy – SmartEarn')

@section('content')

{{-- ===== HERO – gradient green with animated SVGs ===== --}}
<section class="hero">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="z-index: 0; opacity: 0.2; pointer-events: none;">
        <svg width="100%" height="100%" viewBox="0 0 1200 800" xmlns="http://www.w3.org/2000/svg">
            <circle cx="15%" cy="25%" r="90" fill="none" stroke="white" stroke-width="2" class="svg-float" style="animation-delay: 0s;" />
            <circle cx="80%" cy="55%" r="140" fill="none" stroke="white" stroke-width="1.8" class="svg-float" style="animation-delay: 1.5s;" />
            <circle cx="35%" cy="75%" r="70" fill="none" stroke="white" stroke-width="1.2" class="svg-float" style="animation-delay: 0.9s;" />
        </svg>
    </div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row justify-content-center text-center">
            <div class="col-lg-10">
                <span class="section-tag">Privacy</span>
                <h1 class="display-3 fw-bold mb-4 text-white">
                    Privacy Policy
                </h1>
                <p class="lead text-white-50 mx-auto" style="max-width: 700px;">
                    Your privacy is critically important to us. Here’s how we protect your data.
                </p>
                <p class="text-white-50 small mt-3">Last updated: February 2026</p>
            </div>
        </div>
    </div>
</section>

{{-- ===== PRIVACY CONTENT – light green background ===== --}}
<section class="py-5 section-green-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                {{-- Introduction --}}
                <div class="policy-card mb-5">
                    <h4 class="fw-bold mb-3" style="color: var(--primary-green);">1. Introduction</h4>
                    <p class="text-muted">
                        SmartEarn (“we”, “us”, or “our”) operates the SmartEarn platform. This page informs you of our policies 
                        regarding the collection, use, and disclosure of personal data when you use our Service and the choices you have associated with that data.
                    </p>
                </div>

                {{-- Information Collection --}}
                <div class="policy-card mb-5">
                    <h4 class="fw-bold mb-3" style="color: var(--primary-green);">2. Information We Collect</h4>
                    <p class="text-muted">
                        <strong>Personal Data:</strong> While using our Service, we may ask you to provide certain personally identifiable information 
                        that can be used to contact or identify you (“Personal Data”). This includes but is not limited to:<br>
                        • Email address<br>
                        • First name and last name<br>
                        • Phone number<br>
                        • Bank account details (processed securely via our payment partners – we never store full account numbers)<br>
                        • Address, State, Province, ZIP/Postal code, City<br><br>
                        <strong>Usage Data:</strong> We may also collect information on how the Service is accessed and used (“Usage Data”). 
                        This includes your computer’s IP address, browser type, pages visited, time and date of visits, and other diagnostic data.
                    </p>
                </div>

                {{-- Use of Data --}}
                <div class="policy-card mb-5">
                    <h4 class="fw-bold mb-3" style="color: var(--primary-green);">3. How We Use Your Data</h4>
                    <p class="text-muted">
                        SmartEarn uses the collected data for various purposes:<br>
                        • To provide and maintain our Service<br>
                        • To notify you about changes to our Service<br>
                        • To allow you to participate in interactive features when you choose to do so<br>
                        • To provide customer support<br>
                        • To gather analysis or valuable information so that we can improve our Service<br>
                        • To monitor the usage of our Service<br>
                        • To detect, prevent and address technical issues<br>
                        • To process transactions and send you related information
                    </p>
                </div>

                {{-- Data Security --}}
                <div class="policy-card mb-5">
                    <h4 class="fw-bold mb-3" style="color: var(--primary-green);">4. Data Security</h4>
                    <p class="text-muted">
                        The security of your data is important to us. We use industry-standard encryption (SSL/TLS) and follow PCI DSS guidelines 
                        to protect sensitive information. However, remember that no method of transmission over the Internet, 
                        or method of electronic storage, is 100% secure. While we strive to use commercially acceptable means to protect your Personal Data, 
                        we cannot guarantee its absolute security.
                    </p>
                </div>

                {{-- Third-Party Services --}}
                <div class="policy-card mb-5">
                    <h4 class="fw-bold mb-3" style="color: var(--primary-green);">5. Third-Party Service Providers</h4>
                    <p class="text-muted">
                        We employ third-party companies and individuals to facilitate our Service (“Service Providers”), 
                        to provide the Service on our behalf, to perform Service-related services, or to assist us in analysing how our Service is used. 
                        These third parties have access to your Personal Data only to perform these tasks on our behalf and are obligated not to disclose or use it for any other purpose.<br><br>
                        Our payment processors (Paystack, Flutterwave) are PCI DSS compliant and handle your payment information securely.
                    </p>
                </div>

                {{-- Cookies --}}
                <div class="policy-card mb-5">
                    <h4 class="fw-bold mb-3" style="color: var(--primary-green);">6. Cookies</h4>
                    <p class="text-muted">
                        We use cookies and similar tracking technologies to track the activity on our Service and hold certain information. 
                        Cookies are files with small amount of data which may include an anonymous unique identifier. 
                        You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent. 
                        However, if you do not accept cookies, you may not be able to use some portions of our Service.
                    </p>
                </div>

                {{-- Your Rights --}}
                <div class="policy-card mb-5">
                    <h4 class="fw-bold mb-3" style="color: var(--primary-green);">7. Your Data Protection Rights</h4>
                    <p class="text-muted">
                        Depending on your location, you may have the following rights regarding your personal data:<br>
                        • The right to access – request copies of your personal data.<br>
                        • The right to rectification – request correction of inaccurate information.<br>
                        • The right to erasure – request deletion of your personal data, under certain conditions.<br>
                        • The right to restrict processing – request limitation of processing, under certain conditions.<br>
                        • The right to object to processing – object to our use of your data, under certain conditions.<br>
                        • The right to data portability – request transfer of your data to another organisation.<br><br>
                        To exercise any of these rights, please contact us at privacy@smartearn.com.
                    </p>
                </div>

                {{-- Children's Privacy --}}
                <div class="policy-card mb-5">
                    <h4 class="fw-bold mb-3" style="color: var(--primary-green);">8. Children’s Privacy</h4>
                    <p class="text-muted">
                        Our Service does not address anyone under the age of 18 (“Children”). We do not knowingly collect personally identifiable information from anyone under 18. 
                        If you are a parent or guardian and you are aware that your Child has provided us with Personal Data, please contact us.
                    </p>
                </div>

                {{-- Changes to Policy --}}
                <div class="policy-card mb-5">
                    <h4 class="fw-bold mb-3" style="color: var(--primary-green);">9. Changes to This Privacy Policy</h4>
                    <p class="text-muted">
                        We may update our Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page 
                        and updating the “last updated” date at the top. You are advised to review this Privacy Policy periodically for any changes.
                    </p>
                </div>

                {{-- Contact --}}
                <div class="policy-card mb-5">
                    <h4 class="fw-bold mb-3" style="color: var(--primary-green);">10. Contact Us</h4>
                    <p class="text-muted">
                        If you have any questions about this Privacy Policy, please contact us:<br>
                        <strong>Email:</strong> privacy@smartearn.com<br>
                        <strong>Address:</strong> 15B Admiralty Way, Lekki Phase 1, Lagos, Nigeria
                    </p>
                </div>

                <div class="text-muted small border-top pt-4 mt-4" style="border-color: rgba(6,87,84,0.1) !important;">
                    <p>This Privacy Policy is effective as of February 11, 2026.</p>
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
                    <h3 class="fw-bold mb-2 text-white" style="font-size: 2rem;">Trusted by thousands</h3>
                    <p class="mb-4 text-white opacity-90 fs-5">Join SmartEarn today – your privacy is our priority.</p>
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