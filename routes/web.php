<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IndikatorController;
use App\Http\Controllers\InstrumenController;
use App\Http\Controllers\StandarController;
use App\Http\Controllers\SurveyController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('auth.authenticate');
Route::get('/survey', [SurveyController::class, 'index'])->name('survey.index');
Route::get('/survey/{instrumen}', [SurveyController::class, 'show'])->name('survey.show');
Route::prefix('dashboard')->name('dashboard.')->middleware(['web', 'auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::prefix('master')->name('master.')->group(function () {
        Route::resource('/standars', StandarController::class)->names('standars');
        Route::resource('/instrumens', InstrumenController::class)->names('instrumens');
        Route::post('/instrumens/{instrumen}/add_member', [InstrumenController::class, 'add_member'])->name('instrumens.add_member');
        Route::delete('/instrumens/{instrumen}/delete_member/{auditor}', [InstrumenController::class, 'delete_member'])->name('instrumens.delete_member');
        Route::resource('/indikators', IndikatorController::class)->only('show', 'store', 'update', 'destroy')->names('indikators');
    });
});
