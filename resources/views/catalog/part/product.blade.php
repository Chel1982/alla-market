<div class="col-md-4 mb-4">
    <div class="card list-item">
        @if(iconv_strlen($product->name) <= 35)
            <div class="card-header">
                <h3 class="mb-0">{{ $product->name }}</h3>
            </div>
        @endif
        @if(iconv_strlen($product->name) > 35)
            <div class="card-header">
                <h3 class="mb-0">{{ mb_substr($product->name, 0, 35) }}...</h3>
            </div>
        @endif
        <div class="card-body p-0 position-relative">
            <div class="position-absolute">
                @if($product->new)
                    <span class="badge badge-info text-white ml-1">Новинка</span>
                @endif
                @if($product->hit)
                    <span class="badge badge-danger ml-1">Лидер продаж</span>
                @endif
                @if($product->sale)
                    <span class="badge badge-success ml-1">Распродажа</span>
                @endif
            </div>
            @php
                $image = $product->images()->first();
            @endphp
            @if ( isset($image) )
                @php( $url = url('storage/catalog/product/' . $product->id . '/thumb/' . $image->name) )
                <a href="{{ route('catalog.product', ['product' => $product->slug]) }}">
                    <img src="{{ $url }}" class="img-fluid" alt="">
                </a>
            @else
                <img src="https://via.placeholder.com/300x150" class="img-fluid" alt="">
            @endif
        </div>
        <div class="card-footer">
            <p class="price">{{$product->price}} грн</p>
            <!-- Форма для добавления товара в корзину -->
            <form action="{{ route('basket.add', ['id' => $product->id]) }}"
                  method="post" class="d-inline add-to-basket">
                @csrf
                <div class="col text-center">
                    <button type="submit" class="btn btn-success btn-default">В корзину</button>
                </div>
            </form>
        </div>
    </div>
</div>
