@extends('layouts.dashboard')

@section('content')
<div class="container text-center">
    <a href="{{route('dashboard.posts.create') }}"><button type="button" class="btn btn-primary">Dodaj post</button></a>
    <div class="row">
        <div class="col-3">
            <p>Tytuł</p>
        </div>
        <div class="col-3">
            <p>Zawartość</p>
        </div>
        <div class="col-2">
            <p>Autor</p>
        </div>
        <div class="col-2">
            <p>Edycja</p>
        </div>
        <div class="col-2">
            <p>Usuń</p>
        </div>
    </div>
    @foreach($posts as $post)
    <div class="row">
        <div class="col-3  justify-content-center"  style="display: flex;">
            <p style="align-self: center" class="m-0">{!!$post->title!!}</p>
        </div>
        <div class="col-3  justify-content-center" style="display: flex;">
            <p style="align-self: center" class="m-0">{!!$post->description!!}</p>
        </div>
        <div class="col-2  justify-content-center" style="display: flex;">
            <p style="align-self: center"  class="m-0">{!!$post->user->name!!}</p>
        </div>
        <div class="col-2">
            <a href="{{route('dashboard.posts.edit',$post->id) }}"><button type="button" class="btn btn-primary">Edytuj post</button></a>
        </div>
        <div class="col-2">
            <form method="POST" enctype="multipart/form-data" action="{{ route('dashboard.posts.destroy',[$post->id]) }}" accept-charset="UTF-8">
                @method('DELETE')
                @csrf
                <input class="form-control" type="hidden" name="post_id" value="{!!$post->id!!}">
                <button type="submit" class="btn btn-danger">Usuń zdjęcie</button></a>
            </form>
        </div>
    </div>
    @endforeach
    {{ $posts->links() }}
</div>
@endsection