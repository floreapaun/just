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

Auth::routes();

Route::get('/', function () {
    return view('auth.login');
});
Route::get('/file/{id}', function ($id) {
    return view('file', ['id' => $id]);
})->name('file');
Route::get('/courts', function () {
    return view('courts.index');
})->name('courts'); 
Route::get('/files', function () {
    return view('files.index');
})->name('files'); 
Route::get('/revoked_files', function () {
    return view('files.revoked');
})->name('revoked_files'); 
Route::get('/about', function () {
    return view('about');
})->name('about'); 


Route::group(['middleware' => ['auth']], function() {
    Route::get('/files/store', function () {
        return view('files.store');
    })->name('file_store');
    Route::get('/courts/panel', function () {
        return view('courts.panel');
    })->name('courts_panel');
    Route::prefix('/file')->group( function() {
        Route::post('/store', [FileController::class, 'store']);
    });
});
