<?php

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\ClientController;

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

// Grupo de rutas protegidas
// Route::group(['middleware'=>'auth:api'], function(){
    
    //     // clients
    //     Route::resource('clients', Clientontroller::class);
    // });
    
    // v2
Route::post('register', [AuthController::class, 'store']);
//         ->name('user.store');
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group( function () {
    // Route::resource('clients', ClientController::class);
    Route::get('/clients', [ClientController::class, 'index']);
    Route::post('/clients', [ClientController::class, 'store']);
    Route::get('/clients/{id}', [ClientController::class, 'show']);
    Route::put('/clients/{id}', [ClientController::class, 'update']);
    Route::delete('/clients/{id}', [ClientController::class, 'delete']);
});