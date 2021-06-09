@extends('layouts.app')

@section('content')
<header>
        <div class="header-img">
        <div class="header-text">
            <h1> funky  <span> szklanki </span></h1>
            <p> <p> Szklanka może być do połowy pusta lub do połowy pełna. Jednak najważniejsze że jest to szklanka ze sklepu <strong> funky szklanki. </strong></p>
        </div>
        <div id="about-us" class="header-bg"> </div>
    </div>
    </header>
    <main class="wrapper">
        <section class="about-us">
            <div class="underline">
            <h2> aktualne promocje </h2>
            <div class="line"></div>
            </div>
            <div class="row">
                <div class="col-3">
                    @foreach($products as $product)
                        <a href="{{ route('products.details', [$product->Products_Group->name,$product->id]) }}">
                            @foreach($product->Product_Photos_NO as $photo)
                                @if($loop->first)
                                    <div class="row text-center">
                                        <div class="col-12">
                                            <img src="{!!$photo->path!!}" />
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            <div class="row text-center">
                                <div class="col-12">
                                    <p class="mb-0">{!!$product->name!!}</p>
                                </div>
                            </div>
                            <div class="row text-center">
                                <div class="col-12">
                                    <p class="mb-0">{{$product->price - $product->price * ($product->discount * 0.01)}} <span style="text-decoration: line-through;color: red;">{!!$product->price!!}</span> zł</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
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
