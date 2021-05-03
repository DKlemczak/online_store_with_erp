@extends('layouts.app')

@section('content')
<p>Kupujący: {!!$order->user_name!!} {!!$order->user_surname!!}</p>
<p>Kontakt: email:{!!$order->email!!} telefon:{!!$order->phone_number!!}</p>
<p>Adres: {!!$order->city!!}, {!!$order->street!!} {!!$order->building_number!!} {!!$order->post_code!!}</p>
<p>Zamówione produkty:</p>
<p>Nazwa - Ilość - Cena</p>
@foreach ($cart as $product)
<p>{!!$product['name']!!} - {!!$product['amount']!!} - {!!$product['price']!!}</p>
@endforeach
<p>Sposób transportu: {!!$transport->name!!} koszt: {!!$transport->price!!}</p>
<p>Sposób zapłaty: {!!$payment->name!!} koszt: {!!$payment->price!!}</p>
<p>Koszt zamówienia: {!!$order->value!!}zł</p>
<button><a href="{{ route('cart.createorder') }}">Zamawiam i płacę</a></button>
@endsection
