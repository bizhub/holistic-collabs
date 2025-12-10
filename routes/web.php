<?php

use App\Http\Controllers\Client\ClientIndexController;
use App\Http\Controllers\Clinic\ClinicIndexController;
use App\Http\Controllers\Clinic\CreateClinicController;
use App\Http\Controllers\Clinic\DeleteClinicController;
use App\Http\Controllers\Clinic\StoreClinicController;
use App\Http\Controllers\Commission\CommissionIndexController;
use App\Http\Controllers\Coupon\CouponIndexController;
use App\Http\Controllers\Shopify\ShopifyCallbackController;
use App\Http\Controllers\Shopify\ShopifyConnectController;
use App\Http\Controllers\Shopify\ShopifyIndexController;
use App\Http\Controllers\Shopify\StartShopifyOAuthController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect('login');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function(){
    Route::get('commissions', CommissionIndexController::class);

    Route::get('clinics', ClinicIndexController::class);
    Route::get('clinics/create', CreateClinicController::class);
    Route::post('clinics', StoreClinicController::class);
    Route::delete('clinics/{clinic}', DeleteClinicController::class);

    Route::get('coupons', CouponIndexController::class);
    Route::get('clients', ClientIndexController::class);

    Route::get('shopify', ShopifyIndexController::class);
    Route::get('shopify/connect', ShopifyConnectController::class);
    Route::post('shopify', StartShopifyOAuthController::class);
});

Route::get('shopify/callback', ShopifyCallbackController::class);

require __DIR__.'/settings.php';
