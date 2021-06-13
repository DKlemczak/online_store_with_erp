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
    @foreach($products as $product)
    <div class="col-3">
        <div class="card" style="width: 18rem;">
        @foreach($product->Product_Photos_NO as $photo)
            @if($loop->first)                                   
                <img  class="card-img-top" src="{!!$photo->path!!}" />                     
            @endif
        @endforeach
        <div class="card-body">
        <h5 class="card-title">{!!$product->name!!}</h5>
        <p class="card-text">{{number_format($product->price - $product->price * ($product->discount * 0.01),2,'.',',')}} zł <span style="text-decoration: line-through;color: red;"> {!!$product->price!!} zł</span></p>
        <a href="{{ route('products.details', [$product->Products_Group->name,$product->id]) }}" class="btn btn-primary">Przejdź do produktu</a>
        </div>
        </div>  
    </div>
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
