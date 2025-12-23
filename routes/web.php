<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
})->name('home');

Route::middleware('auth')->group(function(){
    Route::get('authed', function (Request $request) {
        return redirect($request->user()->is_admin ? 'dashboard' : 'clinic/dashboard');
    });
});

require __DIR__.'/settings.php';
