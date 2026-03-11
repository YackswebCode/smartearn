<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Controller Imports
|--------------------------------------------------------------------------
*/

// Main Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;

// Authentication Controllers
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ConfirmPasswordController;

// Affiliate Controllers
use App\Http\Controllers\Affiliate\AffiliateController;
use App\Http\Controllers\Affiliate\TopAffiliateController;
use App\Http\Controllers\Affiliate\AffiliateProfileController;
use App\Http\Controllers\Affiliate\SkillGarageController;
use App\Http\Controllers\Affiliate\BusinessUniversityController;
use App\Http\Controllers\Affiliate\WalletController;
use App\Http\Controllers\Affiliate\WithdrawalController;
use App\Http\Controllers\Affiliate\AddFundsController;
use App\Http\Controllers\Affiliate\PublicProductController;
use App\Http\Controllers\Affiliate\MyLearningController;


/*
|--------------------------------------------------------------------------
| Root Route
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('home')
        : view('welcome');
});


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

// Registration
Route::controller(RegisterController::class)->group(function () {
    Route::get('register', 'showRegistrationForm')->name('register');
    Route::post('register', 'register');
});

// Login / Logout
Route::controller(LoginController::class)->group(function () {
    Route::get('login', 'showLoginForm')->name('login');
    Route::post('login', 'login');
    Route::post('logout', 'logout')->name('logout');
});

// Email Verification
Route::controller(VerificationController::class)->group(function () {
    Route::get('verify', 'show')->name('verification.notice');
    Route::post('verify', 'verify')->name('verification.verify');
    Route::post('verify/resend', 'resend')->name('verification.resend');
});

// Subscription payment (after email verification)
Route::get('/subscription/pay', [App\Http\Controllers\SubscriptionController::class, 'showPaymentForm'])->name('subscription.payment');
Route::post('/subscription/verify', [App\Http\Controllers\SubscriptionController::class, 'verifyPayment'])->name('subscription.verify');
// Password Reset
Route::controller(ForgotPasswordController::class)->group(function () {
    Route::get('password/reset', 'showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'sendResetCode')->name('password.email');
});

Route::controller(ResetPasswordController::class)->group(function () {
    Route::get('password/reset/code', 'showResetForm')->name('password.reset');
    Route::post('password/reset', 'reset')->name('password.update');
});

// Password Confirmation
Route::controller(ConfirmPasswordController::class)->group(function () {
    Route::get('password/confirm', 'showConfirmForm')->name('password.confirm');
    Route::post('password/confirm', 'confirm');
});


/*
|--------------------------------------------------------------------------
| Public & Static Pages
|--------------------------------------------------------------------------
*/

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::view('/about', 'about')->name('about');
Route::view('/faq', 'faq')->name('faq');
Route::view('/contact', 'contact')->name('contact');
Route::view('/terms', 'terms')->name('terms');
Route::view('/privacy', 'privacy')->name('privacy');


/*
|--------------------------------------------------------------------------
| Public Affiliate Product Page (No Login Required)
|--------------------------------------------------------------------------
*/

Route::get('/aff/{affiliateId}/{productSlug}', [PublicProductController::class, 'show'])
    ->name('affiliate.product.public');


/*
|--------------------------------------------------------------------------
| Payment Routes
|--------------------------------------------------------------------------
*/

Route::post('/payment/verify', [PaymentController::class, 'verify'])
    ->name('payment.verify');

Route::get('/payment/complete/{reference}', [PaymentController::class, 'complete'])
    ->name('payment.complete');


/*
|--------------------------------------------------------------------------
| Affiliate Routes (Authenticated & Verified Users)
|--------------------------------------------------------------------------
*/

Route::prefix('affiliate')
    ->name('affiliate.')
    ->middleware(['auth', 'verified'])
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard & Core Pages
        |--------------------------------------------------------------------------
        */

        Route::controller(AffiliateController::class)->group(function () {
            Route::get('/', 'dashboard')->name('index');
            Route::get('/dashboard', 'dashboard')->name('dashboard');
            Route::get('/orders', 'orders')->name('orders');
            Route::get('/marketplace', 'marketplace')->name('marketplace');
            Route::get('/statistics', 'statistics')->name('statistics');
            Route::get('/product/{slug}', 'productDetail')->name('product.detail');
            Route::get('/promote/{productId}', 'promoteProduct')->name('promote');
            Route::post('/marketplace/subscribe', 'subscribe')->name('marketplace.subscribe');
        });

        /*
        |--------------------------------------------------------------------------
        | Wallet & Withdrawals
        |--------------------------------------------------------------------------
        */

        Route::controller(WalletController::class)->group(function () {
            Route::get('/wallet', 'index')->name('wallet');
        });

        Route::controller(WithdrawalController::class)->group(function () {
            Route::get('/withdrawals', 'index')->name('withdrawals');
            Route::post('/withdrawals', 'store')->name('withdrawals.store');
        });

        /*
        |--------------------------------------------------------------------------
        | Add Funds
        |--------------------------------------------------------------------------
        */

        Route::controller(AddFundsController::class)->group(function () {
            Route::get('/add-funds', 'index')->name('add_funds');
            Route::post('/add-funds/verify', 'verify')->name('add_funds.verify');
        });

        /*
        |--------------------------------------------------------------------------
        | Top Affiliate
        |--------------------------------------------------------------------------
        */

        Route::get('/top-affiliate', [TopAffiliateController::class, 'index'])
            ->name('top_affiliate');

        /*
        |--------------------------------------------------------------------------
        | Profile
        |--------------------------------------------------------------------------
        */

        Route::controller(AffiliateProfileController::class)->group(function () {
            Route::get('/profile/edit', 'edit')->name('edit_profile');
            Route::post('/profile/update', 'update')->name('update_profile');
        });

        // New route for becoming a vendor
        Route::post('/profile/become-vendor', [AffiliateController::class, 'becomeVendor'])
            ->name('become_vendor');

        /*
        |--------------------------------------------------------------------------
        | Skill Garage
        |--------------------------------------------------------------------------
        */

        Route::controller(SkillGarageController::class)->group(function () {
            Route::get('/skill-garage', 'index')->name('skill_garage');
            Route::get('/skill-garage/faculty/{id}', 'showFaculty')->name('skill_garage.faculty');
            Route::get('/skill-garage/track/{id}', 'showTrack')->name('skill_garage.track');
            Route::post('/skill-garage/track/{id}/enroll', 'enroll')->name('skill_garage.enroll');
        });

        /*
        |--------------------------------------------------------------------------
        | Business University
        |--------------------------------------------------------------------------
        */

        Route::controller(BusinessUniversityController::class)->group(function () {
            Route::get('/business-university', 'index')->name('business_university');
            Route::get('/business-university/course/{slug}', 'showCourse')->name('business.course');
            Route::post('/business-university/course/{id}/enroll', 'enroll')->name('business.enroll');
            Route::get('/business-university/my-learning', 'myLearning')->name('business.my_learning');
            Route::get('/business-university/learning/{id}', 'learningCourse')->name('business.learning.course');
        });

        /*
        |--------------------------------------------------------------------------
        | My Learning
        |--------------------------------------------------------------------------
        */

        Route::controller(MyLearningController::class)->group(function () {
            Route::get('/my-learning', 'index')->name('my_learning');
            Route::get('/my-learning/{id}', 'show')->name('learning.track');
        });

    });


    // Vendor Routes (Authenticated & Verified)
Route::prefix('vendor')
    ->name('vendor.')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Vendor\VendorController::class, 'dashboard'])
            ->name('dashboard');
        Route::get('/orders', [App\Http\Controllers\Vendor\VendorOrderController::class, 'index'])->name('orders');
                // Product routes
        Route::resource('products', App\Http\Controllers\Vendor\VendorProductController::class)
            ->except(['show']); // we don't need a show page for now (can add later if needed)
        Route::get('/top-vendor', [App\Http\Controllers\Vendor\TopVendorController::class, 'index'])->name('top_vendor');
    });