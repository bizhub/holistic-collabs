<?php

use App\Http\Controllers\Admin\Client\ClientIndexController;
use App\Http\Controllers\Admin\Clinic\ClinicIndexController;
use App\Http\Controllers\Admin\Clinic\CreateClinicController;
use App\Http\Controllers\Admin\Clinic\DeleteClinicController;
use App\Http\Controllers\Admin\Clinic\EditClinicController;
use App\Http\Controllers\Admin\Clinic\StoreClinicController;
use App\Http\Controllers\Admin\Clinic\UpdateClinicController;
use App\Http\Controllers\Admin\Commission\CommissionIndexController;
use App\Http\Controllers\Admin\Commission\UnpaidCommissionsController;
use App\Http\Controllers\Admin\Coupon\CouponIndexController;
use App\Http\Controllers\Admin\Coupon\DeleteCouponController;
use App\Http\Controllers\Admin\Dashboard\DashboardIndexController;
use App\Http\Controllers\Admin\Invite\CreateInviteController;
use App\Http\Controllers\Admin\Invite\DeleteInviteController;
use App\Http\Controllers\Admin\Invite\InviteIndexController;
use App\Http\Controllers\Admin\Invite\ResendInviteController;
use App\Http\Controllers\Admin\Invite\StoreInviteController;
use App\Http\Controllers\Admin\Order\OrderIndexController;
use App\Http\Controllers\Admin\Shopify\ShopifyCallbackController;
use App\Http\Controllers\Admin\Shopify\ShopifyConnectController;
use App\Http\Controllers\Admin\Shopify\ShopifyIndexController;
use App\Http\Controllers\Admin\Shopify\StartShopifyOAuthController;
use App\Http\Controllers\Admin\Shopify\SubscribeToShopifyWebhooksController;
use App\Http\Controllers\Admin\User\DeleteUserController;
use App\Http\Controllers\Admin\User\UserIndexController;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', DashboardIndexController::class)->name('dashboard');

Route::get('commissions', CommissionIndexController::class);
Route::get('commissions/{clinic}/unpaid', UnpaidCommissionsController::class);

Route::get('clinics', ClinicIndexController::class);
Route::get('clinics/create', CreateClinicController::class);
Route::post('clinics', StoreClinicController::class);
Route::get('clinics/{clinic}/edit', EditClinicController::class);
Route::put('clinics/{clinic}', UpdateClinicController::class);
Route::delete('clinics/{clinic}', DeleteClinicController::class);

Route::get('coupons', CouponIndexController::class);
Route::delete('coupons/{coupon}', DeleteCouponController::class);

Route::get('clients', ClientIndexController::class);

Route::get('users', UserIndexController::class);
Route::delete('users/{user}', DeleteUserController::class);

Route::get('invites', InviteIndexController::class);
Route::get('invites/create', CreateInviteController::class);
Route::get('invites/{invite}/resend', ResendInviteController::class);
Route::post('invites', StoreInviteController::class);
Route::delete('invites/{invite}', DeleteInviteController::class);

Route::get('orders', OrderIndexController::class);

Route::get('shopify', ShopifyIndexController::class);
Route::get('shopify/connect', ShopifyConnectController::class);
Route::get('shopify/webhooks/subscribe', SubscribeToShopifyWebhooksController::class);
Route::post('shopify', StartShopifyOAuthController::class);

Route::get('shopify/callback', ShopifyCallbackController::class);
