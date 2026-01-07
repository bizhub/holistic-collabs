<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('authed');
    }

    return redirect('login');
})->name('home');

Route::get('invites/accept/{token}', function(string $token){
    dd('Accept invite for ' . $token);
})->name('invites.accept');

Route::middleware('auth')->group(function(){
    Route::get('authed', function (Request $request) {
        return redirect($request->user()->is_admin ? 'dashboard' : 'clinic/dashboard');
    });
});

require __DIR__.'/settings.php';
