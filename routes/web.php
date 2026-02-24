<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Affiliate\AffiliateController;
use App\Http\Controllers\Affiliate\TopAffiliateController;
use App\Http\Controllers\Affiliate\AffiliateProfileController;
use App\Http\Controllers\Affiliate\SkillGarageController;
use App\Http\Controllers\Affiliate\BusinessUniversityController;
use App\Http\Controllers\Affiliate\CourseController;
use App\Http\Controllers\Affiliate\WalletController;
use App\Http\Controllers\Affiliate\WithdrawalController;
use App\Http\Controllers\Affiliate\AddFundsController;

// Root route - redirects logged-in users to /home
Route::get('/', function () {
    return auth()->check() ? redirect()->route('home') : view('welcome');
});

// Authentication routes with email verification
Auth::routes(['verify' => true]);

// Home route
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Email verification notice route
Route::get('/verify', function () {
    return view('auth.verify'); // Make sure this file exists: resources/views/auth/verify.blade.php
})->middleware('auth')->name('verification.notice');

// Static pages
Route::view('/about', 'about')->name('about');
Route::view('/faq', 'faq')->name('faq');
Route::view('/contact', 'contact')->name('contact');
Route::view('/terms', 'terms')->name('terms');
Route::view('/privacy', 'privacy')->name('privacy');

// Affiliate routes
Route::prefix('affiliate')->name('affiliate.')->group(function () {

    // Dashboard & main pages
    Route::get('/', [AffiliateController::class, 'dashboard'])->name('index');
    Route::get('/dashboard', [AffiliateController::class, 'dashboard'])->name('dashboard');
    Route::get('/orders', [AffiliateController::class, 'orders'])->name('orders');
    Route::get('/marketplace', [AffiliateController::class, 'marketplace'])->name('marketplace');
    Route::get('/statistics', [AffiliateController::class, 'statistics'])->name('statistics');

    // Wallet & withdrawals
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet');
    Route::get('/withdrawals', [WithdrawalController::class, 'index'])->name('withdrawals');

    // Product & promotion
    Route::get('/product/{slug}', [AffiliateController::class, 'productDetail'])->name('product.detail');
    Route::get('/promote/{productId}', [AffiliateController::class, 'promoteProduct'])->name('promote');

    // Top affiliate
    Route::get('/top-affiliate', [TopAffiliateController::class, 'index'])->name('top_affiliate');

    // Profile routes
    Route::get('/profile/edit', [AffiliateProfileController::class, 'edit'])->name('edit_profile');
    Route::post('/profile/update', [AffiliateProfileController::class, 'update'])->name('update_profile');

    // Learning & skill routes
    Route::get('/skill-garage', [SkillGarageController::class, 'index'])->name('skill_garage');
    Route::get('/business-university', [BusinessUniversityController::class, 'index'])->name('business_university');
    Route::get('/course/{slug}', [CourseController::class, 'show'])->name('course.show');

    // Add funds
    Route::get('/add-funds', [AddFundsController::class, 'index'])->name('add_funds');
});