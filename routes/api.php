<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/fakultas', [ApiController::class, 'getFakultas']);
Route::get('/fakultas/{id}', [ApiController::class, 'getFakultasById']);
Route::get('/departments', [ApiController::class, 'getDepartment']);
Route::get('/departments/{id}', [ApiController::class, 'getDepartmentById']);
Route::get('/programs', [ApiController::class, 'getProgram']);
Route::get('/programs/{id}', [ApiController::class, 'getProgramById']);
Route::get('/programs/{id}/detail', [ApiController::class, 'getProgramByIdDetail']);
Route::get('/periodes', [ApiController::class, 'getPeriode']);
Route::get('/periodes/{id}', [ApiController::class, 'getPeriodeById']);
Route::get('/instruments', [ApiController::class, 'getInstrument']);
Route::get('/instruments/{id}', [ApiController::class, 'getInstrumentById']);
Route::get('/ami/{id}/{fakultas_id}', [ApiController::class, 'getAmiData']);
Route::get('/ami/{id}/program/{program_id}', [ApiController::class, 'getAmiDataByProgram']);
