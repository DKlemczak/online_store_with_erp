@extends('layouts.dashboard')

@section('content')
<div class="container text-center">
    <div class="row">
        <div class="col-1">
            <p>Liczba porządkowa</p>
        </div>
        <div class="col-6">
            <p>Zdjęcie</p>
        </div>
        <div class="col-3">
            <p>Ścieżka</p>
        </div>
        <div class="col-2">
            <p>Usuń</p>
        </div>
    </div>
    @foreach($photos as $photo)
    <div class="row">
        <div class="col-2">
            <a href="route"><button type="button" class="btn btn-danger">Usuń zdjęcie</button></a>
        </div>
    @endforeach
</div>
@endsection
