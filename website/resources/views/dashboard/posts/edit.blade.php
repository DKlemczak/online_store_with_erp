@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="text-center rounded color">
        <h1 class="display-4">Aktualności</h1>
    </div>
<form enctype="multipart/form-data" action="{{ route('dashboard.posts.update', $posts->id) }}" method="post" accept-charset="utf-8">

    @csrf
    @method('PATCH')
    <div class="container" style="width:50%;">
        <div class="row no-gutters mb-2">
            <label for="title" class="col-form-label">Tytuł: </label>
            <div class="color ml-auto">
                <input id="title" type="text" class="form-control" name="title" value="{{$posts->title}}" required>
                @if ($errors->has('title'))
                    <span class="help-block">
                        <strong>{{ $errors->first('title') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="row no-gutters mb-2">
            <label for="description" class="col-form-label">Zawartość: </label>
            <div class="color ml-auto">
                <textarea id="mytextarea" class="form-control" name="description" style="max-width: 100%;" rows="15">{!! $posts ->description !!}</textarea>
                @if ($errors->has('description'))
                    <span class="help-block">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                @endif
            </div>
        </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-lg btn-secondary mr-1">Zapisz</button>
                <button type="button" onclick="location.href='{{ route('dashboard.posts.index')}}'" class="btn btn-lg btn-secondary ml-1">Zamknij</button>
            </div>
    </div>
</form>
</div>
<script type="text/javascript">
    tinymce.init({
      selector: '#mytextarea'
    });
</script>
@endsection