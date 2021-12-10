@extends('layouts.app')

@section('content')
<!-- DK:Pętla listująca produkty, które są aktywne i są w danej grupie. W środku przekierowanie idące do szczegółów danego produktu-->


<div class="col-12 col-lg-10 offset-lg-1">
    <div class="row">
        @foreach($products as $product)
            <div class="col-12 col-lg-3 text-center">
                <div class="card">
                    @foreach($product->Product_Photos_NO as $photo)
                        @if($loop->first)
                            <div class="row text-center">
                                <div class="col-12">
                                    <img class="card-img-top" src="{!!$photo->path!!}" />
                                </div>
                            </div>
                        @endif
                    @endforeach
                    <div class="card-body">
                        <h5 class="card-title">{!!$product->name!!}</h5>
                        @if($product->discount > 0)
                            <p class="card-text">{{number_format($product->price - $product->price * ($product->discount * 0.01),2,'.',',')}} zł <span style="text-decoration: line-through;color: red;">{!!$product->price!!} zł</span></p>
                        @else
                            <p class="card-text">{!!$product->price!!} zł</p>
                        @endif
                        <a href="{{ route('products.details', [$product->Products_Group->name,$product->id]) }}" class="button">Przejdź do produktu</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection