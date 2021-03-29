@extends('layouts.app')

@section('content')
<p>{!!$product->name!!}</p>
<p>{!!$product->description!!}</p>
@endsection
