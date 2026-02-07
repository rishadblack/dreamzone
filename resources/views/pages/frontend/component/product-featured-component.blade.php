@push('css')
    <style>
        .product-added {
            width: 100%;
            font-size: 15px;
            padding: 6px 0px;
            border-radius: 6px;
            text-align: center;
            text-transform: capitalize;
            text-shadow: var(-primary-tshadow);
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            transition: all linear .3s;
            -webkit-transition: all linear .3s;
            -moz-transition: all linear .3s;
            -ms-transition: all linear .3s;
            -o-transition: all linear .3s;
        }
    </style>
@endpush
<div class="feature-card">
    <div class="feature-media">
        <div class="feature-label"><label class="label-text feat">feature</label></div>
        <a class="feature-image" href="{{ route('frontend.product', ['product_id' => $product->id]) }}"><img
                src="{{ asset_storage($product->image_url) }}" alt="{{ $product->name }}"></a>
    </div>
    <div class="feature-content">
        <h6 class="feature-name"><a
                href="{{ route('frontend.product', ['product_id' => $product->id]) }}">{{ $product->name }}</a></h6>
        <h6 class="feature-price">
            @if ($product->discount_amount)
                <del>{{ numberFormat($product->net_price + $product->discount_amount, true) }}</del>
            @endif
            <span>{{ numberFormat($product->net_price, true) }}<small>/piece</small></span></span>
        </h6>
        <p class="feature-desc">
            {{ $product->short_description ? $product->short_description : textShort($product->description) }}</p>
        @if (cartProductExists($product->id))
            <button class="product-added btn btn-block btn-success" title="Added in Cart"><i
                    class="fas fa-shopping-basket"></i><span>added</span></button>
        @else
            <button class="product-add" title="Add to Cart" wire:click="$dispatch('addToCart','{{ $product->id }}')"><i
                    class="fas fa-shopping-basket"></i><span>add</span></button>
        @endif
    </div>
</div>
