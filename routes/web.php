<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Pages\Frontend;
use App\Pages\Login;
use App\Pages\Register;
use Illuminate\Support\Facades\Route;

Route::get('login', Login::class)->name('login')->middleware('guest');
Route::get('register', Register::class)->name('register')->middleware('guest');
Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::group(['prefix' => '/', 'as' => 'frontend.'], function () {
    // Route::permanentRedirect('/', 'login');
    Route::get('/', Frontend\Home::class)->name('home');
    Route::get('about-us', Frontend\AboutUs::class)->name('about_us');
    Route::get('shop', Frontend\Shop::class)->name('shop');
    Route::get('product/{product_id}', Frontend\Product::class)->name('product');
    Route::get('cart', Frontend\Cart::class)->name('cart');
    Route::get('checkout', Frontend\Checkout::class)->name('checkout')->middleware('auth');
    Route::get('contact-us', Frontend\ContactUs::class)->name('contact');
    Route::get('privacy', Frontend\PrivacyPolicy::class)->name('privacy');
    Route::get('terms-and-condition', Frontend\TermsAndCondition::class)->name('terms_and_condition');
});
