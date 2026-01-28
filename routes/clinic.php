<?php

use App\Http\Controllers\Clinic\Dashboard\DashboardIndexController;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', DashboardIndexController::class)->name('dashboard');
