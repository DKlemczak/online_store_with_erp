@extends('layouts.app')

@section('content')
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
<div class="col-12 col-lg-10 offset-lg-1">
    <div class="row">
        <div class="col-12">  
            <h2>{!!$post->name!!}</h2>
            <h4> Treść: </h4>
            <p>{!!$post->description!!}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-12 h3 mb-4" style="border-bottom: 1px solid #753c52;">Komentarze</div>
        @auth
        <form enctype="multipart/form-data" action="{{ route('posts.details.addcomment', $post->id) }}" method="post" accept-charset="utf-8">
        @csrf
            <div class="container">
                <div class="row no-gutters mb-4">
                    <label for="comment" class="col-form-label">Dodaj komentarz: </label>
                    <textarea class="form-control" name="comment" style="max-width: 100%; resize:none" rows="15"></textarea>
                    @if ($errors->has('comment'))
                        <span class="help-block">
                            <strong>{{ $errors->first('comment') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group col-12 row">
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-lg btn-secondary">Zapisz</button>
                    </div>
                </div>
            </div>
        </form>
        @endauth
        @foreach($post->comments as $comment)
            <div class=" mt-5 mb-2">
                <strong>{!! $comment->user->name !!}</strong>
                @auth
                    @if(Auth::user()->is_admin)
                        <button class="btn"><a href="{{ route('posts.details.deletecomment', $comment->id) }}">Usuń komentarz</a></button>
                    @endif
                @endauth
            </div>
            <div class="shadow">
                {!! $comment->comment !!}
            </div>
        @endforeach
    </div>
</div>
@endsection