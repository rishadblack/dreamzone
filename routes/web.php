<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Pages\Login;
use App\Pages\Register;
use Illuminate\Support\Facades\Route;

Route::get('login', Login::class)->name('login');
Route::get('register', Register::class)->name('register');
Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::group(['prefix' => '/', 'as' => 'frontend.'], function () {
    // Route::permanentRedirect('/', 'login');
    Route::get('/', Login::class)->name('home');
    Route::get('contact', Login::class)->name('contact');
    // Route::get('/', Home::class)->name('home');
    // Route::get('about', About::class)->name('about');
    // Route::get('contact', Contact::class)->name('contact');
    // Route::get('project', Project::class)->name('project');
    // Route::get('project-details', ProjectDetails::class)->name('project_details');
    // Route::get('blog', Blog::class)->name('blog');
    // Route::get('blog-details', BlogDetails::class)->name('blog_details');
});

// require __DIR__ . '/auth.php';
