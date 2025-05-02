<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">AmazingApps</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar"
            aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar"
            aria-labelledby="offcanvasDarkNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">AmazingApps</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body d-flex flex-column justify-content-between h-100">
                <div>
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link {{ $active === 'home' ? 'active' : '' }}" aria-current="page"
                                href="{{ route('home') }}">Home</a>
                        </li>
                        @can('admin-only')
                            <li class="nav-item">
                                <a class="nav-link {{ $active === 'task' ? 'active' : '' }}"
                                    href="{{ route('tasks.index') }}">TaskApp</a>
                            </li>
                        @endcan
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Dropdown
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li>
                                    @can('admin-only')
                                        <a class="dropdown-item {{ $active === 'motor' ? 'active' : '' }}"
                                            href="{{ route('motor.index') }}">MotorApps</a>
                                    @endcan
                                </li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </li>
                    </ul>

                    <form class="d-flex mt-3" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-success" type="submit">Search</button>
                    </form>
                </div>

                <div class="d-grid gap-2">
                    @auth
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger w-100">Logout</button>
                        </form>
                    @endauth

                    @guest
                        <a href="{{ route('login') }}" class="btn btn-primary w-100">Login</a>
                    @endguest
                </div>

            </div>
        </div>
    </div>
</nav>
