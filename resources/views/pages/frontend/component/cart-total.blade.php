<button class="header-widget header-cart" title="Cartlist">
    <i class="fas fa-shopping-basket"></i>
    <sup>{{collect($carts)->sum('product_quantity')}}</sup>
    <span> total price<small>{{numberFormat(collect($carts)->sum('product_price_total') , true)}}</small></span>
</button>
