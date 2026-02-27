<?php

use App\Http\Controllers\Auth\AcceptInviteController;
use App\Http\Controllers\Auth\RegisterInviteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('authed');
    }

    return redirect('login');
})->name('home');

Route::get('invites/accept/{token}', AcceptInviteController::class)->name('invites.accept');
Route::post('invites/{invite}/register', RegisterInviteController::class);

Route::middleware('auth')->group(function(){
    Route::get('authed', function (Request $request) {
        return redirect($request->user()->is_admin ? 'clinics' : 'clinic/dashboard');
    })->name('authed');
});

Route::get('/install', function () {
    if (!Schema::hasTable('migrations')) {
        Artisan::call('migrate', [
            '--force' => true,
        ]);

        Artisan::call('db:seed', [
            '--force' => true,
        ]);

        return nl2br(Artisan::output());
    }

    abort(404);
});

require __DIR__.'/settings.php';
