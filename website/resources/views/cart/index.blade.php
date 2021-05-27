@extends('layouts.app')

@section('content')
<p>Nazwa - Ilość - Cena</p>
@foreach ($cart as $product)
<p>{!!$product['name']!!} - {!!$product['amount']!!} - {!!$product['price']!!} <a href="{{ route('cart.remove', [key($cart)]) }}"><button class="btn btn-danger">X</button></a></p>
@endforeach
<p> Wartość zamówienia {!!$value!!}zł</p>
<form method="POST" enctype="multipart/form-data" action="{{ route('cart.summary') }}" accept-charset="UTF-8">
    @csrf
    <div>
        <div class="row mx-0">
            <div class="col-6">
            <div class="underline">
                    <h2> Sposób płatności </h2>
                    <div class="line"></div>
            </div>
                <select id="payment" name="payment">
                    @foreach($payments as $payment)
                        <option value="{{$payment->id}}">{{$payment->name}} - {{$payment->price}}zł</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6">
            <div class="underline">
                    <h2> Sposób transportu </h2>
                    <div class="line"></div>
            </div>
                <select id="transport" name="transport">
                    @foreach($transports as $transport)
                        <option value="{{$transport->id}}">{{$transport->name}} - {{$transport->price}}zł</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mx-0 mt-4">
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <h2>Dane do wysyłki</h2>
                        <p class="text-center">Dane w profilu użytkownika będą danymi do faktury, jeśli nie zostały podane to do faktury użyte zostaną dane wysyłkowe</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="name" class="col-form-label">Imię:</label>
                        <input id="name" type="text" class="form-control" name="name" required>
                        @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="col-6">
                        <label for="surname" class="col-form-label">Nazwisko:</label>
                        <input id="surname" type="text" class="form-control" name="surname" required>
                        @if ($errors->has('surname'))
                        <span class="help-block">
                            <strong>{{ $errors->first('surname') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="email" class="col-form-label">E-mail:</label>
                        <input id="email" type="email" class="form-control" name="email" required>
                        @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="col-6">
                        <label for="phone_number" class="col-form-label">Numer telefonu:</label>
                        <input id="phone_number" type="text" class="form-control" name="phone_number" required>
                        @if ($errors->has('phone_number'))
                        <span class="help-block">
                            <strong>{{ $errors->first('phone_number') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="city" class="col-form-label">Miasto:</label>
                        <input id="city" type="text" class="form-control" name="city" required>
                        @if ($errors->has('city'))
                        <span class="help-block">
                            <strong>{{ $errors->first('city') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="col-6">
                        <label for="post_code" class="col-form-label">Kod pocztowy:</label>
                        <input id="post_code" type="text" class="form-control" name="post_code" required>
                        @if ($errors->has('post_code'))
                        <span class="help-block">
                            <strong>{{ $errors->first('post_code') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="street" class="col-form-label">Ulica:</label>
                        <input id="street" type="text" class="form-control" name="street" required>
                        @if ($errors->has('street'))
                        <span class="help-block">
                            <strong>{{ $errors->first('street') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="col-6">
                        <label for="building_number" class="col-form-label">Numer budynku:</label>
                        <input id="building_number" type="text" class="form-control" name="building_number" required>
                        @if ($errors->has('building_number'))
                        <span class="help-block">
                            <strong>{{ $errors->first('building_number') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <br>
        <button type="submit" class="button"> Podsumowanie </button>
    </div>
</form>
@endsection
