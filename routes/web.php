<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

// hlm loginnya
Route::get('/', [PageController::class, 'login']);

// proses loginnya
Route::post('/login', [PageController::class, 'processLogin'])->name('login.process');

// hlm dashboardnya
Route::get('/dashboard', [PageController::class, 'dashboard']);

// hlm pengelolaannya
Route::get('/pengelolaan', [PageController::class, 'pengelolaan']);

//hlm profile
Route::get('/profile', [PageController::class, 'profile']);
