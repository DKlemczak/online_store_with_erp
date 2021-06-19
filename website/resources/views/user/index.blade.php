@extends('layouts.user')

@section('content')
<div class="container text-center">
        <div class="row">
            <div class="col-3">
                <p>Numer dokumentu</p>
            </div>
            <div class="col-3">
                <p>Adres</p>
            </div>
            <div class="col-2">
                <p>Wartość</p>
            </div>
            <div class="col-2">
                <p>Status</p>
            </div>
            <div class="col-2">
                <p>Pozycje</p>
            </div>
        </div>
        @foreach(Auth::User()->Order as $Order )
        <div class="container text-center">
        <div class="row">
            <div class="col-3">
                <p>{!!$Order->document_number!!}</p>
            </div>
            <div class="col-3">
                <p>{!!$Order->city!!}, {!!$Order->street!!} {!!$Order->building_number!!}</p>
            </div>
            <div class="col-2">
                <p>{!!$Order->value!!} zł</p>
            </div>
            <div class="col-2">
                @if($Order->status == 0)
                    <p class="my-auto">Nie opłacono</p>
                @elseif($Order->status == 1)
                    <p class="my-auto">Opłacony</p>
                @else
                    <p class="my-auto">Zatwierdzony</p>
                @endif
            </div>
            <div class="col-2">
            <a data-toggle="collapse" href="#collapse{!!$Order->id!!}" aria-expanded="false" aria-controls="collapse{!!$Order->id!!}">
                <i class="fas fa-sort-down" aria-hidden="true"></i>
            </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12 collapse" id="collapse{!!$Order->id!!}">
                <div class="card card-body">
                <div class="row">
                    <div class="col-3">
                        <p>Nazwa produktu</p>
                    </div>
                    <div class="col-3">
                        <p>Ilość</p>
                    </div>
                    <div class="col-2">
                        <p>Cena</p>
                    </div>
                    <div class="col-2">
                        <p>Wartość</p>
                    </div>
                </div>
                @foreach($Order->Positions as $Position)
                    <div class="row">
                        <div class="col-3">
                            <p>{!!$Position->Product->name!!}</p>
                        </div>
                        <div class="col-3">
                            <p>{!!$Position->amount!!}</p>
                        </div>
                        <div class="col-2">
                            <p>{!!$Position->price!!} zł</p>
                        </div>
                        <div class="col-2">
                            <p>{!!$Position->price * $Position->amount!!} zł</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endforeach
@endsection