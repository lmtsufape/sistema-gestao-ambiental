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
use App\Http\Controllers\BoletoController;
use App\Http\Controllers\ContatoController;
use App\Http\Controllers\HistoricoController;
use App\Http\Controllers\EmpresaController;

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
})->name('welcome');

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
    Route::get('/requerimentos/{id}/visitas', [RequerimentoController::class, 'indexVisitasRequerimento'])->name('requerimento.visitas');

    Route::resource('usuarios', UserController::class);
    Route::get('/meu-perfil', [UserController::class, 'perfil'])->name('perfil');
    Route::resource('documentos', DocumentoController::class);
    Route::resource('requerimentos', RequerimentoController::class);
    Route::post('requerimentos/atribuir-analista', [RequerimentoController::class, 'atribuirAnalista'])->name('requerimentos.atribuir.analista');
    Route::get('requerimentos/{id}/editar-empresa', [RequerimentoController::class, 'editEmpresa'])->name('requerimentos.editar.empresa');
    Route::post('requerimentos/{id}/editar-empresa', [RequerimentoController::class, 'updateEmpresa'])->name('requerimentos.update.empresa');
    Route::get('requerimentos/{id}/setor/ajax-listar-cnaes', [SetorController::class, 'ajaxCnaes'])->name("ajax.listar.cnaes.editar");
    Route::get('empresas/{id}/historico', [HistoricoController::class, 'historicoEmpresa'])->name('historico.empresa');
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

    Route::get('/denuncias/index', [DenunciaController::class, 'index'])->name('denuncias.index');
    Route::get('/denuncias/imagens', [DenunciaController::class, 'imagensDenuncia'])->name('denuncias.imagens');
    Route::post("/denuncias/avaliar", [DenunciaController::class, 'avaliarDenuncia'])->name('denuncias.avaliar');
    Route::get('/{requerimento}/gerar/boleto_taxa_de_licenciamento_ambiental', [BoletoController::class, 'create'])->name('boleto.create');
    Route::resource('empresas', EmpresaController::class);

    Route::get('/documentos-padrao/licenca', [DocumentoController::class, 'documentosPadrao'])->name('documentos.default');
    Route::post('/denuncias/create/visita', [VisitaController::class, 'createVisitaDenuncia'])->name('denuncias.visita.create');
    Route::post('/denuncias/atribuir/analista', [DenunciaController::class, 'atribuirAnalistaDenuncia'])->name('denuncias.atribuir.analista');
});

Route::get('/denuncias/create', [DenunciaController::class, 'create'])->name('denuncias.create');
Route::post('/denuncias/store', [DenunciaController::class, 'store'])->name('denuncias.store');
Route::get('/denuncias/acompanhar', [DenunciaController::class, 'statusDenuncia'])->name('denuncias.acompanhar');
Route::get('/contato', [ContatoController::class, 'contato'])->name('contato');
Route::post('/contato/enviar', [ContatoController::class, 'enviar'])->name('enviar.mensagem');
Route::get("/setor/ajax-listar-cnaes", [SetorController::class, 'ajaxCnaes'])
    ->name("ajax.listar.cnaes");
Route::get('/status/requerimento', [EmpresaController::class, 'statusRequerimento'])->name('status.requerimento');
Route::get("/info/porte", [ContatoController::class, 'infoPorte'])->name('info.porte');


