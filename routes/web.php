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
use App\Http\Controllers\FichaAnaliseController;
use App\Http\Controllers\LaudoTecnicoController;
use App\Http\Controllers\NotificacaoController;
use App\Http\Controllers\SolicitacaoMudaController;
use App\Http\Controllers\LicencaController;
use App\Http\Controllers\SolicitacaoPodaController;
use App\Http\Controllers\NoticiaController;


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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [function () {
    return redirect(route('requerimentos.index'));
}])->name('dashboard');

Route::get('/noticias/{titulo}', [NoticiaController::class, 'visualizar'])->name('noticias.visualizar');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/boletos', [BoletoController::class, 'index'])->name('boletos.index');

    Route::get('/requerimentos/analista', [RequerimentoController::class, 'analista'])->name('requerimentos.analista');
    Route::post('/requerimentos/salvar-checklist', [RequerimentoController::class, 'storeChecklist'])->name('requerimento.checklist');
    Route::put('/requerimentos/update-checklist', [RequerimentoController::class, 'updateChecklist'])->name('requerimento.checklist.edit');
    Route::get('/requerimentos/{requerimento_id}/documentacao', [RequerimentoController::class, 'showRequerimentoDocumentacao'])->name('requerimento.documentacao');
    Route::post('/requerimentos/{requerimento_id}/enviar-documentos', [RequerimentoController::class, 'enviarDocumentos'])->name('requerimento.enviar.documentos');
    Route::post('/requerimentos/{requerimento_id}/analisar-documentos', [RequerimentoController::class, 'analisarDocumentos'])->name('requerimento.analisar.documentos');
    Route::get('/requerimentos/{requerimento_id}/documentacao/{documento_id}', [RequerimentoController::class, 'showDocumento'])->name('requerimento.documento');
    Route::get('/requerimentos/{id}/visitas', [RequerimentoController::class, 'indexVisitasRequerimento'])->name('requerimento.visitas');
    Route::get('/requerimentos/{requerimento_id}/visitas/{visita_id}/edit', [RequerimentoController::class, 'requerimentoVisitasEdit'])->name('requerimento.visitas.edit');

    Route::put('usuarios/atualizar-endereco', [UserController::class, 'atualizarEndereco'])->name('usuarios.atualizar.endereco');
    Route::put('usuarios/atualizar-dados-basicos', [UserController::class, 'atualizarDadosBasicos'])->name('usuarios.dados');
    Route::resource('usuarios', UserController::class);
    Route::get('/meu-perfil', [UserController::class, 'perfil'])->name('perfil');
    Route::resource('documentos', DocumentoController::class);
    Route::resource('requerimentos', RequerimentoController::class);
    Route::post('requerimentos/atribuir-analista', [RequerimentoController::class, 'atribuirAnalista'])->name('requerimentos.atribuir.analista');
    Route::get('requerimentos/{id}/editar-empresa', [RequerimentoController::class, 'editEmpresa'])->name('requerimentos.editar.empresa');
    Route::post('requerimentos/{id}/editar-empresa', [RequerimentoController::class, 'updateEmpresa'])->name('requerimentos.update.empresa');
    Route::get('requerimentos/{id}/setor/ajax-listar-cnaes', [SetorController::class, 'ajaxCnaes'])->name("ajax.listar.cnaes.editar");
    Route::post('requerimentos/{id}/atribuir-potencial-poluidor', [RequerimentoController::class, 'atribuirPotencialPoluidor'])->name('requerimentos.atribuir.potencial.poluidor');

    Route::get('/visitas/baixar-relatorio', [VisitaController::class, 'gerarRelatorioVisitas'])->name('gerar.pdf.visitas');
    Route::get('empresas/{id}/historico', [HistoricoController::class, 'historicoEmpresa'])->name('historico.empresa');
    Route::resource('setores', SetorController::class);
    Route::resource('cnaes', CnaeController::class);
    Route::get('/setores/{setor_id}/criar-cnae', [CnaeController::class, 'create'])->name('cnaes.create');
    Route::resource('valores', ValorController::class);
    Route::resource('visitas', VisitaController::class);
    Route::get('/visitas/{visita_id}/requerimento/{requerimento_id}/ver', [RequerimentoController::class, 'verRequerimentoVisita'])->name('visitas.requerimento.show');
    

    Route::get('/{visita}/relatorio', [RelatorioController::class, 'create'])->name('relatorios.create');
    Route::post('/relatorio/store', [RelatorioController::class, 'store'])->name('relatorios.store');
    Route::get('/relatorio/{relatorio}/edit', [RelatorioController::class, 'edit'])->name('relatorios.edit');
    Route::put('/relatorio/{relatorio}/update', [RelatorioController::class, 'update'])->name('relatorios.update');
    Route::get('/relatorio/{relatorio}/show', [RelatorioController::class, 'show'])->name('relatorios.show');
    Route::post('/relatorio/{relatorio}/resultado', [RelatorioController::class, 'resultado'])->name('relatorios.resultado');

    Route::resource('empresas.notificacoes', NotificacaoController::class)
        ->shallow()
        ->parameters(['notificacoes' => 'notificacao']);
    Route::get('/notificacoes-get', [NotificacaoController::class, 'get'])->name('notificacoes.get');

    Route::get('/denuncias/index', [DenunciaController::class, 'index'])->name('denuncias.index');
    Route::get('/denuncias/imagens', [DenunciaController::class, 'imagensDenuncia'])->name('denuncias.imagens');
    Route::post("/denuncias/avaliar", [DenunciaController::class, 'avaliarDenuncia'])->name('denuncias.avaliar');
    Route::get('/{requerimento}/gerar/boleto_taxa_de_licenciamento_ambiental', [BoletoController::class, 'create'])->name('boleto.create');
    Route::resource('empresas', EmpresaController::class);

    Route::get('/documentos-padrao/licenca', [DocumentoController::class, 'documentosPadrao'])->name('documentos.default');
    Route::post('/denuncias/create/visita', [VisitaController::class, 'createVisitaDenuncia'])->name('denuncias.visita.create');
    Route::post('/denuncias/atribuir/analista', [DenunciaController::class, 'atribuirAnalistaDenuncia'])->name('denuncias.atribuir.analista');

    Route::get('/solicitacoes/mudas/{solicitacao}/show', [SolicitacaoMudaController::class, 'show'])->name('mudas.show');
    Route::put('/solicitacoes/mudas/{solicitacao}/', [SolicitacaoMudaController::class, 'avaliar'])->name('mudas.avaliar');
    Route::get('/solicitacoes/mudas/{solicitacao}/edit', [SolicitacaoMudaController::class, 'edit'])->name('mudas.edit');
    Route::get('/solicitacoes/mudas/index', [SolicitacaoMudaController::class, 'index'])->name('mudas.index');
    Route::get('/solicitacoes/mudas/requerente/index', [SolicitacaoMudaController::class, 'requerenteIndex'])->name('mudas.requerente.index');

    Route::get('/solicitacoes/podas/{solicitacao}/show', [SolicitacaoPodaController::class, 'show'])->name('podas.show');
    Route::put('/solicitacoes/podas/{solicitacao}/', [SolicitacaoPodaController::class, 'avaliar'])->name('podas.avaliar');
    Route::get('/solicitacoes/podas/{solicitacao}/edit', [SolicitacaoPodaController::class, 'edit'])->name('podas.edit');
    Route::get('/solicitacoes/podas/index', [SolicitacaoPodaController::class, 'index'])->name('podas.index');
    Route::get('/solicitacoes/podas/requerente/index', [SolicitacaoPodaController::class, 'requerenteIndex'])->name('podas.requerente.index');
    Route::get('/solicitacoes/podas/{solicitacao}/ficha', [SolicitacaoPodaController::class, 'ficha'])->name('podas.ficha');
    Route::get('/solicitacoes/podas/{solicitacao}/laudo', [SolicitacaoPodaController::class, 'laudo'])->name('podas.laudo');
    Route::post('/solicitacoes/podas/{solicitacao}/laudo', [LaudoTecnicoController::class, 'store'])->name('podas.laudos.store');
    Route::post('/solicitacoes/podas/{solicitacao}/ficha', [FichaAnaliseController::class, 'store'])->name('podas.fichas.store');
    Route::get('/solicitacoes/podas/laudo/{laudo}', [LaudoTecnicoController::class, 'show'])->name('podas.laudos.show');
    Route::get('/solicitacoes/podas/ficha/{ficha}', [FichaAnaliseController::class, 'show'])->name('podas.fichas.show');
    Route::post('/solicitacoes/atribuir/analista', [SolicitacaoPodaController::class, 'atribuirAnalistaSolicitacao'])->name('solicitacoes.atribuir.analista');
    Route::post('/solicitacoes/create/visita', [VisitaController::class, 'createVisitaSolicitacaoPoda'])->name('solicitacoes.visita.create');

    Route::get('/solicitacoes/mudas/mostrar/{solicitacao}', [SolicitacaoMudaController::class, 'mostrar'])->name('mudas.mostrar');
    Route::get('/solicitacoes/mudas/status', [SolicitacaoMudaController::class, 'status'])->name('mudas.status');
    Route::get('/solicitacoes/mudas/documento/{id}', [SolicitacaoMudaController::class, 'documento'])->name('mudas.documento');
    Route::view('/solicitacoes/mudas/create', '/solicitacoes/mudas/requerente/create')->name('mudas.create');
    Route::post('/solicitacoes/mudas', [SolicitacaoMudaController::class, 'store'])->name('mudas.store');

    Route::get('/solicitacoes/podas/mostrar/{solicitacao}', [SolicitacaoPodaController::class, 'mostrar'])->name('podas.mostrar');
    Route::get('/solicitacoes/podas/status', [SolicitacaoPodaController::class, 'status'])->name('podas.status');
    Route::view('/solicitacoes/podas/create', '/solicitacoes/podas/requerente/create')->name('podas.create');
    Route::post('/solicitacoes/podas', [SolicitacaoPodaController::class, 'store'])->name('podas.store');

    Route::get('/{requerimento}/licenca/create', [LicencaController::class, 'create'])->name('licenca.create');
    Route::post('/licenca/store', [LicencaController::class, 'store'])->name('licenca.store');
    Route::get('/licenca/{licenca}/show', [LicencaController::class, 'show'])->name('licenca.show');
    Route::get('{visita}/licenca/{licenca}', [LicencaController::class, 'revisar'])->name('licenca.revisar');
    Route::put('/licenca/{licenca}/atualizar', [LicencaController::class, 'update'])->name('licenca.update');
    Route::put('/licenca/{licenca}/salvar-revisao/{visita}', [LicencaController::class, 'salvar_revisao'])->name('licenca.salvar.revisao');

    Route::resource('noticias', NoticiaController::class);
});

Route::get('/denuncias/create', [DenunciaController::class, 'create'])->name('denuncias.create');
Route::post('/denuncias/store', [DenunciaController::class, 'store'])->name('denuncias.store');
Route::get('/denuncias/acompanhar', [DenunciaController::class, 'statusDenuncia'])->name('denuncias.acompanhar');
Route::get('/denuncias-get', [DenunciaController::class, 'get'])->name('denuncias.get');
Route::get('/contato', [ContatoController::class, 'contato'])->name('contato');
Route::post('/contato/enviar', [ContatoController::class, 'enviar'])->name('enviar.mensagem');
Route::get("/setor/ajax-listar-cnaes", [SetorController::class, 'ajaxCnaes'])
    ->name("ajax.listar.cnaes");
Route::get('/status/requerimento', [EmpresaController::class, 'statusRequerimento'])->name('status.requerimento');
Route::get("/info/porte", [ContatoController::class, 'infoPorte'])->name('info.porte');
Route::get('/sobre', [ContatoController::class, 'sobre'])->name('sobre');
Route::get('/legislacao', [ContatoController::class, 'legislacao'])->name('legislacao');
