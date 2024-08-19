<?php

use App\Http\Controllers\AuditeeController;
use App\Http\Controllers\AuditorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IndicatorController;
use App\Http\Controllers\InstrumentController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\StandardController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
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
        Route::resource('/units', UnitController::class)->except('show')->names('units');
        Route::resource('/standards', StandardController::class)->except('show')->names('standards');
        Route::resource('/periodes', PeriodeController::class)->names('periodes');
        Route::post('/periodes/{periode}/add_member', [PeriodeController::class, 'add_member'])->name('periodes.add_member');
        Route::delete('/periodes/{periode}/delete_member/{auditor}', [PeriodeController::class, 'delete_member'])->name('periodes.delete_member');
        Route::resource('/instruments', InstrumentController::class)->except('index, show, edit')->names('instruments');
        Route::resource('/indicators', IndicatorController::class)->except('index, show, edit')->names('indicators');
        Route::resource('/questions', QuestionController::class)->except('index', 'show')->names('questions');
    });
    Route::prefix('users')->name('users.')->group(function () {
        Route::resource('/auditors', AuditorController::class)->except('show')->names('auditors');
        Route::resource('/auditees', AuditeeController::class)->except('show')->names('auditees');
    });
});
