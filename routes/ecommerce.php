<?php

use App\Pages\Ecommerce\Shop;
use App\Pages\Ecommerce\Checkout;
use App\Pages\Ecommerce\OrderList;
use Illuminate\Support\Facades\Route;
use App\Pages\Ecommerce\ProductDetails;
use App\Pages\EcommerceAdmin\BrandList;
use App\Pages\EcommerceAdmin\Dashboard;
use App\Pages\EcommerceAdmin\DealerList;
use App\Pages\EcommerceAdmin\ProductList;
use App\Pages\EcommerceAdmin\CategoryList;
use App\Pages\Ecommerce\DealerDeliveryList;
use App\Pages\EcommerceAdmin\InventoryList;
use App\Pages\EcommerceAdmin\OrderDeliveryList;

Route::group(['prefix' => 'shop', 'as' => 'ecommerce.','middleware' => ['auth']], function () {
    Route::get('/', Shop::class)->name('shop');
    Route::get('product/{id}', ProductDetails::class)->name('product');
    Route::get('checkout', Checkout::class)->name('checkout');
    Route::get('order-list', OrderList::class)->name('order_list');
    Route::get('dealer-delivery-list', DealerDeliveryList::class)->name('dealer_delivery_list');

    Route::group(['prefix' => 'admin', 'as' => 'admin.','middleware' => ['auth','role:superadmin']], function () {
        Route::get('/', Dashboard::class)->name('dashboard');
        Route::get('product-list', ProductList::class)->name('product_list');
        Route::get('category-list', CategoryList::class)->name('category_list');
        Route::get('brand-list', BrandList::class)->name('brand_list');
        Route::get('dealer-list', DealerList::class)->name('dealer_list');
        Route::get('order-delivery-list', OrderDeliveryList::class)->name('order_delivery_list');
        Route::get('inventory-list', InventoryList::class)->name('inventory_list');
    });
});
