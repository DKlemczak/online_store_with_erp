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
                <p style="align-self: center"  class="m-0">{{$product->price - $product->price * ($product->discount * 0.01)}} <span style="text-decoration: line-through;color: red;">{!!$product->price!!}</span></p>
            </div>
        @else
            <div class="col-2  justify-content-center" style="display: flex;">
                <p style="align-self: center"  class="m-0">{!!$product->price!!}</p>
            </div>
        @endif
        <div class="col-2  justify-content-center" style="display: flex;">
            <p style="align-self: center"  class="m-0">{!!$product->amount!!}</p>
        </div>
        <div class="col-2">
            <a><button type="button" class="btn btn-primary">Edytuj zdjęcia</button></a>
        </div>
    @endforeach
@endsection
