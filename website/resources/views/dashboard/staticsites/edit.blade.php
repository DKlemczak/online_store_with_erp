@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="text-center rounded color">
        <h1 class="display-4">Aktualności</h1>
    </div>
<form enctype="multipart/form-data" action="{{ route('dashboard.staticsites.update', $staticsites->id) }}" method="post" accept-charset="utf-8">

    @csrf
    @method('PATCH')
    <div class="container" style="width:50%;">
        <div class="row no-gutters mb-2">
            <label for="name" class="col-form-label">Nazwa: </label>
            <div class="color ml-auto">
                <input id="name" type="text" class="form-control" name="name" value="{{$staticsites->name}}" required>
                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="row no-gutters mb-2">
            <label for="content" class="col-form-label">Treść: </label>
            <div class="color ml-auto">
                <textarea id="mytextarea" class="form-control" name="content" style="max-width: 100%;" rows="15">{!! $staticsites ->content !!}</textarea>
                @if ($errors->has('content'))
                    <span class="help-block">
                        <strong>{{ $errors->first('content') }}</strong>
                    </span>
                @endif
            </div>
        </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-lg btn-secondary mr-1">Zapisz</button>
                <button type="button" onclick="location.href='{{ route('dashboard.staticsites.index')}}'" class="btn btn-lg btn-secondary ml-1">Zamknij</button>
            </div>
    </div>
</form>
</div>
<script type="text/javascript">
    tinymce.init({
      selector: '#mytextarea',
      language: 'pl',
      plugins: [
          "code"
          ]
    });
</script>
@endsection