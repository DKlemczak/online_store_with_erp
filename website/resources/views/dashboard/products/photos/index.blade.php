@extends('layouts.dashboard')

@section('content')
<a href="{{route('dashboard.products.photos.create',$product_id)}}"><button class="btn btn-success">Dodaj zdjęcie</button></a>
<div class="container text-center">
    <div class="row">
        <div class="col-1">
            <p>Lp.</p>
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
        <div class="col-1 justify-content-center" style="display: flex;">
            <p style="align-self: center" class="m-0">{!!$photo->no!!}</p>
        </div>
        <div class="col-6 justify-content-center" style="display: flex;">
            <img src="{!!$photo->path!!}" />
        </div>
        <div class="col-3 justify-content-center" style="display: flex;">
            <p style="align-self: center" class="m-0">{!!$photo->path!!}</p>
        </div>
        <div class="col-2 justify-content-center" style="display: flex;">
            <form method="POST" enctype="multipart/form-data" action="{{ route('dashboard.products.photos.destroy',[$photo->product_id,$photo->id]) }}" accept-charset="UTF-8">
                @method('DELETE')
                @csrf
                <input class="form-control" type="hidden" name="photo_id" value="{!!$photo->id!!}">
                <button type="submit" class="btn btn-danger">Usuń zdjęcie</button></a>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endsection
