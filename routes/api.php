<?php

use App\Http\Controllers;
use App\Http\Controllers\Api\CanceladoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\FacturaController;
use App\Http\Controllers\Api\LoteController;
use App\Http\Controllers\Api\TelefonoController;

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

    // Rutas lote
    Route::get('/lotes', [LoteController::class, 'index']);
    Route::post('/lotes', [LoteController::class, 'store']);
    Route::get('/lotes/{id}', [LoteController::class, 'show']);
    Route::put('/lotes/{id}', [LoteController::class, 'update']);
    Route::delete('/lotes/{id}', [LoteController::class, 'delete']);

    // Rutas telefono
    Route::get('/telefono', [TelefonoController::class, 'index']);
    Route::post('/telefono', [TelefonoController::class, 'store']);
    Route::get('/telefono/{id}', [TelefonoController::class, 'show']);
    Route::put('/telefono/{id}', [TelefonoController::class, 'update']);
    Route::delete('/telefono/{id}', [TelefonoController::class, 'delete']);
    
    // Rutas factura
    Route::get('/factura', [FacturaController::class, 'index']);
    Route::post('/factura', [FacturaController::class, 'store']);
    Route::get('/factura/{id}', [FacturaController::class, 'show']);
    Route::put('/factura/{id}', [FacturaController::class, 'update']);
    Route::delete('/factura/{id}', [FacturaController::class, 'delete']);
    
    // Rutas cancelado
    Route::get('/pay', [CanceladoController::class, 'index']);
    Route::post('/pay', [CanceladoController::class, 'store']);
    Route::get('/pay/{id}', [CanceladoController::class, 'show']);
    Route::put('/pay/{id}', [CanceladoController::class, 'update']);
    Route::delete('/pay/{id}', [CanceladoController::class, 'delete']);
});