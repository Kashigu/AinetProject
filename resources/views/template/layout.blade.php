<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="shortcut icon" href="/img/logo1.ico">
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>Imagine Shirt</title>
    @vite('resources/sass/app.scss')
    @vite('resources/css/app.css')
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand " href="{{ url('/') }}">
        <img src="/img/plain_white.png" alt="Logo" class="bg-dark" width="70" height="50">
        Imagine Shirt
    </a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-3 me-lg-0" id="sidebarToggle" href="#"><i
            class="fas fa-bars"></i></button>
    @guest
        <ul class="navbar-nav ms-auto me-1 me-lg-3">
            @if (Route::has('login'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">
                        {{ __('Login') }}
                    </a>
                </li>
            @endif
            @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">
                        {{ __('Register') }}
                    </a>
                </li>
            @endif
            @can('access-cart')
                <button class="btn btn-link text-white text-decoration-none"><a href="{{route('cart.show')}}"
                                                                                class="text-white text-decoration-none"><i
                            class="fa-solid fa-cart-shopping"></i></a></button>
            @endcan
        </ul>
    @else
        <div class="ms-auto me-0 me-md-2 my-2 my-md-0 navbar-text text-white text-decoration-none ">
            {{ Auth::user()->name }}
        </div>
        <!-- Navbar-->
        <ul class="navbar-nav me-1 me-lg-3">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                   aria-expanded="false">
                    @if (Auth::user()->photo_url != null)
                        <img src="{{ asset('storage/photos/' . Auth::user()->photo_url) }}" alt="Avatar"
                             class="bg-dark rounded-circle" width="45" height="45">
                    @else
                        <img src="/img/avatar_unknown.png" alt="Avatar" class="bg-dark rounded-circle" width="45"
                             height="45">
                    @endif
                </a>

                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    @if ((Auth::user()->user_type ?? '') != 'E')
                        <li><a class="dropdown-item" href="{{ route('user.show', ['user' => Auth::user()])
                                        }}">Perfil</a></li>
                    @endif
                    <a class="dropdown-item" href="{{route('password.change.show')}}">Alterar Senha</a>
                    <li>
                        <hr class="dropdown-divider"/>
                    </li>
                    <li>
                        <a class="dropdown-item" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            Sair
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
            @can('access-cart')
                <button class="btn btn-link text-white text-decoration-none"><a href="{{route('cart.show')}}"
                                                                                class="text-white text-decoration-none"><i
                            class="fa-solid fa-cart-shopping"></i></a></button>
            @endcan
        </ul>
    @endguest
</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <a class="nav-link" href="{{ url('/') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                        Página Principal
                    </a>
                    @guest
                        <a class="nav-link" href="{{ route('tshirtImage.index') }}">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-store">&#xf1c5;</i></div>
                            Catálogo
                        </a>
                    @endguest

                        @customer
                        <a class="nav-link" href="{{ route('tshirtImage.index') }}">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-store">&#xf1c5;</i></div>
                            Catálogo
                        </a>
                        @endcustomer

                    @authUser
                        <a class="nav-link" href="{{ route('order.index') }}">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-box"></i></div>
                            Encomendas
                        </a>
                    @endauthUser

                    @can('administrar')
                        <div class="sb-sidenav-menu-heading">Espaço de Administrador</div>
                        <a class="nav-link" href="{{ route('user.index')}}">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-text"></i></div>
                            Lista Users
                        </a>

                        <a class="nav-link" href="{{ route('tshirt.indexAdmin')}}">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-text"></i></div>
                            Lista de Imagens
                        </a>

                        <a class="nav-link" href="{{ route('category.index')}}">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-text"></i></div>
                            Lista de Categorias
                        </a>

                        <a class="nav-link" href="{{ route('color.index')}}">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-text"></i></div>
                            Lista de Cores
                        </a>
                        <a class="nav-link" href="{{ route('price.index')}}">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-text"></i></div>
                            Preço
                        </a>
                        <a class="nav-link" href="{{ route('stats.index')}}">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-chart-line"></i></div>
                            Estatística
                        </a>
                    @endcan
                </div>
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                @if (session('alert-msg'))
                    @include('shared.messages')
                @endif
                @if ($errors->any())
                    @include('shared.alertValidation')
                @endif
                <h1 class="mt-4 center">
                    @if(Request::route()->getName() == 'user.show')
                        @yield('titulo', 'Perfil de') {{$name}}
                    @else
                        @yield('titulo', 'Imagine Shirt')
                    @endif
                </h1>
                @yield('subtitulo')
                <div class="mt-4">
                    @yield('main')
                </div>
            </div>
        </main>
        <footer class="py-2 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy;Politécnico de Leiria 2023</div>
                </div>
            </div>
        </footer>
    </div>
</div>
@vite('resources/js/app.js')
</body>

</html>
