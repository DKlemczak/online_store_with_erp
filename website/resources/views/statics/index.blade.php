@extends('layouts.app')

@section('content')
<header>
        <div class="header-img">
        <div class="header-text">
            <h1> funky  <span> szklanki </span></h1>
            <p> <p> Szklanka może być do połowy pusta lub do połowy pełna. Jednak najlepszy wybór to szklanka ze sklepu <strong> funky szklanki. </strong></p>
        </div>
        <div id="about-us" class="header-bg"> </div>
    </div>
    </header>
    <main class="wrapper">
        <section class="about-us">
            <div class="underline">
            <h2> aktualne promocje </h2>
            <div class="line"></div>
            <div>
                @foreach($products as $product)
                    <a href="{{ route('products.details', [$product->Products_Group->name,$product->id]) }}"><span>{!!$product->name!!}</span></a>
                @endforeach
            </div>
        </section>

        <section id="products" class="products">
                <div class="underline">
                    <h2 > Co nas wyróżnia </h2>
                    <div class="line"></div>
                </div>
                <div class="main-product first-product">
                <div class="product-text">
                    <h4>  W naszej ofercie znajdują się: <strong> szklanki, kubki </strong> oraz <strong> kieliszki </strong> </h4>
                </div>
                <div class="hero-bg"> </div>
                </div>

                <div class="main-product second-product">
                    <div class="product-text">

                   <h4> Polska firma, Polskie produkty </h4>
                </div>
                    <div class="hero-bg"> </div>
                </div>

                <div class="main-product third-product">
                    <div class="product-text">
                    <h4> Dbamy o każdy szczegół  </h4>

                </div>
                    <div class="hero-bg"> </div>
                </div>

                <div class="main-product fourth-product">
                    <div class="product-text">
                    <h4> Wysyłka zamówienia w 48h </h4>
                </div>
                    <div class="hero-bg"> </div>
                </div>
        </section>
    </main>
@endsection
