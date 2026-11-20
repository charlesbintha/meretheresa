<?php

use App\Http\Controllers\SchoolAuthController;
use App\Http\Controllers\SchoolController;
use App\Http\Middleware\SchoolAccess;
use Illuminate\Support\Facades\Route;

Route::get('/definir-mot-de-passe/{token}', [\App\Http\Controllers\SchoolPasswordSetupController::class,'show'])->middleware('throttle:30,1')->name('school.password.show');
Route::post('/definir-mot-de-passe', [\App\Http\Controllers\SchoolPasswordSetupController::class,'store'])->middleware('throttle:5,1')->name('school.password.store');

Route::middleware('guest')->group(function () {
    Route::get('/login', [SchoolAuthController::class, 'login'])->name('login');
    Route::post('/login', [SchoolAuthController::class, 'store'])->middleware('throttle:5,1');
});
Route::post('/logout', [SchoolAuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::middleware(['auth', SchoolAccess::class])->group(function () {
    Route::get('/', [SchoolController::class, 'index'])->name('dashboard');
    Route::get('/school-api/expenses', function (\Illuminate\Http\Request $r) { abort_unless($r->user()->canSchool('accounting.view'),403); return response()->json(app(\App\Services\SchoolExpenses::class)->state())->header('Cache-Control','no-store, private'); });
    Route::post('/school-api/expenses/{id}/documents', [\App\Http\Controllers\SchoolExpenseDocumentController::class,'store'])->middleware('throttle:30,1');
    Route::get('/school-api/expense-documents/{id}', [\App\Http\Controllers\SchoolExpenseDocumentController::class,'show']);
    Route::get('/school-api/accounting', function (\Illuminate\Http\Request $request) { abort_unless($request->user()->canSchool('accounting.view'),403); return response()->json(app(\App\Services\SchoolAccounting::class)->state((int)$request->query('yearId',0)))->header('Cache-Control','no-store, private'); });
    Route::get('/school-api/reports', [\App\Http\Controllers\SchoolReportController::class,'index']);
    Route::get('/school-api/reports/{id}', [\App\Http\Controllers\SchoolReportController::class,'show']);
    Route::post('/school-api/reports', [\App\Http\Controllers\SchoolReportController::class,'store'])->middleware('throttle:30,1');
    Route::get('/school-api/state', [SchoolController::class, 'state']);
    Route::post('/school-api/export', \App\Http\Controllers\SchoolExportController::class)->middleware('throttle:30,1');
    Route::post('/school-api/commands', [SchoolController::class, 'command'])->middleware('throttle:120,1');
});
