<?php

use App\Http\Controllers\Api\AnalistaController;
use App\Http\Controllers\Api\DenunciaController;
use App\Http\Controllers\Api\EmpresaController;
use App\Http\Controllers\Api\TokenController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VisitaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebServiceCaixa\XMLCoderController;

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

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/visitas', [VisitaController::class, 'index']);
    Route::get('/visitas/{id}', [VisitaController::class, 'get']);
    Route::get('/denuncias/{id}', [DenunciaController::class, 'get']);
    Route::get('/empresas/{id}', [EmpresaController::class, 'get']);
    Route::get('/users', [UserController::class, 'show']);
});

Route::post('/users/auth', [TokenController::class, 'create']);

Route::post('/teste/file', [XMLCoderController::class, 'teste'])->name('api.teste');
