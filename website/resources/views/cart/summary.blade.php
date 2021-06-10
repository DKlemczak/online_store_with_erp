@extends('layouts.app')

@section('content')
<p> <strong> Kupujący: </strong> {!!$order->user_name!!} {!!$order->user_surname!!}</p>
<p> <strong> Kontakt: e-mail: </strong> {!!$order->email!!}, <strong> telefon: </strong> {!!$order->phone_number!!}</p>
<p><strong> Adres: </strong> {!!$order->city!!}, {!!$order->street!!} {!!$order->building_number!!} {!!$order->post_code!!}</p>
<p> <strong>Zamówione produkty: </strong> </p>
<div class="row d-none d-lg-block"> 
<div class="col-12 col-lg-6">Nazwa:</div>
<div class="col-12 col-lg-2">Ilość:</div>
<div class="col-12 col-lg-2">Cena:</div>
<div class="col-12 col-lg-2">Usuń</div></div>
@foreach ($cart as $product)
<div class="row">
    <div class="col-12 col-lg-6"> {!!$product['name']!!}
    </div>
    <div class="col-12 col-lg-2">  {!!$product['amount']!!} </div>
    <div class="col-12 col-lg-2"> {!!$product['price']!!}  </div>
    <div class="col-12 col-lg-2"> <a href="{{ route('cart.remove', [key($cart)]) }}" class="btn btn-danger">X</a> </div>
</div>
@endforeach
<p> <strong> Sposób transportu: </strong> {!!$transport->name!!} koszt: {!!$transport->price!!} zł</p>
<p> <strong> Sposób zapłaty: </strong>  {!!$payment->name!!} koszt: {!!$payment->price!!} zł</p>
<p> <strong> Koszt zamówienia: </strong> {!!$order->value!!} zł</p>
<button class="button"><a href="{{ route('cart.createorder') }}">Zamawiam i płacę</a></button>
@endsection