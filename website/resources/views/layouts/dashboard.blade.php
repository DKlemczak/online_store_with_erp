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
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard.products.index') }}">Produkty</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
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
                                    @if(Auth::user()->is_admin)
                                    <a class="dropdown-item" href="{{ route('dashboard') }}">
                                        Panel administratora
                                    </a>
                                    @endif
                                    <a class="dropdown-item" href="{{route('user')}}">
                                        Panel użytkownika
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Wyloguj') }}
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

    <div class="container-fluid pb-0 mb-0 justify-content-center text-light">
     <footer>
         <div class="row my-5 justify-content-center">
             <div class="col-11">
                 <div class="row mb-4">
                    <div class="col-12 my-auto mx-auto text-center">
                        <img src="\img\logo.png" width="150px">
                     </div>
                 </div>

                 <div class="row">

                     <div class="col-md-6 col-12">
                         <h6 class="mb-3 mb-lg-4 bold-text text-center"><b>MENU</b></h6>
                         <hr>
                         <ul class="list-unstyled text-center">
                             <li> <a href="#" class="black-link"> Strona główna </a> </li>
                             <li> <a href="#about-us" class="black-link"> Aktualne promocje </a> </li>
                             <li> <a href="#products" class="black-link"> Co nas wyróżnia? </a> </li>
                         </ul>
                     </div>

                     <div class="col-md-6 col-12">
                         <h6 class="mb-3 mb-lg-4 text-muted bold-text mt-sm-0 mt-5 text-center"><b>Siedziba firmy:</b></h6>
                         <hr>
                         <p class="mb-1 text-center">ul. Przykładowa 12, </p>
                         <p class="mb-1 text-center"> 00-111 Poznań</p>
                     </div>

                 </div>

                 <div class="row mb-5">
                     <div class="col-sm-4 col-auto order-1 align-self-end ">
                         <h6 class="mt-55 mt-2 text-muted bold-text"><b>Paulina Wróblewska</b></h6><small> <span><i class="fa fa-envelope" aria-hidden="true"></i></span> pw@funky-szklanki.com</small>
                     </div>
                     <div class="col-sm-4 col-auto order-2 align-self-end mt-3 ">
                         <h6 class="text-muted bold-text"><b>Paweł Ganczarski</b></h6><small><span><i class="fa fa-envelope" aria-hidden="true"></i></span> pg@funky-szklanki.com</small>
                     </div>
                     <div class="col-sm-4 col-auto order-1 align-self-end ">
                         <h6 class="mt-55 mt-2 text-muted bold-text"><b>Daniel Klemczak </b></h6><small> <span><i class="fa fa-envelope" aria-hidden="true"></i></span> dk@funky-szklanki.com</small>
                     </div>
                 </div>

                 <div class="row">
                    <small class="rights col-12 col-md-6"><span>&#174;</span> <strong> funky-szklanki </strong> All Rights Reserved.</small>
                    <p class="social text-muted mb-0 pb-0 bold-text col-12 col-md-6 d-flex justify-content-end">
                        <!-- <span class="mx-2"><i class="fa fa-facebook" aria-hidden="true"></i></span>  -->
                        <span class="mx-2"> <a href="https://www.facebook.com/" class="black-link" target="_blank"> <i class="fab fa-facebook-square"> </i> </a> </span>
                        <span class="mx-2"> <a href="https://www.linkedin.com/" class="black-link" target="_blank"> <i class="fa fa-linkedin-square" aria-hidden="true"> </i> </a> </span>
                        <span class="mx-2"> <a href="https://www.twitter.com/" class="black-link" target="_blank"> <i class="fa fa-twitter" aria-hidden="true"> </i> </a> </span>
                        <span class="mx-2"> <a href="https://www.instagram.com/" class="black-link" target="_blank"> <i class="fa fa-instagram" aria-hidden="true"> </i> </a> </span>
                    </p>
                 </div>
             </div>
         </div>
     </footer>
 </div> 
</body>
</html>