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

        <!-- <div class="container"> 
                <div class="row no-gutters mb-4">
                    <label for="comment" class="col-form-label">Treść: </label>
                    <textarea class="form-control" name="comment" style="max-width: 100%; resize:none" rows="15"></textarea>
                    @if ($errors->has('comment'))
                        <span class="help-block">
                            <strong>{{ $errors->first('comment') }}</strong>
                        </span>
                    @endif
                </div>  -->


    </div> 
</div>

        
</nav>
<section>
    <div class="container">
        <div class="row">
            
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

        <div class="col-sm-5 col-md-6 col-12 pb-4">
                <div class="comment mt-4 text-justify float-left"> 
                    <h4>Jhon Doe</h4> <span>- 20 October, 2018</span> <br>
                    {!! $comment->comment !!}
                </div>
                <div class="text-justify darker mt-4 float-right"> 
                    <h4>Rob Simpson</h4> <span>- 20 October, 2018</span> <br>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Accusamus numquam assumenda hic aliquam vero sequi velit molestias doloremque molestiae dicta?</p>
                </div>
                <div class="comment mt-4 text-justify"> 
                    <h4>Jhon Doe</h4> <span>- 20 October, 2018</span> <br>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Accusamus numquam assumenda hic aliquam vero sequi velit molestias doloremque molestiae dicta?</p>
                </div>
                <div class="darker mt-4 text-justify"> 
                    <h4>Rob Simpson</h4> <span>- 20 October, 2018</span> <br>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Accusamus numquam assumenda hic aliquam vero sequi velit molestias doloremque molestiae dicta?</p>
                </div>









            </div>

            
            <div class="col-lg-4 col-md-5 col-sm-4 offset-md-1 offset-sm-1 col-12 mt-4">
            @auth
        <form enctype="multipart/form-data" action="{{ route('posts.details.addcomment', $post->id) }}" method="post" accept-charset="utf-8">
        @csrf
                <form id="algin-form">
                    <div class="form-group">
                        <h4>Zostaw komentarz</h4> <label for="message">Treść:</label> <textarea name="comment" id="" msg cols="30" rows="5" class="form-control"></textarea>
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
                </form>
            </div>
        </div>
    </div>
</section>
            
    
        </form>
        @endauth
        <!-- @foreach($post->comments as $comment)
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
        @endforeach -->
    </div>
</div>
@endsection