@extends('layouts.app')

@section('content')
<div class="col-12 col-lg-10 offset-lg-1">
    <div class="row">
        @foreach($posts as $post)
            <div class="col-12 text-center">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{!!$post->title!!} - autor {!!$post->user->name!!} {!!$post->created_at!!}</h5>
                        <p class="card-text">{!!$post->description!!}</p>

                        <a href="{{ route('posts.details', [$post->id]) }}" class="btn btn-primary">Przejdź do aktualności</a>
                    </div>
                </div>
            </div>
        @endforeach
        {{ $posts->links() }}
    </div>
</div>
@endsection