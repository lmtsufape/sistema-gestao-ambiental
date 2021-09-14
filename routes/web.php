<?php


use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\CnaeController;
use App\Http\Controllers\VisitaController;
use App\Http\Controllers\DenunciaController;
use App\Http\Controllers\SetorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RequerimentoController;
use App\Http\Controllers\ValorController;
use App\Http\Controllers\RelatorioController;
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
    Route::post('/requerimentos/{requerimento_id}/analisar-documentos', [RequerimentoController::class, 'analisarDocumentos'])->name('requerimento.analisar.documentos');
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
    Route::resource('visitas', VisitaController::class);

    Route::get('/{visita}/relatorio', [RelatorioController::class, 'create'])->name('relatorios.create');
    Route::post('/relatorio/store', [RelatorioController::class, 'store'])->name('relatorios.store');
    Route::get('/relatorio/{relatorio}/edit', [RelatorioController::class, 'edit'])->name('relatorios.edit');
    Route::put('/relatorio/{relatorio}/update', [RelatorioController::class, 'update'])->name('relatorios.update');
    Route::get('/relatorio/{relatorio}/show', [RelatorioController::class, 'show'])->name('relatorios.show');
    Route::post('/relatorio/{relatorio}/resultado', [RelatorioController::class, 'resultado'])->name('relatorios.resultado');
});

Route::resource('denuncias', DenunciaController::class);

Route::get("/setor/ajax-listar-cnaes", [SetorController::class, 'ajaxCnaes'])
    ->name("ajax.listar.cnaes");
