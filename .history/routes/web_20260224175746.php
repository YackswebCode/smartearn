<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Affiliate\AffiliateController;
use App\Http\Controllers\Affiliate\TopAffiliateController; 
use App\Http\Controllers\Affiliate\AffiliateProfileController;
    use App\Http\Controllers\Affiliate\SkillGarageController;


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
    Route::get('/orders', [AffiliateController::class, 'orders'])->name('orders');
    Route::get('/marketplace', [AffiliateController::class, 'marketplace'])->name('marketplace');
    Route::get('/statistics', [AffiliateController::class, 'statistics'])->name('statistics');
    Route::get('/withdrawals', [AffiliateController::class, 'withdrawals'])->name('withdrawals');
    Route::get('/product/{slug}', [AffiliateController::class, 'productDetail'])->name('product.detail');
    Route::get('/promote/{productId}', [AffiliateController::class, 'promoteProduct'])->name('promote');
    // Corrected route for top affiliate (relative path)
    Route::get('/top-affiliate', [TopAffiliateController::class, 'index'])->name('top_affiliate'); 
    // Profile routes – names match sidebar expectation
    Route::get('/profile/edit', [AffiliateProfileController::class, 'edit'])->name('edit_profile');
    Route::post('/profile/update', [AffiliateProfileController::class, 'update'])->name('update_profile');
    Route::get('/skill-garage', [SkillGarageController::class, 'index'])->name('skill_garage');
});





