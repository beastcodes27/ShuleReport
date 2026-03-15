<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <div id="wrapper">
            @auth
                @include('layouts.partials.sidebar')
            @endauth

            <div id="content">
                <nav class="navbar navbar-expand-md navbar-light bg-white sticky-top">
                    <div class="container-fluid px-4">
                        @auth
                            <button type="button" id="sidebarCollapse" class="btn btn-link link-dark me-3 p-0">
                                <i class="bi bi-list fs-2"></i>
                            </button>
                        @endauth

                        <a class="navbar-brand d-md-none" href="{{ url('/') }}">
                            {{ config('app.name', 'Laravel') }}
                        </a>

                        <div class="ms-auto">
                            <!-- Right Side Of Navbar -->
                            <ul class="navbar-nav ms-auto flex-row align-items-center">
                                <!-- Authentication Links -->
                                @guest
                                    @if (Route::has('login'))
                                        <li class="nav-item me-3">
                                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                        </li>
                                    @endif

                                    @if (Route::has('register'))
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                        </li>
                                    @endif
                                @else
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            <span class="d-none d-md-inline me-2">{{ Auth::user()->name }}</span>
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                                {{ substr(Auth::user()->name, 0, 1) }}
                                            </div>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item py-2" href="{{ route('logout') }}"
                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="bi bi-box-arrow-right me-2"></i> {{ __('Logout') }}
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </div>
                                    </li>
                                @endguest
                            </ul>
                        </div>
                    </div>
                </nav>

                <main class="py-4 px-3 px-md-5">
                    @if(session('welcome'))
                        <div class="alert alert-login-welcome alert-dismissible fade show border-0 shadow-sm mb-4 p-4" role="alert">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                                    <i class="bi bi-stars fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="alert-heading mb-1 fw-bold text-secondary">Hello!</h5>
                                    <p class="mb-0 text-dark">{{ session('welcome') }}</p>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const collapseBtn = document.getElementById('sidebarCollapse');
            
            if (collapseBtn && sidebar) {
                collapseBtn.addEventListener('click', function () {
                    sidebar.classList.toggle('collapsed');
                });
            }

            // For mobile responsiveness
            if (window.innerWidth <= 768 && sidebar) {
                sidebar.classList.add('collapsed');
            }
        });
    </script>
</body>
</html>
