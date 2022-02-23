<?php

use App\Http\Controllers\Api\TokenController;
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
});

Route::post('/sanctum/token', [TokenController::class, 'create']);

Route::post('/teste/file', [XMLCoderController::class, 'teste'])->name('api.teste');
