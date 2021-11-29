@extends('layouts.dashboard')

@section('content')
<div class="container text-center">
    <div class="row">
        <div class="col-3">
            <p>Nazwa strony</p>
        </div>
        <div class="col-7">
            <p>Treść</p>
        </div>
        <div class="col-2">
            <p>Edytuj</p>
        </div>
    </div>
    @foreach($staticsites as $staticsite)
    <div class="row">
        <div class="col-3  justify-content-center"  style="display: flex;">
            <p style="align-self: center" class="m-0">{!!$staticsite->name!!}</p>
        </div>
        <div class="col-7  justify-content-center" style="display: flex;">
            <p style="align-self: center" class="m-0">"{!!$staticsite->content!!}"</p>
        </div>
        <div class="col-2">
            <a href="{{route('dashboard.staticsites.edit',$staticsite->id) }}"><button type="button" class="btn btn-primary">Edytuj stronę</button></a>
        </div>
    </div>
</div>
@endforeach
@endsection