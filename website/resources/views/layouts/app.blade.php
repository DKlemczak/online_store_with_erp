<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Szklanki, kubki, kieliszki... </title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://kit.fontawesome.com/5d17a4a058.js" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@200;400;600&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" media="screen and (min-width:576px)" href="{{ asset('css/small.css') }}">
    <link rel="stylesheet" media="screen and (min-width:768px)" href="{{ asset('css/medium.css') }}">
    <link rel="stylesheet" media="screen and (min-width:992px)" href="{{ asset('css/large.css') }}">
</head>
<body>
    <div id="app" style="min-height: 94.35vh;">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ ('funky szklanki') }}
                </a>

                <div class="nav-mobile">
                    <button> <i class="fas fa-bars"></i> </button>
                </div>

                    <ul class="navbar-nav">
                        <!-- DK:Pętla listująca grupy produktów, które nie są podgrupami i mają ustawioną wartość on_navbar na 1. W środku przekierowanie do listy produktów danej kategorii. Podkategorie listują się po najechaniu-->
                        @foreach($GlobalNavbarGroups as $GlobalNavbarGroup)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('products', [$GlobalNavbarGroup->id]) }}">{!!$GlobalNavbarGroup->name!!}</a>
                            </li>
                            <!-- DK:Potem dodam żeby każda nadrzędna kategoria miała listowane podkategorie. Nadkategorie będą listować wszystkie produkty swoich podkategorii. Podkategorie tylko swoje własne-->
                        @endforeach
                        <!-- Koniec pętli -->
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        @if(session('cart'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('cart')}}"><i class="fas fa-shopping-cart"></i> {{count(Session::get('cart'))}}</a>
                            </li>
                        @endif
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Logowanie') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Rejestracja') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <footer>
      <div class="footer-text"> <ul class="mb-0">
        <li>  <a href="https://www.facebook.com/" target="_blank"> <i class="fab fa-facebook-square"></i> </a> </li>
        <li> <a href="https://www.instagram.com/" target="_blank"> <i class="fab fa-instagram-square"></i> </a> </li>
    </ul>
    </div>
    </footer>
</body>
</html>
