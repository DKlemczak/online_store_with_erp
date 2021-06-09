@extends('layouts.dashboard')

@section('content')
<form method="POST" action="{{ route('dashboard.products.photos.store',$product_id) }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group row">
        <label for="no" class="col-md-4 col-form-label text-md-right">{{ __('Liczba porządkowa') }}</label>
        <div class="col-md-6">
            <input id="no" type="number" class="form-control @error('no') is-invalid @enderror" name="no" value="" autocomplete="no" autofocus>

            @error('no')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

        <div class="form-group row">
            <label for="file" class="col-md-4 col-form-label text-md-right">{{ __('Plik') }}</label>
            <div class="col-md-6">
                <input id="file" type="file" class="form-control @error('file') is-invalid @enderror" name="file" value="" required autofocus>

                @error('file')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Dodaj') }}
                </button>
            </div>
        </div>
    </form>
@endsection
