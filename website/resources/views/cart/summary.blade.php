@extends('layouts.app')

@section('content')
<p> <strong> Kupujący: </strong> {!!$order->user_name!!} {!!$order->user_surname!!}</p>
<p> <strong> Kontakt: e-mail: </strong> {!!$order->email!!}, <strong> telefon: </strong> {!!$order->phone_number!!}</p>
<p><strong> Adres: </strong> {!!$order->city!!}, {!!$order->street!!} {!!$order->building_number!!} {!!$order->post_code!!}</p>
<p> <strong>Zamówione produkty: </strong> </p>
<p>Nazwa - Ilość - Cena</p>
@foreach ($cart as $product)
<p>{!!$product['name']!!} - {!!$product['amount']!!} - {!!$product['price']!!}</p>
@endforeach
<p> <strong> Sposób transportu: </strong> {!!$transport->name!!} koszt: {!!$transport->price!!} zł</p>
<p> <strong> Sposób zapłaty: </strong>  {!!$payment->name!!} koszt: {!!$payment->price!!} zł</p>
<p> <strong> Koszt zamówienia: </strong> {!!$order->value!!} zł</p>
<button class="button"><a href="{{ route('cart.createorder') }}">Zamawiam i płacę</a></button>
@endsection