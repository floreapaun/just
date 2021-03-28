<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\TrialController;
use App\Http\Controllers\CourtController;
use App\Http\Controllers\CrimeController;

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

Route::group(['prefix' => 'file'], function() {
  Route::post('/data', [FileController::class, 'data']);
  Route::post('/revoke', [FileController::class, 'revoke']);
  Route::post('/search', [FileController::class, 'search']);
  Route::post('/search/revoked', [FileController::class, 'revoked_search']);
});
Route::get('/files', [FileController::class, 'index']);
Route::get('/files/revoked', [FileController::class, 'revoked_index']);

Route::post('/trial/update', [TrialController::class, 'update']);
Route::post('/crimes/index', [CrimeController::class, 'index']);
Route::post('/courts/index', [CourtController::class, 'index']);
Route::post('/trials/courts', [CourtController::class, 'at_date']);

Route::group(['prefix' => 'court'], function() {
    Route::post('/update', [CourtController::class, 'update']);
    Route::post('/random', [CourtController::class, 'random']);
    Route::post('/store', [CourtController::class, 'store']);
    Route::post('/remove', [CourtController::class, 'destroy']);
    Route::post('/entry', [CourtController::class, 'entry']);
    Route::post('/new', [CourtController::class, 'new']);
});
