@extends('layout.site', ['title' => 'Каталог товаров'])

@section('content')
    <h2 class="mb-4">Разделы каталога</h2>
    <div class="row">
        @foreach ($roots as $root)
            @if($root->id == 1)
                @continue
            @endif
            @include('catalog.part.category', ['category' => $root])
        @endforeach
    </div>

{{--    <h2 class="mb-4">Популярные бренды</h2>--}}
{{--    <div class="row">--}}
{{--        @foreach ($brands as $brand)--}}
{{--            @include('catalog.part.brand', ['brand' => $brand])--}}
{{--        @endforeach--}}
{{--    </div>--}}
@endsection


