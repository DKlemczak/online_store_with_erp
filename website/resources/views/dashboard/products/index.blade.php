@extends('layouts.dashboard')

@section('content')
<div class="container text-center">
    <div class="row">
        <div class="col-3">
            <p>Nazwa produktu</p>
        </div>
        <div class="col-3">
            <p>Kod produktu</p>
        </div>
        <div class="col-2">
            <p>Cena</p>
        </div>
        <div class="col-2">
            <p>Stan</p>
        </div>
        <div class="col-2">
            <p>Zdjęcia</p>
        </div>
    </div>
    @foreach($products as $product)
    <div class="row">
        <div class="col-3  justify-content-center"  style="display: flex;">
            <p style="align-self: center" class="m-0">{!!$product->name!!}</p>
        </div>
        <div class="col-3  justify-content-center" style="display: flex;">
            <p style="align-self: center" class="m-0">{!!$product->code!!}</p>
        </div>
        @if($product->discount > 0)
        <div class="col-2 justify-content-center" style="display: flex;">
                <p style="align-self: center"  class="m-0">{{number_format($product->price - $product->price * ($product->discount * 0.01),2,'.',',')}} zł<span style="text-decoration: line-through;color: red;">{!!$product->price!!} zł</span></p>
            </div>
        @else
            <div class="col-2  justify-content-center" style="display: flex;">
                <p style="align-self: center"  class="m-0">{!!$product->price!!} zł</p>
            </div>
        @endif
        <div class="col-2  justify-content-center" style="display: flex;">
            <p style="align-self: center"  class="m-0">{!!$product->amount!!}</p>
        </div>
        <div class="col-2">
            <a href="{{route('dashboard.products.photos.index',$product->id) }}"><button type="button" class="btn btn-primary">Edytuj zdjęcia</button></a>
        </div>
</div>
@endforeach
@endsection