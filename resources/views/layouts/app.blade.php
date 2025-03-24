<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>E-Commerce Laravel</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    
    <!-- Bootstrap & Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold text-white" href="{{ url('/home') }}">
                    Hidden Beauty
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('products.index') }}">
                                <i class="bi bi-shop"></i> Produk
                            </a>
                        </li>
                        @auth
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('cart.index') }}">
                                    <i class="bi bi-cart"></i> Keranjang 
                                </a>
                            </li>
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('login') }}">
                                        <i class="bi bi-box-arrow-in-right"></i> Login
                                    </a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('register') }}">
                                        <i class="bi bi-person-plus"></i> Register
                                    </a>
                                </li>
                            @endif
                        @else
                            @can('create', App\Models\Product::class)
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('products.index') }}">
                                        <i class="bi bi-gear"></i> Kelola Produk
                                    </a>
                                </li>
                            @endcan

                            <!-- Dropdown Profil & Logout -->
                            <li class="nav-item dropdown">
                                <a id="userMenu" class="nav-link dropdown-toggle text-white" href="#" role="button">
                                    <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" id="logoutMenu" style="display: none;">
                                    <li>
                                        <a class="dropdown-item text-danger" href="#" id="logoutButton">
                                            <i class="bi bi-box-arrow-left"></i> Logout
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <!-- @if (session('success'))
                            <div class="alert alert-success text-center" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif -->

                        @yield('content')

                        <!-- Footer -->
                        <div class="row justify-content-center text-center mt-4">
                            <div class="col-md-12">
                                <p>Back to Page: <a href="{{url('/')}}"><strong>Halaman Utama</strong></a></p>
                                <p>&copy; 2025 <a href="#"><strong>Web Developer</strong></a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let userMenu = document.getElementById("userMenu");
            let logoutMenu = document.getElementById("logoutMenu");
            let logoutButton = document.getElementById("logoutButton");

            // Toggle dropdown saat userMenu diklik
            userMenu.addEventListener("click", function (event) {
                event.preventDefault();
                logoutMenu.style.display = (logoutMenu.style.display === "block") ? "none" : "block";
            });

            // Konfirmasi sebelum logout dan arahkan ke login
            logoutButton.addEventListener("click", function (event) {
                event.preventDefault();
                if (confirm("Apakah Anda yakin ingin keluar dari sistem?")) {
                    document.getElementById('logout-form').submit();
                    setTimeout(function () {
                        window.location.href = "{{ route('login') }}"; // Redirect ke halaman login
                    }, 1000); // Tunggu sedikit agar form terkirim dulu
                }
            });

            // Menutup dropdown jika klik di luar
            document.addEventListener("click", function (event) {
                if (!userMenu.contains(event.target) && !logoutMenu.contains(event.target)) {
                    logoutMenu.style.display = "none";
                }
            });
        });
    </script>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

</body>
</html>
