<div>
    <aside wire:ignore.self class="cart-sidebar">
        <div class="cart-header">
            <div class="cart-total"><i class="fas fa-shopping-basket"></i><span>total item
                    ({{ collect($carts)->sum('product_quantity') }})</span></div>
            <button class="cart-close"><i class="icofont-close"></i></button>
        </div>
        <ul class="cart-list">
            @if (collect($carts)->count() > 0)
                @foreach ($carts as $cart)
                    <li class="cart-item">
                        <div class="cart-media"><a
                                href="{{ route('frontend.product', ['product_id' => $cart->id]) }}"><img
                                    src="{{ asset_storage($cart->image_url) }}" alt="product"></a>
                            <button class="cart-delete" wire:click="removeToCart({{ $cart->id }})"><i
                                    class="far fa-trash-alt"></i></button>
                        </div>
                        <div class="cart-info-group">
                            <div class="cart-info">
                                <h6><a
                                        href="{{ route('frontend.product', ['product_id' => $cart->id]) }}">{{ $cart->name }}</a>
                                </h6>
                                <p>Unit Price - {{ numberFormat($cart->net_price, true) }} |
                                    {{ pointformat($cart->point, true) }}</p>
                            </div>
                            <div class="cart-action-group">
                                <div class="product-action">
                                    <button class="action-minus" title="Quantity Minus"
                                        wire:click="cartDecrise({{ $cart->id }})"><i
                                            class="icofont-minus"></i></button>
                                    <input class="action-input" title="Quantity Number" type="text"
                                        wire:model.debounce.1000ms="item_quantity.{{ $cart->id }}" name="quantity"
                                        value="1">
                                    <button class="action-plus" title="Quantity Plus"
                                        wire:click="cartIncrise({{ $cart->id }})"><i
                                            class="icofont-plus"></i></button>
                                </div>
                                <h6>{{ numberFormat($cart->product_price_total, true) }}</h6>
                            </div>
                        </div>
                    </li>
                @endforeach
            @endif
        </ul>
        <div class="cart-footer">
            {{-- <span class="coupon-btn">Do you have a coupon code?</span> --}}
            {{-- <form class="coupon-form">
                <input type="text" placeholder="Enter your coupon code"><button type="submit"><span>apply</span></button>
            </form> --}}
            <a class="cart-checkout-btn" href="{{ route('frontend.checkout') }}"><span class="checkout-label">Proceed
                    to Checkout</span>
                <span class="checkout-price">{{ numberformat(collect($carts)->sum('product_price_total'), true) }} |
                    <span
                        class="">{{ pointformat(collect($carts)->sum('product_point_total'), true) }}</span></span>
            </a>
        </div>
    </aside>
</div>
