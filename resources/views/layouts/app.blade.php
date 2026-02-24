<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'SmartEarn'))</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Custom SmartEarn CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">

    <div id="app" class="d-flex flex-column flex-grow-1 position-relative">

        {{-- === ANIMATED SVG BACKGROUND (rotating rings) === --}}
        <div class="position-fixed top-0 start-0 w-100 h-100 pointer-events-none" style="z-index: -1; opacity: 0.15;">
            <svg width="100%" height="100%" viewBox="0 0 800 600" xmlns="http://www.w3.org/2000/svg" class="svg-rotate">
                <circle cx="200" cy="100" r="80" fill="none" stroke="var(--primary-green)" stroke-width="2" stroke-dasharray="10 10" />
                <circle cx="700" cy="400" r="120" fill="none" stroke="var(--light-green)" stroke-width="1.5" stroke-dasharray="15 15" />
                <circle cx="50" cy="500" r="60" fill="none" stroke="var(--primary-green)" stroke-width="1" stroke-dasharray="8 8" />
            </svg>
        </div>

        {{-- ===== NAVBAR – Signature Green with blur ===== --}}
        <nav class="navbar navbar-expand-lg sticky-top" style="background: rgba(6,87,84,0.95); backdrop-filter: blur(10px); box-shadow: 0 8px 20px rgba(6,87,84,0.15);">
            <div class="container">
                <!-- Brand with iconic SE badge -->
                <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ url('/') }}">
                    <span class="brand-icon d-flex align-items-center justify-content-center" 
                          style="background-color: white; color: var(--primary-green); width: 40px; height: 40px; border-radius: 10px; margin-right: 10px; font-size: 1.25rem; font-weight: 800; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
                        SE
                    </span>
                    <span class="text-white" style="font-size: 1.5rem; letter-spacing: -0.5px;">SmartEarn</span>
                </a>
<button class="navbar-toggler border-0"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
        style="background: white; border-radius:6px;">

    <img src="https://www.clipartmax.com/png/middle/110-1101213_toggle-menu-menu-icon-png-blue.png"
         alt="Menu"
         width="30"
         height="30"
         style="object-fit: contain;">
</button>



                <div class="collapse navbar-collapse" id="navbarNav">
                    <!-- Center navigation -->
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        <li class="nav-item px-lg-2">
                            <a class="nav-link text-white fw-semibold px-3 py-2 {{ request()->is('/') ? 'active-nav' : '' }}" 
                               href="{{ url('/') }}">Home</a>
                        </li>
                      <li class="nav-item px-lg-2">
                            <a class="nav-link text-white fw-semibold px-3 py-2 {{ request()->routeIs('about') ? 'active-nav' : '' }}" 
                            href="{{ route('about') }}">About</a>
                        </li>
                       <li class="nav-item px-lg-2">
                            <a class="nav-link text-white fw-semibold px-3 py-2 {{ request()->routeIs('faq') ? 'active-nav' : '' }}" 
                            href="{{ route('faq') }}">FAQ</a>
                        </li>
                        <li class="nav-item px-lg-2">
                            <a class="nav-link text-white fw-semibold px-3 py-2 {{ request()->routeIs('contact') ? 'active-nav' : '' }}" 
                            href="{{ route('contact') }}">Contact</a>
                        </li>
                    </ul>

                    <!-- Right auth section -->
                    <ul class="navbar-nav ms-auto align-items-center">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link text-white px-3 py-2 fw-medium" href="{{ route('login') }}" 
                                   style="opacity: 0.9; transition: opacity 0.2s;">
                                    <i class="bi bi-box-arrow-in-right me-1"></i> Log in
                                </a>
                            </li>
                            <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                                <a class="btn fw-semibold px-4 py-2" href="{{ route('register') }}" 
                                   style="background-color: white; color: var(--primary-green); border-radius: 50px; border: none; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                                    <i class="bi bi-person-plus-fill me-1"></i> Register
                                </a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#" 
                                   id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="avatar-placeholder me-2 d-flex align-items-center justify-content-center"
                                          style="width: 32px; height: 32px; background-color: rgba(255,255,255,0.2); border-radius: 50%; color: white; font-size: 0.9rem; font-weight: 600;">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </span>
                                    {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="border-radius: 12px; padding: 0.5rem 0;">
                                    <li><a class="dropdown-item py-2" href="#"><i class="bi bi-speedometer2 me-2" style="color: var(--primary-green);"></i> Dashboard</a></li>
                                    <li><a class="dropdown-item py-2" href="#"><i class="bi bi-wallet2 me-2" style="color: var(--primary-green);"></i> Wallet</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item py-2" href="{{ route('logout') }}" 
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="bi bi-box-arrow-right me-2" style="color: var(--primary-green);"></i> Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        {{-- ===== MAIN CONTENT – with subtle green background ===== --}}
        <main class="flex-grow-1 position-relative" style="background-color: var(--green-extra-light);">
            @yield('content')
        </main>

     {{-- ===== FOOTER – Deep Green, Rich Typography ===== --}}
<footer class="footer mt-auto" style="background: linear-gradient(145deg, #043a38 0%, #065754 100%); color: rgba(255,255,255,0.9);">
    <div class="container py-5">
        <div class="row g-4">
            <!-- Brand column -->
            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="d-flex align-items-center mb-3">
                    <span class="d-flex align-items-center justify-content-center" 
                          style="width: 48px; height: 48px; background-color: rgba(255,255,255,0.1); border-radius: 12px; margin-right: 12px;">
                        <span style="color: white; font-size: 1.5rem; font-weight: 700;">SE</span>
                    </span>
                    <h4 class="text-white fw-bold mb-0" style="letter-spacing: -0.5px;">SmartEarn</h4>
                </div>
                <p class="text-white-50 small" style="line-height: 1.7;">
                    The hybrid platform where affiliates and vendors thrive. 
                    Multi‑currency, instant payouts, and full transparency.
                </p>
                <div class="d-flex gap-3 mt-4">
                    <a href="#" class="text-white-50 hover-lift" style="font-size: 1.5rem; transition: all 0.2s;">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="text-white-50 hover-lift" style="font-size: 1.5rem; transition: all 0.2s;">
                        <i class="bi bi-twitter-x"></i>
                    </a>
                    <a href="#" class="text-white-50 hover-lift" style="font-size: 1.5rem; transition: all 0.2s;">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="#" class="text-white-50 hover-lift" style="font-size: 1.5rem; transition: all 0.2s;">
                        <i class="bi bi-linkedin"></i>
                    </a>
                </div>
            </div>

            <!-- Company links -->
            <div class="col-lg-2 col-md-4 offset-lg-1">
                <h6 class="text-white fw-bold mb-4">Company</h6>
                <ul class="list-unstyled">
                    <li class="mb-3">
                        <a href="{{ route('about') }}" class="text-white-50 text-decoration-none small hover-white">
                            About Us
                        </a>
                    </li>
                    <li class="mb-3">
                        <a href="{{ route('faq') }}" class="text-white-50 text-decoration-none small hover-white">
                            FAQ
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Support & Legal -->
            <div class="col-lg-2 col-md-4">
                <h6 class="text-white fw-bold mb-4">Legal</h6>
                <ul class="list-unstyled">
                    <li class="mb-3">
                        <a href="{{ route('terms') }}" class="text-white-50 text-decoration-none small hover-white">
                            Terms of Service
                        </a>
                    </li>
                    <li class="mb-3">
                        <a href="{{ route('privacy') }}" class="text-white-50 text-decoration-none small hover-white">
                            Privacy Policy
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact -->
            <div class="col-lg-3 col-md-4">
                <h6 class="text-white fw-bold mb-4">Get in touch</h6>
                <div class="d-flex align-items-center mb-3">
                    <i class="bi bi-envelope-fill text-white-50 me-3"></i>
                    <span class="text-white-50 small">support@smartearn.com</span>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <i class="bi bi-telephone-fill text-white-50 me-3"></i>
                    <span class="text-white-50 small">+234 (800) 123-4567</span>
                </div>
                <div class="d-flex align-items-start">
                    <i class="bi bi-geo-alt-fill text-white-50 me-3"></i>
                    <span class="text-white-50 small">Lagos, Nigeria<br>Accra, Ghana</span>
                </div>
            </div>
        </div>

        <hr class="my-5" style="border-color: rgba(255,255,255,0.1);">

        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="small text-white-50 mb-0">
                    © {{ date('Y') }} SmartEarn. All rights reserved.        
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                <img src="https://placehold.co/200x30/043a38/ffffff?text=Flutterwave+•+Paystack" 
                     alt="Payment partners" class="img-fluid" style="opacity: 0.7;">
            </div>
        </div>
    </div>
</footer>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Alpine.js CDN (optional) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</body>
</html>