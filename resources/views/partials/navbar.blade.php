<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">Toko Abas</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
            <ul class="navbar-nav mb-2 mb-lg-0 align-items-center">
                @auth
                    <li class="nav-item me-2">
                        <a href="{{ route('checkout.show') }}" class="btn btn-success btn-sm">🛒 Checkout Multiple</a>
                    </li>
                    @if(Auth::user()->is_admin)
                        <li class="nav-item me-2">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-warning btn-sm">Admin</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-outline-light btn-sm">Logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item me-2">
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="btn btn-outline-light btn-sm">Register</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
