<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Controller Imports
|--------------------------------------------------------------------------
*/

/* Main Controllers */
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SubscriptionController;

/* Authentication Controllers */
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ConfirmPasswordController;

/* Affiliate Controllers */
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

/* Vendor Controllers */
use App\Http\Controllers\Vendor\VendorController;
use App\Http\Controllers\Vendor\VendorOrderController;
use App\Http\Controllers\Vendor\VendorProductController;
use App\Http\Controllers\Vendor\TopVendorController;

/* Admin Controllers */
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminVendorController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminTransactionController;
use App\Http\Controllers\Admin\AdminCommissionController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AdminManagementController;
use App\Http\Controllers\Admin\AdminWithdrawalController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FacultyController;
use App\Http\Controllers\Admin\TrackController;
use App\Http\Controllers\Admin\LectureController;
use App\Http\Controllers\Admin\EnrollmentController;
use App\Http\Controllers\Admin\BusinessFacultyController;
use App\Http\Controllers\Admin\BusinessCourseController;
use App\Http\Controllers\Admin\BusinessLectureController;
use App\Http\Controllers\Admin\BusinessEnrollmentController;


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

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->name('logout');
});

/* Email Verification */

Route::controller(VerificationController::class)->group(function () {
    Route::get('/verify', 'show')->name('verification.notice');
    Route::post('/verify', 'verify')->name('verification.verify');
    Route::post('/verify/resend', 'resend')->name('verification.resend');
});

/* Subscription Payment */

Route::get('/subscription/pay', [SubscriptionController::class, 'showPaymentForm'])
    ->name('subscription.payment');

Route::post('/subscription/verify', [SubscriptionController::class, 'verifyPayment'])
    ->name('subscription.verify');

/* Password Reset */

Route::controller(ForgotPasswordController::class)->group(function () {
    Route::get('/password/reset', 'showLinkRequestForm')->name('password.request');
    Route::post('/password/email', 'sendResetCode')->name('password.email');
});

Route::controller(ResetPasswordController::class)->group(function () {
    Route::get('/password/reset/code', 'showResetForm')->name('password.reset');
    Route::post('/password/reset', 'reset')->name('password.update');
});

/* Confirm Password */

Route::controller(ConfirmPasswordController::class)->group(function () {
    Route::get('/password/confirm', 'showConfirmForm')->name('password.confirm');
    Route::post('/password/confirm', 'confirm');
});


/*
|--------------------------------------------------------------------------
| Public Pages
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
| Public Affiliate Product Page
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
| Affiliate Routes
|--------------------------------------------------------------------------
*/

Route::prefix('affiliate')
    ->name('affiliate.')
    ->middleware(['auth', 'verified'])
    ->group(function () {

        /* Dashboard */

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

        /* Wallet */

        Route::get('/wallet', [WalletController::class, 'index'])->name('wallet');

        /* Withdrawals */

        Route::controller(WithdrawalController::class)->group(function () {
            Route::get('/withdrawals', 'index')->name('withdrawals');
            Route::post('/withdrawals', 'store')->name('withdrawals.store');
        });

        /* Add Funds */

        Route::controller(AddFundsController::class)->group(function () {
            Route::get('/add-funds', 'index')->name('add_funds');
            Route::post('/add-funds/verify', 'verify')->name('add_funds.verify');
        });

        /* Top Affiliate */

        Route::get('/top-affiliate', [TopAffiliateController::class, 'index'])
            ->name('top_affiliate');

        /* Profile */

        Route::controller(AffiliateProfileController::class)->group(function () {
            Route::get('/profile/edit', 'edit')->name('edit_profile');
            Route::post('/profile/update', 'update')->name('update_profile');
        });

        Route::post('/profile/become-vendor', [AffiliateController::class, 'becomeVendor'])
            ->name('become_vendor');

        /* Skill Garage */

        Route::controller(SkillGarageController::class)->group(function () {
            Route::get('/skill-garage', 'index')->name('skill_garage');
            Route::get('/skill-garage/faculty/{id}', 'showFaculty')->name('skill_garage.faculty');
            Route::get('/skill-garage/track/{id}', 'showTrack')->name('skill_garage.track');
            Route::post('/skill-garage/track/{id}/enroll', 'enroll')->name('skill_garage.enroll');
        });

        /* Business University */

        Route::controller(BusinessUniversityController::class)->group(function () {
            Route::get('/business-university', 'index')->name('business_university');
            Route::get('/business-university/course/{slug}', 'showCourse')->name('business.course');
            Route::post('/business-university/course/{id}/enroll', 'enroll')->name('business.enroll');
            Route::get('/business-university/my-learning', 'myLearning')->name('business.my_learning');
            Route::get('/business-university/learning/{id}', 'learningCourse')->name('business.learning.course');
        });

        /* My Learning */

        Route::controller(MyLearningController::class)->group(function () {
            Route::get('/my-learning', 'index')->name('my_learning');
            Route::get('/my-learning/{id}', 'show')->name('learning.track');
        });
});


/*
|--------------------------------------------------------------------------
| Vendor Routes
|--------------------------------------------------------------------------
*/

Route::prefix('vendor')
    ->name('vendor.')
    ->middleware(['auth', 'verified'])
    ->group(function () {

        Route::get('/dashboard', [VendorController::class, 'dashboard'])->name('dashboard');

        Route::get('/orders', [VendorOrderController::class, 'index'])->name('orders');

        Route::resource('products', VendorProductController::class)->except(['show']);

        Route::get('/top-vendor', [TopVendorController::class, 'index'])->name('top_vendor');

        Route::get('/withdrawals', [App\Http\Controllers\Vendor\VendorWithdrawalController::class, 'index'])->name('withdrawals');
        
        Route::post('/withdrawals', [App\Http\Controllers\Vendor\VendorWithdrawalController::class, 'store'])->name('withdrawals.store');
});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    /* Admin Authentication */

    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login']);
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | Protected Admin Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('auth:admin')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        /* Users */

        Route::resource('users', AdminUserController::class)->except(['create','store']);

        Route::post('/users/{user}/ban', [AdminUserController::class, 'ban'])
            ->name('users.ban');

        /* Vendors */

        Route::get('/vendors', [AdminVendorController::class, 'index'])->name('vendors.index');
        Route::get('/vendors/{vendor}', [AdminVendorController::class, 'show'])->name('vendors.show');
        Route::post('/vendors/{vendor}/approve', [AdminVendorController::class, 'approve'])->name('vendors.approve');
        Route::post('/vendors/{vendor}/reject', [AdminVendorController::class, 'reject'])->name('vendors.reject');

        /* Products */

        Route::resource('products', AdminProductController::class)->except(['show']);

        /* Orders */

        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');

        /* Finance */

        Route::get('/transactions', [AdminTransactionController::class, 'index'])->name('transactions.index');
        Route::get('/commissions', [AdminCommissionController::class, 'index'])->name('commissions.index');

        /* Withdrawals */

        Route::get('/withdrawals', [AdminWithdrawalController::class, 'index'])->name('withdrawals.index');
        Route::get('/withdrawals/{withdrawal}', [AdminWithdrawalController::class, 'show'])->name('withdrawals.show');
        Route::post('/withdrawals/{withdrawal}/approve', [AdminWithdrawalController::class, 'approve'])->name('withdrawals.approve');
        Route::post('/withdrawals/{withdrawal}/reject', [AdminWithdrawalController::class, 'reject'])->name('withdrawals.reject');

        /* Admin Profile */

        Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile', [AdminProfileController::class, 'update'])->name('profile.update');

        /* Admin Management */

        Route::resource('admins', AdminManagementController::class)->except(['show']);

        /* Skill Garage */

        Route::resource('faculties', FacultyController::class);
        Route::resource('tracks', TrackController::class);
        Route::resource('lectures', LectureController::class);

        Route::get('enrollments', [EnrollmentController::class, 'index'])
            ->name('enrollments.index');

        /* Business University */

        Route::resource('business-faculties', BusinessFacultyController::class)
            ->parameters(['business-faculties' => 'businessFaculty']);

        Route::resource('business-courses', BusinessCourseController::class)
            ->parameters(['business-courses' => 'businessCourse']);

        Route::resource('business-lectures', BusinessLectureController::class)
            ->parameters(['business-lectures' => 'businessLecture']);

        Route::get('business-enrollments', [BusinessEnrollmentController::class, 'index'])
            ->name('business-enrollments.index');
    });
});