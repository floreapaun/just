<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\CourtController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/files/store', function () {
    return view('files.store');
});
Route::get('/file/{id}', function($id) {
    return view('file', ['id' => $id]);
});
Route::get('/courts', function () {
    return view('courts.index');
}); 
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/files', [FileController::class, 'index']); 
Route::get('/court', [CourtController::class, 'random']);
Route::prefix('/file')->group( function() {
    Route::post('/store', [FileController::class, 'store']);
});
