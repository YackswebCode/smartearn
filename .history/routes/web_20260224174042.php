<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Affiliate\AffiliateController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::view('/about', 'about')->name('about');
Route::view('/faq', 'faq')->name('faq');
Route::view('/contact', 'contact')->name('contact');
Route::view('/terms', 'terms')->name('terms');
Route::view('/privacy', 'privacy')->name('privacy');

// Affiliate routes
Route::prefix('affiliate')->name('affiliate.')->group(function () {

    Route::get('/', [AffiliateController::class, 'dashboard'])->name('index');
    Route::get('/dashboard', [AffiliateController::class, 'dashboard'])->name('dashboard');

    // NEW: Orders page route
    Route::get('/orders', [AffiliateController::class, 'orders'])->name('orders');

    Route::get('/marketplace', [AffiliateController::class, 'marketplace'])->name('marketplace');
        Route::get('/top-affiliate', [AffiliateController::class, 'topAffiliate'])->name('top_affiliate');
        Route::get('/edit-profile', [AffiliateController::class, 'editProfile'])->name('profile.edit');
        Route::post('/update-profile', [AffiliateController::class, 'updateProfile'])->name('profile.update');
    // Product detail route
    Route::get('/product/{slug}', [AffiliateController::class, 'productDetail'])->name('product.detail'); 
     // ADD this promote route
    Route::get('/promote/{productId}', [AffiliateController::class, 'promoteProduct'])->name('promote');
});



