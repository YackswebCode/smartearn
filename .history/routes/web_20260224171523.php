<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Affiliate\AffiliateController;
use App\Http\Controllers\Affiliate\TopAffiliateController; 
use App\Http\Controllers\Affiliate\AffiliateProfileController; 
use App\Http\Controllers\Affiliate\SkillGarageController;
use App\Http\Controllers\Affiliate\BusinessUniversityController;
use App\Http\Controllers\Affiliate\CourseController;
use App\Http\Controllers\Affiliate\WalletController;
use App\Http\Controllers\Affiliate\WithdrawalController;
use App\Http\Controllers\Affiliate\AddFundsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| Public Website Routes
|--------------------------------------------------------------------------
*/

// Landing & info pages
Route::get('/', fn() => view('home'))->name('home');
Route::get('/about', fn() => view('about'))->name('about');
Route::get('/contact', fn() => view('contact'))->name('contact');
Route::get('/faq', fn() => view('faq'))->name('faq');
Route::get('/privacy', fn() => view('privacy'))->name('privacy');
Route::get('/terms', fn() => view('terms'))->name('terms');

/*
|--------------------------------------------------------------------------
| Authentication Routes (Design Only)
|--------------------------------------------------------------------------
*/

// Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Register → redirect to verify
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Verify page
Route::get('/verify', fn() => view('auth.verify'))->name('verify');

/*
|--------------------------------------------------------------------------
| Affiliate Routes
|--------------------------------------------------------------------------
*/
Route::prefix('affiliate')->name('affiliate.')->group(function () {

    Route::get('/', [AffiliateController::class, 'dashboard'])->name('index');
    Route::get('/dashboard', [AffiliateController::class, 'dashboard'])->name('dashboard');
    Route::get('/orders', [AffiliateController::class, 'orders'])->name('orders');
    Route::get('/marketplace', [AffiliateController::class, 'marketplace'])->name('marketplace');
    Route::get('/statistics', [AffiliateController::class, 'statistics'])->name('statistics');
    Route::get('/product/{slug}', [AffiliateController::class, 'productDetail'])->name('product.detail');
    Route::get('/promote/{productId}', [AffiliateController::class, 'promoteProduct'])->name('promote');
    Route::get('/top-affiliate', [TopAffiliateController::class, 'index'])->name('top_affiliate');

    // Profile & Learning
    Route::get('/profile/edit', [AffiliateProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [AffiliateProfileController::class, 'update'])->name('profile.update');
    Route::get('/skill-garage', [SkillGarageController::class, 'index'])->name('skill_garage');
    Route::get('/business-university', [BusinessUniversityController::class, 'index'])->name('business_university');
    Route::get('/course/{slug}', [CourseController::class, 'show'])->name('course.show');

    // Wallet & Payments
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet');
    Route::get('/withdrawals', [WithdrawalController::class, 'index'])->name('withdrawals');
    Route::get('/add-funds', [AddFundsController::class, 'index'])->name('add_funds');
});