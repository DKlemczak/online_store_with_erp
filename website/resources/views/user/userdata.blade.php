@extends('layouts.user')

@section('content')
@if(session()->has('Wiadomość'))
    <div class="bg-danger">
        {{ session()->get('Wiadomość') }}
    </div>
@endif
<form method="POST" action="{{ route('user.savedata') }}">
    @csrf
    <p>Pola wymagane</p>
    <hr>
    <div class="form-group row">
        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Imię') }}</label>

        <div class="col-md-6">
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{!!Auth::User()->name!!}" required autocomplete="name" autofocus>

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="surname" class="col-md-4 col-form-label text-md-right">{{ __('Nazwisko') }}</label>

        <div class="col-md-6">
            <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{!!Auth::User()->surname!!}" required autocomplete="surname" autofocus>

            @error('surname')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="old_password" class="col-md-4 col-form-label text-md-right">{{ __('Stare hasło') }}</label>

        <div class="col-md-6">
            <input id="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" required autocomplete="old_password">

            @error('old_password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Hasło') }}</label>

        <div class="col-md-6">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Powtórz hasło') }}</label>

        <div class="col-md-6">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
        </div>
    </div>

    <p>Pola opcjonalne</p>
    <hr>

    <div class="form-group row">
        <label for="city" class="col-md-4 col-form-label text-md-right">{{ __('Miejscowość') }}</label>

        <div class="col-md-6">
            <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{!!Auth::User()->city!!}" autocomplete="city" autofocus>

            @error('city')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="post_code" class="col-md-4 col-form-label text-md-right">{{ __('Kod pocztowy') }}</label>

        <div class="col-md-6">
            <input id="post_code" type="text" class="form-control @error('post_code') is-invalid @enderror" name="post_code" value="{!!Auth::User()->postcode!!}" autocomplete="post_code" autofocus>

            @error('post_code')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="street" class="col-md-4 col-form-label text-md-right">{{ __('Ulica') }}</label>

        <div class="col-md-6">
            <input id="street" type="text" class="form-control @error('street') is-invalid @enderror" name="street" value="{!!Auth::User()->street!!}" autocomplete="street" autofocus>

            @error('street')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="building_number" class="col-md-4 col-form-label text-md-right">{{ __('Numer budynku') }}</label>

        <div class="col-md-6">
            <input id="building_number" type="text" class="form-control @error('building_number') is-invalid @enderror" name="building_number" value="{!!Auth::User()->building_number!!}" autocomplete="building_number" autofocus>

            @error('building_number')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="NIP" class="col-md-4 col-form-label text-md-right">{{ __('NIP') }}</label>

        <div class="col-md-6">
            <input id="NIP" type="text" class="form-control @error('NIP') is-invalid @enderror" name="NIP" value="{!!Auth::User()->NIP!!}" autocomplete="NIP" autofocus>

            @error('NIP')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
                {{ __('Zapisz') }}
            </button>
        </div>
    </div>
    </form>
@endsection