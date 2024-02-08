<?php

use App\Http\Controllers\MetricsController;
use App\Http\Controllers\TopMetricsController;
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
Route::get('top', [TopMetricsController::class, 'index']);
Route::get('metrics/{days}', [MetricsController::class, 'get']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
