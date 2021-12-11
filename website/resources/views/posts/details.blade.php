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
                    <label for="comment" class="col-form-label">Treść: </label>
                    <textarea class="form-control" name="comment" style="max-width: 100%; resize:none" rows="15"></textarea>
                    @if ($errors->has('comment'))
                        <span class="help-block">
                            <strong>{{ $errors->first('comment') }}</strong>
                        </span>
                    @endif
                </div> 
                <div class="form-group col-12 row">
                   <div class="d-flex justify-content-center"> 
                        <button type="submit" class="button">Dodaj komentarz</button>
                    </div>
                </div> 
            </div> 
 
    
        </form>
        @endauth


    <div class="row d-flex justify-content-center mt-100 mb-100">
    
        
        @foreach($post->comments as $comment)
            <div class=" mt-5 mb-2">
                @auth
                    @if(Auth::user()->is_admin)

                    <button class="button"> <a href="{{ route('posts.details.deletecomment', $comment->id) }}">Usuń komentarz</a></button>  
                   
                    @endif
                @endauth
            </div>

            <div class="comment-widgets">
                <div class="d-flex flex-row comment-row m-t-0">
                    <div class="comment-text w-100">
                        <h5 class="font-medium"> <strong>{!! $comment->user->name !!}</strong> </h5> <span class="m-b-15 d-block">{!! $comment->comment !!} </span>
                        <div class="comment-footer"> <span class="text-muted float-right"> Data dodania komentarza: <strong> {!! $comment->created_at!!} </strong></span>
                         
                    </div>
                </div> 
               
                </div> <!-- Card -->
        @endforeach
    </div>
</div>
</div>
@endsection