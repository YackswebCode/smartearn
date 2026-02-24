<nav class="navbar navbar-expand-lg" style="background-color: var(--primary-green);">
    <div class="container">
        <!-- Brand with white highlight -->
        <a class="navbar-brand fw-bold text-white" href="{{ url('/') }}">
            <span style="background-color: white; color: var(--primary-green); padding: 6px 10px; border-radius: 8px; margin-right: 8px; font-weight: 700;">SE</span>
            <span class="text-white">SmartEarn</span>
        </a>

        <!-- Toggler for mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" style="border-color: rgba(255,255,255,0.5);">
            <span class="navbar-toggler-icon" style="background-image: url(\"data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.8%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e\");"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Left side navigation links -->
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item px-2">
                    <a class="nav-link text-white fw-semibold" href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item px-2">
                    <a class="nav-link text-white fw-semibold" href="#">About</a>
                </li>
                <li class="nav-item px-2">
                    <a class="nav-link text-white fw-semibold" href="#">FAQ</a>
                </li>
                <li class="nav-item px-2">
                    <a class="nav-link text-white fw-semibold" href="#">Contact</a>
                </li>
            </ul>

            <!-- Right side – Auth buttons -->
            <ul class="navbar-nav ms-auto align-items-center">
                @guest
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('login') }}" style="opacity: 0.9;">Log in</a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn" href="{{ route('register') }}" 
                           style="background-color: white; color: var(--primary-green); border-radius: 8px; padding: 0.5rem 1.5rem; font-weight: 600; border: none;">
                            Register
                        </a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Dashboard</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}" 
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>