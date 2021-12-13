@extends('layout.site')

@section('content')
    <h1>Интернет-магазин у Алуси</h1>
    <p>
        Наш интернет-магазин находится в городе Чернигове, поэтому доставка по Чернигову бесплатная.
        В остальные города, доставка любой почтой.
    </p>
    <p>
        Оформляйте заказ через корзину и мы вам обязательно перезвоним.
    </p>
    <p>
        По всем вопросам обращайтесь по телефону 063 183 48 41 , 066 196 76 60 - Алла.
    </p>

    @if($new->count())
        <h2>Новинки</h2>
        <div class="row">
        @foreach($new as $item)
            @include('catalog.part.product', ['product' => $item])
        @endforeach
        </div>
    @endif

    @if($hit->count())
        <h2>Лидеры продаж</h2>
        <div class="row">
            @foreach($hit as $item)
                @include('catalog.part.product', ['product' => $item])
            @endforeach
        </div>
    @endif

    @if($sale->count())
        <h2>Распродажа</h2>
        <div class="row">
            @foreach($sale as $item)
                @include('catalog.part.product', ['product' => $item])
            @endforeach
        </div>
    @endif
@endsection
