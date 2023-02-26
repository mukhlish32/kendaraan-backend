<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KendaraanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('login', [AuthController::class, 'login']);
Route::group([
    'middleware' => 'auth:api'
], function(){
    Route::post('data', [AuthController::class, 'data']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('register', [AuthController::class, 'register']);
    
    Route::prefix('kendaraan')->group(function() {
        Route::get('/show', [KendaraanController::class, 'showKendaraan']);
        Route::get('/show/{id}', [KendaraanController::class, 'showKendaraanById']);
        Route::post('/create', [KendaraanController::class, 'createKendaraan']);
        Route::post('/update', [KendaraanController::class, 'updateKendaraan']);

        Route::post('/delete', [KendaraanController::class, 'deleteKendaraan']);
        Route::post('/add_mobil', [KendaraanController::class, 'addMobilInKendaraan']);
        Route::post('/delete_mobil', [KendaraanController::class, 'deleteMobilInKendaraan']);
    });
});

