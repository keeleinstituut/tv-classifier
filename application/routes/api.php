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
Route::prefix('/classifier-values')
    ->controller(ClassifierValueController::class)
    ->whereUuid('id')
    ->group(function (): void {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
    });

Route::prefix('/sync/classifier-values')
    ->controller(ClassifierValueSyncController::class)
    ->whereUuid('id')
    ->withoutMiddleware(['throttle:api', 'auth:api'])
    ->group(function (): void {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
    });
