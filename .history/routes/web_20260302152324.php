<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

// Affiliate Controllers
use App\Http\Controllers\Affiliate\AffiliateController;
use App\Http\Controllers\Affiliate\TopAffiliateController;
use App\Http\Controllers\Affiliate\AffiliateProfileController;
use App\Http\Controllers\Affiliate\SkillGarageController;
use App\Http\Controllers\Affiliate\BusinessUniversityController;
use App\Http\Controllers\Affiliate\CourseController;
use App\Http\Controllers\Affiliate\WalletController;
use App\Http\Controllers\Affiliate\WithdrawalController;
use App\Http\Controllers\Affiliate\AddFundsController;
use App\Http\Controllers\Affiliate\PublicProductController;

// Custom Authentication Controllers
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ConfirmPasswordController;

// Payment Controller
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| Root Route
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return auth()->check() ? redirect()->route('home') : view('welcome');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes (Custom)
|--------------------------------------------------------------------------
*/

// Registration
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Login / Logout
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Email Verification (6‑digit code, no auth middleware)
Route::get('verify', [VerificationController::class, 'show'])->name('verification.notice');
Route::post('verify', [VerificationController::class, 'verify'])->name('verification.verify');
Route::post('verify/resend', [VerificationController::class, 'resend'])->name('verification.resend');

// Password Reset (code‑based)
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetCode'])->name('password.email');
Route::get('password/reset/code', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Password Confirmation (optional)
Route::get('password/confirm', [ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
Route::post('password/confirm', [ConfirmPasswordController::class, 'confirm']);

/*
|--------------------------------------------------------------------------
| Public & Static Pages
|--------------------------------------------------------------------------
*/

// Home route (after login)
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Static pages
Route::view('/about', 'about')->name('about');
Route::view('/faq', 'faq')->name('faq');
Route::view('/contact', 'contact')->name('contact');
Route::view('/terms', 'terms')->name('terms');
Route::view('/privacy', 'privacy')->name('privacy');

/*
|--------------------------------------------------------------------------
| Affiliate Routes (Authenticated & Verified)
|--------------------------------------------------------------------------
*/
Route::prefix('affiliate')->name('affiliate.')->middleware(['auth', 'verified'])->group(function () {

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
    Route::get('/skill-garage/faculty/{id}', [SkillGarageController::class, 'showFaculty'])->name('skill_garage.faculty');
Route::get('/skill-garage/track/{id}', [SkillGarageController::class, 'showTrack'])->name('skill_garage.track');
Route::post('/skill-garage/track/{id}/enroll', [SkillGarageController::class, 'enroll'])->name('skill_garage.enroll');
    Route::get('/business-university', [BusinessUniversityController::class, 'index'])->name('business_university');
    Route::get('/course/{slug}', [CourseController::class, 'show'])->name('course.show');

    // Add funds
    Route::get('/add-funds', [AddFundsController::class, 'index'])->name('add_funds');

    // Marketplace subscription
    Route::post('/marketplace/subscribe', [AffiliateController::class, 'subscribe'])->name('marketplace.subscribe');
});

/*
|--------------------------------------------------------------------------
| Public Product Page (Authenticated users only)
|--------------------------------------------------------------------------
*/

// Public product page (no login required)
Route::get('/aff/{affiliateId}/{productSlug}', [App\Http\Controllers\Affiliate\PublicProductController::class, 'show'])
    ->name('affiliate.product.public');;
/*
|--------------------------------------------------------------------------
| Payment Verification (POST)
|--------------------------------------------------------------------------
*/
Route::post('/payment/verify', [App\Http\Controllers\PaymentController::class, 'verify'])->name('payment.verify');
Route::get('/payment/complete/{reference}', [App\Http\Controllers\PaymentController::class, 'complete'])->name('payment.complete');