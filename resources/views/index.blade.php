@extends('layout.site')

@section('content')
    <h1>Интернет-магазин по продаже одежды</h1>
    <p>
        Наш интернет-магазин находится в городе Чернигове, поэтому доставка по Чернигову бесплатная.
        В остальные города, доставка любой почтой.
    </p>
    <p>
        При оформлении заказа, пожалуйста, пользуйтесь корзиной(регистрация очень быстрая)
        и мы вам обязательно перезвоним.
    </p>
    <p>
        По всем вопросам обращайтесь по телефону +380xxxxxxxxxx - Алла.
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
