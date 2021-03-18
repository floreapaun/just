<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\TrialController;
use App\Http\Controllers\CourtController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/file/data', [FileController::class, 'data']);
Route::post('/file/parts', [FileController::class, 'parts']);
Route::post('/file/trials', [FileController::class, 'trials']);
Route::post('/file/search', [FileController::class, 'search']);

Route::post('/trial/update', [TrialController::class, 'update']);
Route::post('/trials/courts', [TrialController::class, 'courts']);

Route::post('courts/index', [CourtController::class, 'index']);
Route::prefix('/court')->group(function() {
    Route::post('/update', [CourtController::class, 'update']);
    Route::post('/store', [CourtController::class, 'store']);
    Route::post('/remove', [CourtController::class, 'destroy']);
    Route::post('/entry', [CourtController::class, 'entry']);
});
