@extends('layouts.app')

@section('content')
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
<div class="row">
    <div class="col-12 col-lg-6 d-flex justify-content-center img-box">
        @foreach($product->Product_Photos_NO as $photo)
            <img src="{!!$photo->path!!}" alt="{!!$photo->no!!}" class="img-fluid"/>
        @endforeach
    </div>
    <div class="col-12 col-lg-6">
        
        <h2>{!!$product->name!!}</h2>
        <h4> Opis: </h4>
        <p>{!!$product->description!!}</p>
        <h4> Cena: </h4>
        @if($product->discount > 0)
        <p>{{number_format($product->price - $product->price * ($product->discount * 0.01),2,'.',',')}} <span style="text-decoration: line-through;color: red;">{!!$product->price!!}</span></p>
        @else
        <p>{!!$product->price!!}</p>
        
        @endif
        <p>Tagi:
        @foreach($product->Products_tags as $tag)
        {!!$tag->name!!},
        @endforeach
        </p>
        @if($product->amount>0)
        <form method="POST" enctype="multipart/form-data" action="{{ route('cart.addtocart') }}" accept-charset="UTF-8">
            @csrf
            <div class="form-group">
                <p>Ilość: <br> <input class="form-control-products" type="number" name="amount" value="1" min="1" max="{!!$product->amount!!}"></p>
        
                <input class="form-control-products" type="hidden" name="product_id" value="{!!$product->id!!}">
                <button type="submit" class="button">Dodaj do koszyka</button>
            </div>
        </form>
        @else
            <p>Brak produktu na stanie</p>
        @endif
    </div>
</div>



@endsection