@extends('layouts.app')

@section('content')
<!-- DK:Pętla listująca produkty, które są aktywne i są w danej grupie. W środku przekierowanie idące do szczegółów danego produktu-->
@foreach($products as $product)
    <a href="{{ route('products.details', [$product->group_id,$product->id]) }}">{!!$product->name!!}</a>
@endforeach
@endsection
