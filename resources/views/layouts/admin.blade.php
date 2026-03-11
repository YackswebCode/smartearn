<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - SmartEarn Admin</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- DataTables Bootstrap 5 CSS -->
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
    <!-- Admin custom CSS (optional, reuse affiliate.css for now) -->
    <link rel="stylesheet" href="{{ asset('css/affiliate.css') }}">
    @stack('styles')
</head>
<body>
    @php
        $admin = Auth::guard('admin')->user();
        $displayName = $admin->name ?? 'Admin';
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
                    <i class="fas fa-user-shield me-2"></i>Admin
                </button>
            </div>

            <!-- Sidebar Menu -->
            <div class="list-group list-group-flush">
                <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action bg-transparent text-white {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt me-3"></i>Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action bg-transparent text-white {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users me-3"></i>Users
                </a>
                <a href="{{ route('admin.vendors.index') }}" class="list-group-item list-group-item-action bg-transparent text-white {{ request()->routeIs('admin.vendors.*') ? 'active' : '' }}">
                    <i class="fas fa-store me-3"></i>Vendors
                </a>
                <a href="{{ route('admin.products.index') }}" class="list-group-item list-group-item-action bg-transparent text-white {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="fas fa-box me-3"></i>Products
                </a>
                <a href="{{ route('admin.orders.index') }}" class="list-group-item list-group-item-action bg-transparent text-white {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart me-3"></i>Orders
                </a>
                <a href="{{ route('admin.withdrawals.index') }}" class="list-group-item list-group-item-action bg-transparent text-white {{ request()->routeIs('admin.withdrawals.*') ? 'active' : '' }}">
                    <i class="fas fa-money-bill-wave me-3"></i>Withdrawals
                </a>
                <hr class="my-2">

                <!-- Skill Garage Dropdown -->
                <div class="list-group-item bg-transparent text-white p-0 border-0">
                    <a href="#skillGarageMenu" class="list-group-item list-group-item-action bg-transparent text-white d-flex align-items-center" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('admin.faculties.*') || request()->routeIs('admin.tracks.*') || request()->routeIs('admin.lectures.*') || request()->routeIs('admin.enrollments.*') ? 'true' : 'false' }}">
                        <i class="fas fa-layer-group me-3"></i>Skill Garage
                        <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs('admin.faculties.*') || request()->routeIs('admin.tracks.*') || request()->routeIs('admin.lectures.*') || request()->routeIs('admin.enrollments.*') ? 'show' : '' }}" id="skillGarageMenu">
                        <div class="list-group list-group-flush ps-4">
                            <a href="{{ route('admin.faculties.index') }}" class="list-group-item list-group-item-action bg-transparent text-white small {{ request()->routeIs('admin.faculties.*') ? 'active' : '' }}">
                                <i class="fas fa-circle fa-2xs me-2" style="font-size: 0.5rem; vertical-align: middle;"></i>Faculties
                            </a>
                            <a href="{{ route('admin.tracks.index') }}" class="list-group-item list-group-item-action bg-transparent text-white small {{ request()->routeIs('admin.tracks.*') ? 'active' : '' }}">
                                <i class="fas fa-circle fa-2xs me-2" style="font-size: 0.5rem; vertical-align: middle;"></i>Tracks
                            </a>
                            <a href="{{ route('admin.lectures.index') }}" class="list-group-item list-group-item-action bg-transparent text-white small {{ request()->routeIs('admin.lectures.*') ? 'active' : '' }}">
                                <i class="fas fa-circle fa-2xs me-2" style="font-size: 0.5rem; vertical-align: middle;"></i>Lectures
                            </a>
                            <a href="{{ route('admin.enrollments.index') }}" class="list-group-item list-group-item-action bg-transparent text-white small {{ request()->routeIs('admin.enrollments.*') ? 'active' : '' }}">
                                <i class="fas fa-circle fa-2xs me-2" style="font-size: 0.5rem; vertical-align: middle;"></i>Enrollments
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Business University Dropdown -->
                <div class="list-group-item bg-transparent text-white p-0 border-0">
                    <a href="#businessUniversityMenu" class="list-group-item list-group-item-action bg-transparent text-white d-flex align-items-center" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('admin.business-faculties.*') || request()->routeIs('admin.business-courses.*') || request()->routeIs('admin.business-lectures.*') || request()->routeIs('admin.business-enrollments.*') ? 'true' : 'false' }}">
                        <i class="fas fa-university me-3"></i>Business University
                        <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs('admin.business-faculties.*') || request()->routeIs('admin.business-courses.*') || request()->routeIs('admin.business-lectures.*') || request()->routeIs('admin.business-enrollments.*') ? 'show' : '' }}" id="businessUniversityMenu">
                        <div class="list-group list-group-flush ps-4">
                            <a href="{{ route('admin.business-faculties.index') }}" class="list-group-item list-group-item-action bg-transparent text-white small {{ request()->routeIs('admin.business-faculties.*') ? 'active' : '' }}">
                                <i class="fas fa-circle fa-2xs me-2" style="font-size: 0.5rem; vertical-align: middle;"></i>Faculties
                            </a>
                            <a href="{{ route('admin.business-courses.index') }}" class="list-group-item list-group-item-action bg-transparent text-white small {{ request()->routeIs('admin.business-courses.*') ? 'active' : '' }}">
                                <i class="fas fa-circle fa-2xs me-2" style="font-size: 0.5rem; vertical-align: middle;"></i>Courses
                            </a>
                            <a href="{{ route('admin.business-lectures.index') }}" class="list-group-item list-group-item-action bg-transparent text-white small {{ request()->routeIs('admin.business-lectures.*') ? 'active' : '' }}">
                                <i class="fas fa-circle fa-2xs me-2" style="font-size: 0.5rem; vertical-align: middle;"></i>Lectures
                            </a>
                            <a href="{{ route('admin.business-enrollments.index') }}" class="list-group-item list-group-item-action bg-transparent text-white small {{ request()->routeIs('admin.business-enrollments.*') ? 'active' : '' }}">
                                <i class="fas fa-circle fa-2xs me-2" style="font-size: 0.5rem; vertical-align: middle;"></i>Enrollments
                            </a>
                        </div>
                    </div>
                </div>

                <hr class="my-2">

                <a href="{{ route('admin.transactions.index') }}" class="list-group-item list-group-item-action bg-transparent text-white {{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}">
                    <i class="fas fa-exchange-alt me-3"></i>Transactions
                </a>
                <a href="{{ route('admin.commissions.index') }}" class="list-group-item list-group-item-action bg-transparent text-white {{ request()->routeIs('admin.commissions.*') ? 'active' : '' }}">
                    <i class="fas fa-percent me-3"></i>Commissions
                </a>
                <a href="{{ route('admin.admins.index') }}" class="list-group-item list-group-item-action bg-transparent text-white {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
                    <i class="fas fa-user-shield me-3"></i>Manage Admins
                </a>
                <hr class="my-2">
                <a href="#" class="list-group-item list-group-item-action bg-transparent text-white" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt me-3"></i>Log out
                </a>
            </div>
        </div>

        <!-- Overlay for mobile -->
        <div id="sidebar-overlay" aria-hidden="true"></div>

        <div id="page-content-wrapper" class="w-100 d-flex flex-column" style="background-color: #EEF0F8; min-height: 100vh;">
            <!-- Top Navigation -->
            <nav class="navbar navbar-expand-lg navbar-light py-2 px-4" style="background-color: #EEF0F8;">
                <div class="container-fluid">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-outline-secondary d-lg-none me-3" id="menu-toggle" aria-controls="sidebar-wrapper" aria-expanded="false" aria-label="Toggle sidebar">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div>
                            <h3 class="fw-bold d-block mb-0">Welcome, {{ $firstName }}!</h3>
                            <small class="text-muted d-block">
                                Today <span style="color: #065754;">{{ now()->format('M d') }}</span>
                            </small>
                        </div>
                    </div>

                    <!-- Right side: profile dropdown -->
                    <div class="d-flex align-items-center ms-auto">
                        <div class="dropdown">
                            <a class="d-flex align-items-center text-decoration-none dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #48BB78; padding: 0.5rem 1rem; border-radius: 0.25rem;">
                                <div class="rounded-circle bg-green text-white d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px; background-color: #065754 !important;">
                                    {{ $initial }}
                                </div>
                                <div class="text-start">
                                    <div class="fw-bold text-white">{{ strtoupper($displayName) }}</div>
                                    <small class="text-white">Admin</small>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.profile.edit') }}">
                                        <i class="fas fa-user me-2"></i>Profile
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </a>
                                </li>
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

    <!-- Logout form (hidden) -->
    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <!-- Sidebar Toggle Script -->
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