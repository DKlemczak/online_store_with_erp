@extends('layouts.dashboard')

@section('content')
<div class="row mx-4 col-10">
    <a class="nav-link m-0 p-0 w-25"  href="{{ route('dashboard.products.index') }}">
        <div class="col-12 text-center rounded" style="border: 2px solid #ffc90e;">
            <p class="h2 my-4">Produkty</p>
        </div>
    </a>
    <a class="nav-link m-0 p-0 w-25"  href="{{ route('dashboard.posts.index') }}">
        <div class="col-12 text-center rounded" style="border: 2px solid #ffc90e;">
            <p class="h2 my-4">Aktualności</p>
        </div>
    </a>
</div>
@endsection
