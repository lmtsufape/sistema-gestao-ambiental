<?php


use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\CnaeController;
use App\Http\Controllers\SetorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RequerimentoController;
use App\Http\Controllers\ValorController;
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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/requerimentos/analista', [RequerimentoController::class, 'analista'])->name('requerimentos.analista');
    Route::post('/requerimentos/salvar-checklist', [RequerimentoController::class, 'storeChecklist'])->name('requerimento.checklist');
    Route::put('/requerimentos/update-checklist', [RequerimentoController::class, 'updateChecklist'])->name('requerimento.checklist.edit');
    Route::get('/requerimentos/{requerimento_id}/documentacao', [RequerimentoController::class, 'showRequerimentoDocumentacao'])->name('requerimento.documentacao');
    Route::post('/requerimentos/{requerimento_id}/enviar-documentos', [RequerimentoController::class, 'enviarDocumentos'])->name('requerimento.enviar.documentos');
    Route::get('/requerimentos/{requerimento_id}/documentacao/{documento_id}', [RequerimentoController::class, 'showDocumento'])->name('requerimento.documento');

    Route::resource('usuarios', UserController::class);
    Route::get('/meu-perfil', [UserController::class, 'perfil'])->name('perfil');
    Route::resource('documentos', DocumentoController::class);
    Route::resource('requerimentos', RequerimentoController::class);
    Route::post('requerimentos/atribuir-analista', [RequerimentoController::class, 'atribuirAnalista'])->name('requerimentos.atribuir.analista');
    Route::resource('setores', SetorController::class);
    Route::resource('cnaes', CnaeController::class);
    Route::get('/setores/{setor_id}/criar-cnae', [CnaeController::class, 'create'])->name('cnaes.create');
    Route::resource('valores', ValorController::class);
});

Route::get("/setor/ajax-listar-cnaes", [SetorController::class, 'ajaxCnaes'])
    ->name("ajax.listar.cnaes");
