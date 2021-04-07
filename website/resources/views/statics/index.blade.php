@extends('layouts.app')

@section('content')
<header>
        <div class="header-img">
        <div class="header-text"> 
            <h1> funky  <span> szklanki </span></h1>
            <p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Quod, sed voluptatem voluptatibus labore dolorem nemo tenetur ratione.
             </p>
        </div>
        <div id="about-us" class="header-bg"> </div>
    </div>
    </header>
    <main class="wrapper">
        <section class="about-us">
            <div class="underline">
            <h2> nowości </h2>
            <div class="line"></div>
            </div>
        </section>

        <section id="products" class="products">
                <div class="underline"> 
                    <h2> informacje </h2> 
                    <div class="line"></div>
                </div> 
            <div class="main-product first-product"> 
                <div class="product-text"> 
                    <h4> <strong> tekst </strong>
                        
                    </h4>
                    
                </div>
                <div class="hero-bg"> </div>
                </div>

                <div class="main-product second-product"> 
                    <div class="product-text"> 
                   
                   <h4> <strong> tekst </strong></h4>
                </div>
                    <div class="hero-bg"> </div>
                </div>

                <div class="main-product third-product"> 
                    <div class="product-text"> 
                    <h4> tekst  </h4>

                </div>
                    <div class="hero-bg"> </div>
                </div>

                <div class="main-product fourth-product"> 
                    <div class="product-text"> 
                    <h4> tekst </h4>
                    
                </div>
                    <div class="hero-bg"> </div>
                </div>
        </section>

        <section id="contact">
        <div class="underline">
        <h2> Kontakt </h2>
        <div class="line"></div>
        </div>
        <div class="contact"> 
            <p> <i class="fas fa-phone"></i> +48 123 058 784 </p>
            <p> <i class="fas fa-at"></i> sklep@xx.pl </p>
            <h3> Adres </h3>
            <p> ul. Przykładowa 12, </p>
            <p> 00-111 Poznań </p>
        </div>  
        </section>
    </main>
@endsection
