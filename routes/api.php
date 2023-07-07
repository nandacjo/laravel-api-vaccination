<?php

use App\Http\Controllers\Api\V1\Auth;
use App\Http\Controllers\Api\V1\Consultation;
use App\Http\Controllers\Api\V1\SpotController;
use App\Http\Controllers\Api\V1\VaccinationController;
use App\Http\Middleware\AuthApi;
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

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', [Auth::class, 'login']);
        Route::post('logout', [Auth::class, 'logout']);
    });

    Route::prefix('consultations')->group(function () {
        Route::get('', [Consultation::class, 'index']);
        Route::post('', [Consultation::class, 'requestConsultations']);
    });

    Route::prefix('spots')->middleware(AuthApi::class)->group(function(){
        Route::get('', [SpotController::class, 'spotVaccines']);
        Route::get('{spot_id}', [SpotController::class, 'spotDetail']);
    });

    Route::prefix('vaccinations')->middleware(AuthApi::class)->group(function(){
        Route::post('', [VaccinationController::class, 'registrasi']);
        Route::get('', [VaccinationController::class, 'getData']);
    });


});
