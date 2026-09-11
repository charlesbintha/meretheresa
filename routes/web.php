<?php

use App\Http\Controllers\SchoolAuthController;
use App\Http\Controllers\SchoolController;
use App\Http\Middleware\SchoolAdmin;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [SchoolAuthController::class, 'login'])->name('login');
    Route::post('/login', [SchoolAuthController::class, 'store'])->middleware('throttle:5,1');
});
Route::post('/logout', [SchoolAuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::middleware(['auth', SchoolAdmin::class])->group(function () {
    Route::get('/', [SchoolController::class, 'index'])->name('dashboard');
    Route::get('/school-api/state', [SchoolController::class, 'state']);
    Route::post('/school-api/commands', [SchoolController::class, 'command'])->middleware('throttle:120,1');
});
