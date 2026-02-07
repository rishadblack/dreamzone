<?php

use App\Pages\EcommerceAdmin;
use App\Pages\Ecommerce\Checkout;
use App\Pages\Ecommerce\DealerDeliveryList;
use App\Pages\Ecommerce\OrderList;
use App\Pages\Ecommerce\ProductDetails;
use App\Pages\Ecommerce\Shop;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'ecommerce', 'as' => 'ecommerce.', 'middleware' => ['auth']], function () {
    Route::get('/', Shop::class)->name('shop');
    Route::get('product/{id}', ProductDetails::class)->name('product');
    Route::get('checkout', Checkout::class)->name('checkout');
    Route::get('order-list', OrderList::class)->name('order_list');
    Route::get('dealer-delivery-list', DealerDeliveryList::class)->name('dealer_delivery_list');

    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'role:superadmin']], function () {
        Route::get('/', EcommerceAdmin\Dashboard::class)->name('dashboard');
        Route::get('product-list', EcommerceAdmin\ProductList::class)->name('product_list');
        Route::get('category-list', EcommerceAdmin\CategoryList::class)->name('category_list');
        Route::get('brand-list', EcommerceAdmin\BrandList::class)->name('brand_list');
        Route::get('slider-list', EcommerceAdmin\SliderList::class)->name('slider_list');
        Route::get('dealer-list', EcommerceAdmin\DealerList::class)->name('dealer_list');
        Route::get('order-delivery-list', EcommerceAdmin\OrderDeliveryList::class)->name('order_delivery_list');
        Route::get('inventory-list', EcommerceAdmin\InventoryList::class)->name('inventory_list');
    });
});