<?php

use App\Http\Controllers\ClassifierValueController;
use App\Http\Controllers\ClassifierValueSyncController;
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

Route::get('/classifier-values', [ClassifierValueController::class, 'index']);
Route::get('/classifier-values/{id}', [ClassifierValueController::class, 'show'])->whereUuid('id');

Route::withoutMiddleware(['auth:api', 'throttle:api'])->group(function () {
    Route::get('/sync/classifier-values', [ClassifierValueSyncController::class, 'index']);
    Route::get('/sync/classifier-values/{id}', [ClassifierValueSyncController::class, 'show'])->whereUuid('id');
});
