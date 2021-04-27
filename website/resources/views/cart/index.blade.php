@extends('layouts.app')

@section('content')
<p>Nazwa - Ilość - Cena</p>
@foreach ($cart as $product)
<p>{!!$product['name']!!} - {!!$product['amount']!!} - {!!$product['price']!!} <a href="{{ route('cart.remove', [key($cart)]) }}"><button class="btn btn-danger">X</button></a></p>
@endforeach
<p>Wartość zamówienia: {!!$value!!}</p>
<form method="POST" enctype="multipart/form-data" action="{{ route('cart.createorder') }}" accept-charset="UTF-8">
    @csrf
    <label for="title" class="col-form-label">Tytuł:</label>
    <div>
        <input id="title" type="text" class="form-control" name="title" required>
        @if ($errors->has('title'))
        <span class="help-block">
            <strong>{{ $errors->first('title') }}</strong>
        </span>
        @endif
    </div>
    <button><a href="{{ route('cart.createorder')}}">Złóż zamówienie</a></button>
</form>
@endsection
