@extends('layouts.app')

@section('content')
<p>{!!$product->name!!}</p>
<p>{!!$product->description!!}</p>
@if($product->discount > 0)
<p>{{$product->price - $product->price * ($product->discount * 0.01)}} <span style="text-decoration: line-through;color: red;">{!!$product->price!!}</span></p>
@else
<p>{!!$product->price!!}</p>
@endif
<p>Tagi: 
@foreach($product->Products_tags as $tag)
{!!$tag->name!!},
@endforeach
</p>
@if($product->amount>0)
<form method="POST" enctype="multipart/form-data" action="{{ route('cart.addtocart') }}" accept-charset="UTF-8">
    @csrf
    <div class="form-group">
        <p>Ilość<input class="form-control" type="number" name="amount" value="1" min="1" max="{!!$product->amount!!}"></p>
        <input class="form-control" type="hidden" name="product_id" value="{!!$product->id!!}">
        <button type="submit">Dodaj do koszyka</button>
    </div>
</form>
@else
    <p>Brak produktu na stanie</p>
@endif
@endsection
