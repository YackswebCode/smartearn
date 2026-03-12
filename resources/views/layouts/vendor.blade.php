{{-- resources/views/layouts/vendor.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Vendor Dashboard') - SmartEarn</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- DataTables Bootstrap 5 CSS -->
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
    <!-- Vendor Dashboard CSS (optional, reuse affiliate.css or create vendor.css) -->
    <link rel="stylesheet" href="{{ asset('css/affiliate.css') }}">
    @stack('styles')
</head>
<body>
    @php
        $user = Auth::user();
        $displayName = $user->name ?? 'Guest User';
        $email = $user->email ?? 'guest@example.com';
        $firstName = explode(' ', $displayName)[0];
        $initial = strtoupper(substr($displayName, 0, 1));
    @endphp

    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-green text-white" id="sidebar-wrapper" style="min-width: 250px; background-color: #065754;">
            <div class="sidebar-heading text-center py-4">
                <img src="{{ asset('images/logo.png') }}" alt="SmartEarn" height="40">
            </div>
            <div class="px-3 mb-3">
                <button class="btn btn-light-green w-100" style="background-color: #4CAF50; border: none; color: white;">
                    <i class="fas fa-store me-2"></i>Vendor
                </button>
            </div>

            <!-- Vendor Sidebar Menu -->
            <div class="list-group list-group-flush">
                <!-- Dashboard -->
                <a href="{{ route('vendor.dashboard') }}" class="list-group-item list-group-item-action bg-transparent text-white {{ request()->routeIs('vendor.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt me-3"></i>Dashboard
                </a>
                <!-- Order & Sales -->
                <a href="{{ route('vendor.orders') }}" class="list-group-item list-group-item-action bg-transparent text-white {{ request()->routeIs('vendor.orders') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart me-3"></i>Order & Sales
                </a>
                <!-- My Product -->
                <a href="{{ route('vendor.products.index') }}" class="list-group-item list-group-item-action bg-transparent text-white {{ request()->routeIs('vendor.products.*') ? 'active' : '' }}">
                    <i class="fas fa-box me-3"></i>My Product
                </a>
                <!-- Top Vendor -->
                <a href="{{ route('vendor.top_vendor') }}" class="list-group-item list-group-item-action bg-transparent text-white {{ request()->routeIs('vendor.top_vendor') ? 'active' : '' }}">
                    <i class="fas fa-crown me-3"></i>Top Vendor
                </a>
                 <a href="{{ route('affiliate.edit_profile') }}" class="list-group-item list-group-item-action bg-transparent text-white">
                    <i class="fas fa-user-edit me-3"></i>Edit Profile
                </a>
                <hr class="my-2">

                <!-- Group 2 -->
                <a href="{{ route('affiliate.skill_garage') }}" class="list-group-item list-group-item-action bg-transparent text-white">
                    <i class="fas fa-laptop-code me-3"></i>Skill Garage
                </a>
                <a href="{{ route('affiliate.business_university') }}" class="list-group-item list-group-item-action bg-transparent text-white">
                    <i class="fas fa-graduation-cap me-3"></i>Business University
                </a>
                <hr class="my-2">

                <!-- Group 3 -->
                <a href="{{ route('vendor.withdrawals') }}" class="list-group-item list-group-item-action bg-transparent text-white {{ request()->routeIs('vendor.withdrawals') ? 'active' : '' }}">
                    <i class="fas fa-money-bill-wave me-3"></i>Withdraw Funds
                </a>
                <hr class="my-2">

                <!-- Logout -->
                <a href="#" class="list-group-item list-group-item-action bg-transparent text-white" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt me-3"></i>Log out
                </a>
            </div>
        </div>

        <!-- Overlay for mobile -->
        <div id="sidebar-overlay" aria-hidden="true"></div>

        <div id="page-content-wrapper" class="w-100 d-flex flex-column" style="background-color: #EEF0F8; min-height: 100vh;">
            <!-- Top Navigation (same as affiliate, but can adjust dropdown if needed) -->
            <nav class="navbar navbar-expand-lg navbar-light py-2 px-4" style="background-color: #EEF0F8;">
                <div class="container-fluid">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-outline-secondary d-lg-none me-3" id="menu-toggle" aria-controls="sidebar-wrapper" aria-expanded="false" aria-label="Toggle sidebar">
                            <i class="fas fa-bars"></i>
                        </button>
                 
                    </div>

                    <!-- Right side: profile dropdown (same as affiliate) -->
                    <div class="d-flex align-items-center ms-auto">
                        <div class="dropdown">
                            <a class="d-flex align-items-center text-decoration-none dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #48BB78; padding: 0.5rem 1rem; border-radius: 0.25rem;">
                                <div class="rounded-circle bg-green text-white d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px; background-color: #065754 !important;">
                                    {{ $initial }}
                                </div>
                                <div class="text-start">
                                    <div class="fw-bold text-white">{{ strtoupper($displayName) }}</div>
                                    <small class="text-white">Vendor</small>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('affiliate.dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2"></i>Affiliate Dashboard
                                    </a>
                                </li>
                                @if(Auth::user() && Auth::user()->vendor_status === 'Active')
                                    <li>
                                        <a class="dropdown-item" href="{{ route('vendor.dashboard') }}">
                                            <i class="fas fa-store me-2"></i>Vendor Dashboard
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content Area -->
            <div class="container-fluid p-4 flex-grow-1">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Hidden logout form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <!-- Sidebar Toggle Script (same as affiliate) -->
    <script>
        (function () {
            const wrapper = document.getElementById('wrapper');
            const toggleBtn = document.getElementById('menu-toggle');
            const overlay = document.getElementById('sidebar-overlay');
            const sidebarLinks = document.querySelectorAll('#sidebar-wrapper .list-group-item-action');

            if (!toggleBtn || !wrapper || !overlay) return;

            const isMobileWidth = () => window.innerWidth < 992;

            function setToggled(state) {
                if (state) {
                    wrapper.classList.add('toggled');
                    toggleBtn.setAttribute('aria-expanded', 'true');
                    overlay.classList.add('show');
                    overlay.setAttribute('aria-hidden', 'false');
                } else {
                    wrapper.classList.remove('toggled');
                    toggleBtn.setAttribute('aria-expanded', 'false');
                    overlay.classList.remove('show');
                    overlay.setAttribute('aria-hidden', 'true');
                }
            }

            toggleBtn.addEventListener('click', function (e) {
                e.preventDefault();
                if (isMobileWidth()) {
                    setToggled(!wrapper.classList.contains('toggled'));
                }
            });

            overlay.addEventListener('click', function () {
                setToggled(false);
            });

            sidebarLinks.forEach(link => {
                link.addEventListener('click', function () {
                    if (isMobileWidth()) setToggled(false);
                });
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && wrapper.classList.contains('toggled')) {
                    setToggled(false);
                }
            });

            window.addEventListener('resize', function () {
                if (!isMobileWidth() && wrapper.classList.contains('toggled')) {
                    setToggled(false);
                }
            });
        })();
    </script>

    @stack('scripts')
</body>
</html>