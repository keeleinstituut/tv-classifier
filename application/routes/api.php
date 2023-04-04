<?php

use App\Http\Controllers\ClassifierValueController;
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

Route::get('/v1/classifier-values', [ClassifierValueController::class, 'index']);
Route::get('/v1/classifier-values/{id}', [ClassifierValueController::class, 'get']);
