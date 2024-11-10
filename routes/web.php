<?php

use App\Http\Controllers\AuditeeController;
use App\Http\Controllers\AuditorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IndicatorController;
use App\Http\Controllers\InstrumentController;
use App\Http\Controllers\MasterIndicatorController;
use App\Http\Controllers\MasterInstrumentController;
use App\Http\Controllers\MasterQuestionController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StandardController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('auth.authenticate');
Route::get('/survey', [SurveyController::class, 'index'])->name('survey.index');
Route::get('/survey/{instrument}', [SurveyController::class, 'show'])->name('survey.show');
Route::get('/survey/{instrument}/audit-results', [SurveyController::class, 'showAuditResults'])->name('survey.audit_results');
Route::post('/survey/{instrument}/audit-results', [SurveyController::class, 'storeAuditResults'])->name('survey.audit_results.store');
Route::get('/survey/{instrument}/audit-results/export', [SurveyController::class, 'exportAuditResults'])->name('survey.audit_results.export');
Route::get('/survey/{instrument}/compliance-results', [SurveyController::class, 'showComplianceResults'])->name('survey.compliance_results');
Route::post('/survey/{instrument}/compliance-results', [SurveyController::class, 'storeComplianceResults'])->name('survey.compliance_results.store');
Route::get('/survey/{instrument}/noncompliance-results', [SurveyController::class, 'showNoncomplianceResults'])->name('survey.noncompliance_results');
Route::post('/survey/{instrument}/noncompliance-results', [SurveyController::class, 'storeNoncomplianceResults'])->name('survey.noncompliance_results.store');
Route::get('/survey/{instrument}/ptk', [SurveyController::class, 'showPTK'])->name('survey.ptk');
Route::post('/survey/{instrument}/ptk', [SurveyController::class, 'storePTK'])->name('survey.ptk.store');
Route::get('/survey/{instrument}/ptp', [SurveyController::class, 'showPTP'])->name('survey.ptp');
Route::post('/survey/{instrument}/ptp', [SurveyController::class, 'storePTP'])->name('survey.ptp.store');
Route::post('/survey/{instrument}', [SurveyController::class, 'store'])->name('survey.store');
Route::post('/survey/{instrument}/process', [SurveyController::class, 'processAudit'])->name('survey.process');
Route::post('/survey/{instrument}/reject', [SurveyController::class, 'rejectAudit'])->name('survey.reject');
Route::post('/survey/{instrument}/complete', [SurveyController::class, 'completeAudit'])->name('survey.complete');
Route::get('/survey/{instrument}/report', [SurveyController::class, 'showReport'])->name('survey.report');
// Route::get('/survey/{instrument}/report/preview', [SurveyController::class, 'previewReport'])->name('survey.report.preview');
// Route::get('/survey/{instrument}/report/download', [SurveyController::class, 'downloadReport'])->name('survey.report.download');
Route::get('/report', [ReportController::class, 'index'])->name('report.index');
Route::post('/report/upload/{periode}/{program}', [ReportController::class, 'upload'])->name('report.upload');
Route::get('/report/cover/{periode}/{program}', [ReportController::class, 'cover'])->name('report.cover');
Route::get('/report/bab1/{periode}/{program}', [ReportController::class, 'bab1'])->name('report.bab1');
Route::get('/report/bab2/{periode}/{program}', [ReportController::class, 'bab2'])->name('report.bab2');
Route::get('/report/bab3/{periode}/{program}', [ReportController::class, 'bab3'])->name('report.bab3');
Route::get('/report/bab4/{periode}/{program}', [ReportController::class, 'bab4'])->name('report.bab4');
Route::get('/report/bab5/{periode}/{program}', [ReportController::class, 'bab5'])->name('report.bab5');
Route::get('/report/lampiran/{periode}/{program}', [ReportController::class, 'lampiran'])->name('report.lampiran');
Route::get('/report/full/{periode}/{program}', [ReportController::class, 'full'])->name('report.full');
Route::prefix('dashboard')->name('dashboard.')->middleware(['web', 'auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::prefix('master')->name('master.')->group(function () {
        Route::resource('/units', UnitController::class)->except('show')->names('units');
        Route::resource('/faculties', FacultyController::class)->except('show')->names('faculties');
        Route::resource('/departments', DepartmentController::class)->except('show')->names('departments');
        Route::resource('/programs', ProgramController::class)->except('show')->names('programs');
        Route::resource('/standards', StandardController::class)->except('show')->names('standards');
        Route::resource('/periodes', PeriodeController::class)->names('periodes');
        Route::post('/periodes/{periode}/add-member', [PeriodeController::class, 'addMember'])->name('periodes.add_member');
        Route::delete('/periodes/{periode}/delete-member/{auditor}', [PeriodeController::class, 'deleteMember'])->name('periodes.delete_member');
        Route::post('/periodes/{periode}/instruments', [InstrumentController::class, 'store'])->name('periodes.instruments.store');
        Route::get('/periodes/{periode}/instruments/{instrument}', [InstrumentController::class, 'show'])->name('periodes.instruments.show');
        Route::get('/periodes/{periode}/instruments/{instrument}/edit', [InstrumentController::class, 'edit'])->name('periodes.instruments.edit');
        Route::put('/periodes/{periode}/instruments/{instrument}', [InstrumentController::class, 'update'])->name('periodes.instruments.update');
        Route::put('/periodes/{periode}/instruments/{instrument}/area', [InstrumentController::class, 'updateArea'])->name('periodes.instruments.update.area');
        Route::delete('/periodes/{periode}/instruments/{instrument}', [InstrumentController::class, 'destroy'])->name('periodes.instruments.destroy');
        Route::post('/periodes/{periode}/instruments/{instrument}/indicators', [IndicatorController::class, 'store'])->name('periodes.instruments.indicators.store');
        Route::put('/periodes/{periode}/instruments/{instrument}/indicators/{indicator}', [IndicatorController::class, 'update'])->name('periodes.instruments.indicators.update');
        Route::delete('/periodes/{periode}/instruments/{instrument}/indicators/{indicator}', [IndicatorController::class, 'destroy'])->name('periodes.instruments.indicators.destroy');
        Route::post('/periodes/{periode}/instruments/{instrument}/indicators/{indicator}/questions', [QuestionController::class, 'store'])->name('periodes.instruments.indicators.questions.store');
        Route::get('/periodes/{periode}/instruments/{instrument}/indicators/{indicator}/questions/{question}/edit', [QuestionController::class, 'edit'])->name('periodes.instruments.indicators.questions.edit');
        Route::put('/periodes/{periode}/instruments/{instrument}/indicators/{indicator}/questions/{question}', [QuestionController::class, 'update'])->name('periodes.instruments.indicators.questions.update');
        Route::delete('/periodes/{periode}/instruments/{instrument}/indicators/{indicator}/questions/{question}', [QuestionController::class, 'destroy'])->name('periodes.instruments.indicators.questions.destroy');
        Route::resource('/instruments', MasterInstrumentController::class)->names('instruments');
        Route::resource('/indicators', MasterIndicatorController::class)->only('store', 'update', 'destroy')->names('indicators');
        Route::resource('/questions', MasterQuestionController::class)->only('store', 'update', 'destroy')->names('questions');
    });
    Route::prefix('users')->name('users.')->group(function () {
        Route::resource('/teams', TeamController::class)->except('show')->names('teams');
        Route::resource('/auditors', AuditorController::class)->except('show')->names('auditors');
        Route::resource('/auditees', AuditeeController::class)->except('show')->names('auditees')->parameters(['auditees' => 'user']);
    });
});
