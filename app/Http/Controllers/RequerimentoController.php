<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequerimentoRequest;
use App\Models\Checklist;
use App\Models\Cnae;
use App\Models\Documento;
use App\Models\Empresa;
use App\Models\Historico;
use App\Models\ModificacaoCnae;
use App\Models\ModificacaoPorte;
use App\Models\Requerimento;
use App\Models\RequerimentoDocumento;
use App\Models\Setor;
use App\Models\User;
use App\Models\ValorRequerimento;
use App\Models\Visita;
use App\Models\WebServiceCaixa\ErrorRemessaException;
use App\Notifications\DocumentosAnalisadosNotification;
use App\Notifications\DocumentosEnviadosNotification;
use App\Notifications\DocumentosNotification;
use App\Notifications\DocumentosExigenciasAnalisadosNotification;
use App\Notifications\EmpresaModificadaNotification;
use App\Policies\UserPolicy;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use PDF;

class RequerimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index($filtro, Request $request)
    {
        $user = auth()->user();
        $requerimentosCancelados = collect();
        $requerimentosFinalizados = collect();
        if ($user->role == User::ROLE_ENUM['requerente']) {
            $requerimentos = auth()->user()->requerimentosRequerente()->orderBy('created_at', 'DESC')->paginate(8);
        } elseif ($user->role == User::ROLE_ENUM['analista']) {
                $requerimentos = Requerimento::where(function (Builder $query) use ($user) {
                    $query->where('analista_id', $user->id)
                        ->orwhere('analista_processo_id', $user->id);
                    })
                    ->where([['status', '!=', Requerimento::STATUS_ENUM['cancelada']], ['cancelada', false]])
                    ->orderBy('created_at', 'DESC')->paginate(20);
        } else {
            $requerimentos = Requerimento::where([['status', '!=', Requerimento::STATUS_ENUM['finalizada']], ['status', '!=', Requerimento::STATUS_ENUM['cancelada']], ['cancelada', false]])->orderBy('created_at', 'DESC')->paginate(20);
            $requerimentosFinalizados = Requerimento::where([['status', Requerimento::STATUS_ENUM['finalizada']], ['cancelada', false]])->orderBy('created_at', 'DESC')->paginate(20);
            $requerimentosCancelados = Requerimento::where('status', Requerimento::STATUS_ENUM['cancelada'])->orWhere('cancelada', true)->orderBy('created_at', 'DESC')->paginate(20);
        }
        switch ($filtro) {
            case 'atuais':
                break;
            case 'finalizados':
                $requerimentos = $requerimentosFinalizados;
                break;
            case 'cancelados':
                $requerimentos = $requerimentosCancelados;
                break;
        }
        $tipos = Requerimento::TIPO_ENUM;

        $busca = $request->buscar;  
        if($busca != null){
            $empresas = Empresa::where('nome', 'ilike', '%'. $busca .'%')->get();
            $empresas = $empresas->pluck('id');
            $requerimentos = Requerimento::whereIn('empresa_id', $empresas)->paginate(100);
        }

        $requerimento_documento = RequerimentoDocumento::all();

        return view('requerimento.index', compact('requerimentos', 'tipos', 'filtro', 'busca', 'requerimento_documento'));
    }

    /**
     * @throws AuthorizationException
     */
    public function indexVisitasRequerimento($id)
    {
        $requerimento = Requerimento::find($id);
        $this->authorize('requerimentoDocumentacao', $requerimento);
        $visitas = $requerimento->visitas;

        return view('requerimento.visitasRequerimento', compact('visitas', 'requerimento'));
    }

    /**
     * @throws AuthorizationException
     */
    public function requerimentoVisitasEdit($requerimento_id, $visita_id)
    {
        $this->authorize('isSecretario', User::class);
        $visita = Visita::find($visita_id);
        $requerimentos = Requerimento::where('status', Requerimento::STATUS_ENUM['documentos_aceitos'])->orderBy('created_at', 'ASC')->get();
        $requerimentos->push($visita->requerimento);
        $analistas = User::analistas();
        $verRequerimento = true;

        return view('visita.edit', compact('visita', 'requerimentos', 'analistas', 'verRequerimento'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RequerimentoRequest $request
     * @return RedirectResponse
     */
    public function store(RequerimentoRequest $request)
    {
        $request->validated();
        $empresa = Empresa::find($request->empresa);

        $requerimento = new Requerimento();
        $requerimento->tipo = $request->tipo;
        $requerimento->status = Requerimento::STATUS_ENUM['em_andamento'];
        $requerimento->empresa_id = $empresa->id;
        $requerimento->analista_id = $this->protocolistaComMenosRequerimentos()->id;
        $requerimento->status_empresa = $request->status_empresa;
        $requerimento->save();

        return redirect(route('requerimentos.index', 'atuais'))->with(['success' => 'Requerimento realizado com sucesso.']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return View
     * @throws AuthorizationException
     */
    public function show($id)
    {
        $requerimento = Requerimento::find($id);
        $this->authorize('view', $requerimento);
        $protocolistas = User::protocolistas();
        $analistas = User::analistas();
        $documentos = Documento::orderBy('nome')->get();
        $definir_valor = Requerimento::DEFINICAO_VALOR_ENUM;
        $requerimento_documento = RequerimentoDocumento::where('requerimento_id', $id)->get();
        if(empty($requerimento_documento)){
            return view('requerimento.show', compact('requerimento', 'protocolistas', 'analistas', 'documentos', 'definir_valor'));
        }
        else{
            return view('requerimento.show', compact('requerimento', 'protocolistas', 'analistas', 'documentos', 'definir_valor', 'requerimento_documento'));
        }
    }

    /**
     * @param $visita_id
     * @param $requerimento_id
     * @return View
     * @throws AuthorizationException
     */
    public function verRequerimentoVisita($visita_id, $requerimento_id)
    {
        $requerimento = Requerimento::find($requerimento_id);
        $this->authorize('view', $requerimento);
        $protocolistas = User::protocolistas();
        $documentos = Documento::orderBy('nome')->get();
        $visita = true;
        $definir_valor = Requerimento::DEFINICAO_VALOR_ENUM;
        $requerimento_documento = RequerimentoDocumento::where('requerimento_id', $requerimento_id)->get();

        if(empty($requerimento_documento)){
            return view('requerimento.show', compact('requerimento', 'protocolistas', 'documentos', 'visita', 'definir_valor'));
        }
        else{
            return view('requerimento.show', compact('requerimento', 'protocolistas', 'documentos', 'visita', 'definir_valor', 'requerimento_documento'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Cancela um requerimento.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(Request $request, int $id)
    {
        $requerimento = Requerimento::find($id);
        $this->authorize('delete', $requerimento);
        $userPolicy = new UserPolicy();
        if ($userPolicy->isSecretario(auth()->user())) {
            if ($requerimento->motivo_cancelamento == null) {
                $request->validate([
                    'motivo_cancelamento' => 'required',
                ]);
                $requerimento->cancelada = true;
                $requerimento->motivo_cancelamento = $request->motivo_cancelamento;
                $requerimento->update();

                return redirect()->back()->with(['success' => 'Requerimento cancelado com sucesso.']);
            } else {
                $requerimento->cancelada = false;
                $requerimento->motivo_cancelamento = null;
                $requerimento->update();

                return redirect()->back()->with(['success' => 'Cancelamento desfeito com sucesso.']);
            }
        } else {
            if ($requerimento->status == Requerimento::STATUS_ENUM['cancelada']) {
                if ($requerimento->documentos()->first() != null) {
                    $requerimento->status = Requerimento::STATUS_ENUM['documentos_requeridos'];
                } else {
                    $requerimento->status = Requerimento::STATUS_ENUM['em_andamento'];
                }
                $requerimento->update();

                return redirect()->back()->with(['success' => 'Cancelamento desfeito com sucesso.']);
            } else {
                if ($requerimento->status != Requerimento::STATUS_ENUM['requerida'] &&
                    $requerimento->status != Requerimento::STATUS_ENUM['em_andamento'] &&
                    $requerimento->status != Requerimento::STATUS_ENUM['documentos_requeridos']) {
                    return redirect()->back()->with(['error' => 'Este requerimento já está em andamento e não pode ser cancelado. Se deseja realmente cancelar o mesmo, contate a secretaria.']);
                }
                $requerimento->status = Requerimento::STATUS_ENUM['cancelada'];
                $requerimento->update();

                return redirect()->back()->with(['success' => 'Requerimento cancelado com sucesso.']);
            }
        }
    }

    /**
     * Atribui um analista a um requerimento.
     *
     * @param Request $request
     * @param $tipo
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function atribuirAnalista(Request $request, $tipo)
    {
        $this->authorize('isSecretario', User::class);
        $request->validate([
            'analista' => 'required',
            'requerimento' => 'required',
        ]);

        $analista = User::find($request->analista);
        $requerimento = Requerimento::find($request->requerimento);
        if ($requerimento->analista_id == null) {
            $requerimento->status = Requerimento::STATUS_ENUM['em_andamento'];
        }
        if ($tipo == 'protocolista') {
            $requerimento->analista_id = $analista->id;
        } else {
            $requerimento->analista_processo_id = $analista->id;
        }
        $requerimento->update();

        return redirect(route('requerimentos.index', 'atuais'))->with(['success' => 'Requerimento nº ' . $requerimento->id . ' atribuído com sucesso a ' . $analista->name]);
    }


    /**
     * Salva a lista de documentos para retirar a licença.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function storeChecklist(Request $request)
    {
        $request->validate([
            'licença' => 'required',
            'opcão_taxa_serviço' => 'required',
            'valor_da_taxa_de_serviço' => 'required_if:opcão_taxa_serviço,' . Requerimento::DEFINICAO_VALOR_ENUM['manual'],
            'valor_do_juros' => 'required_if:opcão_taxa_serviço,' . Requerimento::DEFINICAO_VALOR_ENUM['automatica_com_juros'],
        ]);

        if ($request->documentos == null) {
            return redirect()->back()->withErrors(['error' => 'Selecione os documentos que devem ser enviados pelo requerente.'])->withInput($request->all());
        }

        $requerimento = Requerimento::find($request->requerimento);
        if (!$requerimento->empresa->cnaes()->whereNotNull('potencial_poluidor')->exists() && $requerimento->potencial_poluidor_atribuido == null) {
            return redirect()->back()->withErrors(['error' => 'É necessário atribuir um potencial poluidor ao requerimento.'])->withInput($request->all());
        }
        $this->atribuirValor($request, $requerimento);

        foreach ($request->documentos as $documento_id) {
            $requerimento->documentos()->attach($documento_id);
            $documento = $requerimento->documentos()->where('documento_id', $documento_id)->first()->pivot;
            $documento->status = Checklist::STATUS_ENUM['nao_enviado'];
            $documento->update();
        }
        $requerimento->status = Requerimento::STATUS_ENUM['documentos_requeridos'];
        $requerimento->tipo_licenca = $request->input('licença');
        $requerimento->update();

        Notification::send($requerimento->empresa->user, new DocumentosNotification($requerimento, $requerimento->documentos, 'Documentos requeridos'));

        if ($requerimento->valor != 0) {
            try {
                $boletoController = new BoletoController();
                $boletoController->boleto($requerimento);
            } catch (ErrorRemessaException $e) {
                return redirect()->back()
                    ->with(['success' => 'Checklist salva com sucesso, aguarde o requerente enviar os documentos.'])
                    ->withErrors(['error' => 'Erro na geração do boleto: ' . $e->getMessage()])
                    ->withInput();
            }
        }

        return redirect(route('requerimentos.show', ['requerimento' => $requerimento->id]))->with(['success' => 'Checklist salva com sucesso, aguarde o requerente enviar os documentos.']);
    }

    /**
     * Editar a lista de documentos para retirar a licença.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function updateChecklist(Request $request)
    {
        $request->validate([
            'licença' => 'required',
        ]);

        if ($request->documentos == null) {
            return redirect()->back()->withErrors(['error' => 'Selecione os documentos que devem ser enviados pelo requerente.'])->withInput($request->all());
        }

        $requerimento = Requerimento::find($request->requerimento);
        $documentos_requerimento = $requerimento->documentos->pluck('id')->all();
        $documentos_view = $request->documentos;
        $documentos_desmarcados = array_diff($documentos_requerimento, $documentos_view);
        $caminhos_desmarcados = $requerimento->documentos()->whereIn('documento_id', $documentos_desmarcados)->where('status', '!=', Checklist::STATUS_ENUM['nao_enviado'])->withPivot('caminho')->get()->pluck('pivot.caminho');
        $requerimento->documentos()->detach($documentos_desmarcados);
        foreach ($caminhos_desmarcados as $caminho) {
            delete_file($caminho);
        }
        $documentos_marcados = array_diff($documentos_view, $documentos_requerimento);
        $requerimento->documentos()->attach($documentos_marcados, ['status' => Checklist::STATUS_ENUM['nao_enviado']]);
        $requerimento->status = Requerimento::STATUS_ENUM['documentos_requeridos'];
        $requerimento->tipo_licenca = $request->input('licença');
        $requerimento->update();
        $requerimento->refresh();
        Notification::send($requerimento->empresa->user, new DocumentosNotification($requerimento, $requerimento->documentos, 'Alteração dos documentos requeridos'));

        return redirect(route('requerimentos.show', ['requerimento' => $requerimento->id]))->with(['success' => 'Checklist atualizada com sucesso, aguarde o requerente enviar os documentos.']);
    }

    /**
     * Atualiza o valor do requerimento, assim como o boleto.
     *
     * @param Requerimento $requerimento
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function updateValor(Requerimento $requerimento, Request $request)
    {
        $this->authorize('isSecretarioOrProtocolista', auth()->user());
        $request->validate([
            'opcão_taxa_serviço' => 'required',
            'valor_da_taxa_de_serviço' => 'required_if:opcão_taxa_serviço,' . Requerimento::DEFINICAO_VALOR_ENUM['manual'],
            'valor_do_juros' => 'required_if:opcão_taxa_serviço,' . Requerimento::DEFINICAO_VALOR_ENUM['automatica_com_juros'],
        ]);
        $boleto = $requerimento->boletos->last();
        if (! is_null($boleto) && 3 == $boleto->status_pagamento) {
            return redirect()->back()->with('error', 'Boleto já pago, não é possível alterar o boleto.');
        }
        if ($request->input('opcão_taxa_serviço') == Requerimento::DEFINICAO_VALOR_ENUM['manual'] && $request->input('valor_da_taxa_de_serviço') == 0) {
            return redirect()->back()->with('error', 'O valor do requerimento não pode ser 0.');
        }
        if (!$requerimento->empresa->cnaes()->whereNotNull('potencial_poluidor')->exists() && $requerimento->potencial_poluidor_atribuido == null) {
            return redirect()->back()->withErrors(['error' => 'É necessário atribuir um potencial poluidor ao requerimento.'])->withInput($request->all());
        }
        $this->atribuirValor($request, $requerimento);
        $requerimento->save();
        try {
            $boletoController = new BoletoController();
            $boletoController->boleto($requerimento);
            return redirect()->back()->with('success', 'Valor do requerimento e boleto atualizados com sucesso.');
        } catch (ErrorRemessaException $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Erro na geração do boleto: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Atribui o valor do requerimento que deve ser pago.
     *
     * @param Request $request
     * @param Requerimento $requerimento
     * @return void
     */
    private function atribuirValor(Request $request, Requerimento $requerimento)
    {
        $tipoLicenca = $request->input('licença') ?: $requerimento->tipo_licenca;
        $valor = null;
        $cnae_maior_poluidor = $requerimento->empresa->cnaes()->whereNotNull('potencial_poluidor')->orderBy('potencial_poluidor', 'desc')->first();
        if ($cnae_maior_poluidor == null) {
            $maiorPotencialPoluidor = $requerimento->potencial_poluidor_atribuido;
        } else {
            $maiorPotencialPoluidor = $cnae_maior_poluidor->potencial_poluidor;
        }

        switch ($request->input('opcão_taxa_serviço')) {
            case Requerimento::DEFINICAO_VALOR_ENUM['manual']:
                $valor = $request->input('valor_da_taxa_de_serviço');
                $requerimento->valor_juros = null;
                break;
            case Requerimento::DEFINICAO_VALOR_ENUM['automatica']:
                $valorRequerimento = ValorRequerimento::where([['porte', $requerimento->empresa->porte], ['potencial_poluidor', $maiorPotencialPoluidor], ['tipo_de_licenca', $tipoLicenca]])->first();
                $requerimento->valor_juros = null;
                $valor = $valorRequerimento != null ? $valorRequerimento->valor : null;
                break;
            case Requerimento::DEFINICAO_VALOR_ENUM['automatica_com_juros']:
                $valorRequerimento = ValorRequerimento::where([['porte', $requerimento->empresa->porte], ['potencial_poluidor', $maiorPotencialPoluidor], ['tipo_de_licenca', $tipoLicenca]])->first();
                $requerimento->valor_juros = $request->valor_do_juros;
                $valor = $valorRequerimento != null ? $valorRequerimento->valor + ($valorRequerimento->valor * ($request->valor_do_juros / 100)) : null;
                break;
        }

        $requerimento->definicao_valor = $request->input('opcão_taxa_serviço');
        $requerimento->valor = $valor;
    }

    /**
     * Checa se é a primeira licença do usuário.
     *
     * @return bool
     */
    private function primeiroRequerimento()
    {
        if (auth()->user()->role == User::ROLE_ENUM['requerente']) {
            return ! auth()->user()->requerimentosRequerente()->exists();
        }

        return false;
    }

    /**
     * @throws AuthorizationException
     */
    public function showExigenciasDocumentacao($id)
    {
        $requerimento = Requerimento::find($id);
        $this->authorize('verDocumentacao', $requerimento);
        $requerimento_documento = RequerimentoDocumento::where('requerimento_id', $id)->get();
        $status = RequerimentoDocumento::STATUS_ENUM;
        $documentoIds = $requerimento_documento->pluck('documento_id');
        $documentos = Documento::whereIn('id', $documentoIds)->get();
        // dd($documentos);
        if(count($documentos) > 0){
            if (auth()->user()->role == User::ROLE_ENUM['analista'] || auth()->user()->role == User::ROLE_ENUM['secretario']) {
                return view('requerimento.analise-exigencias-documentos', compact('requerimento', 'documentos', 'status', 'requerimento_documento'));
            }

            return view('requerimento.exigencias-documentos', compact('requerimento', 'documentos', 'status', 'requerimento_documento'));
        }
        else{
            $requerimento_documento_outro = $requerimento_documento->whereNotNull('nome_outro_documento')->first();
            if (auth()->user()->role == User::ROLE_ENUM['analista'] || auth()->user()->role == User::ROLE_ENUM['secretario']) {
                return view('requerimento.analise-exigencias-documentos', compact('requerimento', 'status', 'requerimento_documento_outro'));
            }

            return view('requerimento.exigencias-documentos', compact('requerimento', 'status', 'requerimento_documento_outro'));
        }
    }

     /**
     * @throws AuthorizationException
     */
    public function enviarExigenciasDocumentos(Request $request)
    {   
        $requerimento = Requerimento::find($request->requerimento_id);
        $this->authorize('requerimentoDocumentacao', $requerimento);

        if ($request->documentos == null && $request->outros_documentos == null) {
            return redirect()->back()->withErrors(['error' => 'Anexe os documentos que devem ser enviados.'])->withInput($request->all());
        }  

        if($request->documentos != null){
            foreach ($request->documentos as $documentoId => $documento) {
                $requerimentoDocumento = RequerimentoDocumento::where([['requerimento_id', $request->requerimento_id],['documento_id', $documentoId]])->first();
                $requerimentoDocumento->status = RequerimentoDocumento::STATUS_ENUM['enviado'];
                $requerimentoDocumento->anexo_arquivo = $documento->store("documentos/exigencias/{$requerimento->id}"); 
                $requerimentoDocumento->update();
            }
        }
        if($request->outros_documentos != null){
            foreach ($request->outros_documentos as $documento) {
                $requerimentoDocumento = RequerimentoDocumento::where('requerimento_id', $request->requerimento_id)->whereNotNull('nome_outro_documento')->first();
                $requerimentoDocumento->status = RequerimentoDocumento::STATUS_ENUM['enviado'];
                $requerimentoDocumento->arquivo_outro_documento = $documento->store("documentos/exigencias/{$requerimento->id}"); 
                $requerimentoDocumento->update();
            }
        }

        Notification::send($requerimento->protocolista, new DocumentosEnviadosNotification($requerimento, 'Exigências enviados'));

        return redirect(route('requerimentos.index', 'atuais'))->with(['success' => 'Exigências enviadas com sucesso. Aguarde o resultado da avaliação dos documentos.']);
    }

    public function analisarExigenciasDocumentos(Request $request)
    {   
       
        $data = $request->all();
        // dd($data);
        if ($request->documentos_id == null && $request->outros_documentos_id == null) {
            return redirect()->back()->withErrors(['error' => 'Envie o parecer dos documentos que devem ser analisados.'])->withInput($request->all());
        }

        $id = 0;
        $requerimento = Requerimento::find($request->requerimento_id);
        $documentos = Documento::all();
        $requerimento_documento_all = RequerimentoDocumento::where('requerimento_id', $request->requerimento_id)->get();

        if($request->outros_documentos_id != null && $request->documentos_id != null){
            foreach($request->outros_documentos_id as $outro_id){
                $requerimento_documento = RequerimentoDocumento::find($outro_id);
                if ($requerimento_documento->status != RequerimentoDocumento::STATUS_ENUM['nao_enviado']) {
                    $requerimento_documento->status = $data['analise_outro' . $requerimento_documento->id];
                    if ($data['comentario_outro_' . $requerimento_documento->id] != null) {
                        $requerimento_documento->comentario_outro_documento = $data['comentario_outro_' . $requerimento_documento->id];
                    } else {
                        $requerimento_documento->comentario_outro_documento = null;
                    }
                    $requerimento_documento->update();
                }
            }
            foreach($request->documentos_id as $documento_id){
                $requerimento_documento = RequerimentoDocumento::where('documento_id', $documento_id)->first();
                if ($requerimento_documento->status != RequerimentoDocumento::STATUS_ENUM['nao_enviado']) {
                    $requerimento_documento->status = $data['analise_' . $documento_id];
                    if ($data['comentario_' . $documento_id] != null) {
                        $requerimento_documento->comentario_anexo = $data['comentario_' . $documento_id];
                    } else {
                        $requerimento_documento->comentario_anexo = null;
                    }
                    $requerimento_documento->update();
                }
            }

            if ($requerimento_documento->where('status', RequerimentoDocumento::STATUS_ENUM['recusado'])->first() != null) {
                Notification::send($requerimento->empresa->user, new DocumentosExigenciasAnalisadosNotification($requerimento, $requerimento_documento_all, $documentos, 'Documentos recusados'));
            } else {
                Notification::send($requerimento->empresa->user, new DocumentosExigenciasAnalisadosNotification($requerimento, $requerimento_documento_all, $documentos, 'Documentos aceitos'));
            }

            $requerimento_documento->update();

            return redirect(route('requerimentos.index', 'atuais'))->with(['success' => 'Análise enviada com sucesso.']);

        }


        if($request->documentos_id != null && $request->outros_documentos_id == null){
            foreach ($request->documentos_id as $documento_id) {
                $requerimento_documento = RequerimentoDocumento::where('documento_id', $documento_id)->first();
                if ($requerimento_documento->status != RequerimentoDocumento::STATUS_ENUM['nao_enviado']) {
                    $requerimento_documento->status = $data['analise_' . $documento_id];
                    if ($data['comentario_' . $documento_id] != null) {
                        $requerimento_documento->comentario_anexo = $data['comentario_' . $documento_id];
                    } else {
                        $requerimento_documento->comentario_anexo = null;
                    }
                    $requerimento_documento->update();
                    $id++;
                }
            }

            if ($requerimento_documento->where('status', RequerimentoDocumento::STATUS_ENUM['recusado'])->first() != null) {
                Notification::send($requerimento->empresa->user, new DocumentosExigenciasAnalisadosNotification($requerimento, $requerimento_documento_all, $documentos, 'Documentos recusados'));
            } else {
                Notification::send($requerimento->empresa->user, new DocumentosExigenciasAnalisadosNotification($requerimento, $requerimento_documento_all, $documentos, 'Documentos aceitos'));
            }

            $requerimento_documento->update();

            return redirect(route('requerimentos.index', 'atuais'))->with(['success' => 'Análise enviada com sucesso.']);
        }


        // LOGICA PARA ANALISAR OUTROS DOCUMENTOS

        if($request->outros_documentos_id != null && $request->documentos_id == null){
            $requerimento_documento = RequerimentoDocumento::where('requerimento_id', $requerimento->id)->whereNotNull('arquivo_outro_documento')->first();
            $requerimento_documento->status = $data['analise_outro' . $requerimento_documento->id];
            if ($data['comentario_outro_' . $requerimento_documento->id] != null) {
                $requerimento_documento->comentario_outro_documento = $data['comentario_outro_' . $requerimento_documento->id];
            } else {
                $requerimento_documento->comentario_outro_documento = null;
            }
            $requerimento_documento->update();
       
            if ($requerimento_documento->where('status', RequerimentoDocumento::STATUS_ENUM['recusado'])->first() != null) {
                Notification::send($requerimento->empresa->user, new DocumentosExigenciasAnalisadosNotification($requerimento, $requerimento_documento_all, $documentos, 'Documentos recusados'));
            } else {
                Notification::send($requerimento->empresa->user, new DocumentosExigenciasAnalisadosNotification($requerimento, $requerimento_documento_all, $documentos, 'Documentos aceitos'));
            }
            
            $requerimento_documento->update();

            return redirect(route('requerimentos.index', 'atuais'))->with(['success' => 'Análise enviada com sucesso.']);
        }

       
    }

    /**
     * @throws AuthorizationException
     */
    public function showExigenciaDocumento($requerimento_id, $documento_id)
    {
        $requerimento = Requerimento::find($requerimento_id);
        $requerimento_documento = RequerimentoDocumento::where([['requerimento_id', $requerimento_id], ['documento_id', $documento_id]])->first();
        $this->authorize('verDocumentacao', $requerimento);
        
        return Storage::exists($requerimento_documento->anexo_arquivo) ? Storage::download($requerimento_documento->anexo_arquivo) : abort(404);
    }

     /**
     * @throws AuthorizationException
     */
    public function showExigenciaOutroDocumento($requerimento_id)
    {   
        $requerimento = Requerimento::find($requerimento_id);
        $requerimento_documento = RequerimentoDocumento::where('requerimento_id', $requerimento->id)->whereNotNull('arquivo_outro_documento')->first();
        
        $this->authorize('verDocumentacao', $requerimento);
        
        return Storage::exists($requerimento_documento->arquivo_outro_documento) ? Storage::download($requerimento_documento->arquivo_outro_documento) : abort(404);

    }

    /**
     * @throws AuthorizationException
     */
    public function showRequerimentoDocumentacao($id)
    {
        $requerimento = Requerimento::find($id);
        $this->authorize('verDocumentacao', $requerimento);
        $documentos = $requerimento->documentos;
        $status = Checklist::STATUS_ENUM;
        if (auth()->user()->role == User::ROLE_ENUM['analista']) {
            return view('requerimento.analise-documentos', compact('requerimento', 'documentos'));
        }

        return view('requerimento.envio-documentos', compact('requerimento', 'documentos', 'status'));
    }

    /**
     * @throws AuthorizationException
     */
    public function enviarDocumentos(Request $request)
    {
        $requerimento = Requerimento::find($request->requerimento_id);
        $this->authorize('requerimentoDocumentacao', $requerimento);

        if ($request->documentos == null) {
            return redirect()->back()->withErrors(['error' => 'Anexe os documentos que devem ser enviados.'])->withInput($request->all());
        }

        foreach ($request->documentos_id as $documento_id) {
            if (! $requerimento->documentos->contains('id', $documento_id)) {
                return redirect()->back()->withErrors(['error' => 'Anexe os documentos que devem ser enviados.'])->withInput($request->all());
            }
        }

        $id = 0;
        foreach ($request->documentos_id as $documento_id) {
            $documento = $requerimento->documentos()->where('documento_id', $documento_id)->first()->pivot;
            if ($documento->status == Checklist::STATUS_ENUM['nao_enviado'] || $documento->status == Checklist::STATUS_ENUM['recusado']) {
                delete_file($documento->caminho);
                $arquivo = $request->documentos[$id];
                $documento->caminho = $arquivo->store("documentos/requerimentos/{$requerimento->id}");
                $documento->comentario = null;
                $documento->status = Checklist::STATUS_ENUM['enviado'];
                $documento->update();
                $id++;
            }
        }
        $requerimento->status = Requerimento::STATUS_ENUM['documentos_enviados'];
        $requerimento->update();

        Notification::send($requerimento->protocolista, new DocumentosEnviadosNotification($requerimento, 'Documentos enviados'));

        return redirect(route('requerimentos.index', 'atuais'))->with(['success' => 'Documentação enviada com sucesso. Aguarde o resultado da avaliação dos documentos.']);
    }

    /**
     * @throws AuthorizationException
     */
    public function showDocumento($requerimento_id, $documento_id)
    {
        $requerimento = Requerimento::find($requerimento_id);
        $this->authorize('verDocumentacao', $requerimento);
        $documento = $requerimento->documentos()->where('documento_id', $documento_id)->first()->pivot;

        return Storage::exists($documento->caminho) ? Storage::download($documento->caminho) : abort(404);
    }

    public function analisarDocumentos(Request $request)
    {
        $data = $request->all();
        if ($request->documentos_id == null) {
            return redirect()->back()->withErrors(['error' => 'Envie o parecer dos documentos que devem ser analisados.'])->withInput($request->all());
        }

        $id = 0;
        $requerimento = Requerimento::find($request->requerimento_id);
        foreach ($request->documentos_id as $documento_id) {
            $documento = $requerimento->documentos()->where('documento_id', $documento_id)->first()->pivot;
            if ($documento->status != Checklist::STATUS_ENUM['nao_enviado']) {
                $documento->status = $data['analise_' . $documento_id];
                if ($data['comentario_' . $documento_id] != null) {
                    $documento->comentario = $data['comentario_' . $documento_id];
                } else {
                    $documento->comentario = null;
                }
                $documento->update();
                $id++;
            }
        }
        if ($requerimento->documentos()->where('status', Checklist::STATUS_ENUM['recusado'])->first() != null) {
            $requerimento->status = Requerimento::STATUS_ENUM['documentos_requeridos'];
            Notification::send($requerimento->empresa->user, new DocumentosAnalisadosNotification($requerimento, $requerimento->documentos, 'Documentos recusados'));
        } else {
            $requerimento->status = Requerimento::STATUS_ENUM['documentos_aceitos'];
            Notification::send($requerimento->empresa->user, new DocumentosAnalisadosNotification($requerimento, $requerimento->documentos, 'Documentos aceitos'));
        }
        $requerimento->update();

        return redirect(route('requerimentos.index', 'atuais'))->with(['success' => 'Análise enviada com sucesso.']);
    }

    /**
     * @throws AuthorizationException
     */
    public function editEmpresa($id)
    {
        $requerimento = Requerimento::find($id);
        $this->authorize('view', $requerimento);
        $setores = Setor::all();

        $setoresSelecionados = collect();
        foreach ($requerimento->empresa->cnaes as $cnae) {
            if (! $setoresSelecionados->contains($cnae->setor)) {
                $setoresSelecionados->push($cnae->setor);
            }
        }

        return view('empresa.edit-protocolista', compact('requerimento', 'setores', 'setoresSelecionados'));
    }

    public function updateEmpresa(Request $request, $id)
    {
        $requerimento = Requerimento::find($id);
        if ($request->cnaes_id == null) {
            return redirect()->back()->with(['error' => 'Selecione ao menos um cnae.']);
        }

        if ($this->possuiModificacaoCnae($request, $id) || $this->possuiModificacaoPorte($request, $id)) {
            $historico = new Historico();
            $historico->user_id = auth()->user()->id;
            $historico->empresa_id = $requerimento->empresa->id;
            $historico->save();
            if ($this->possuiModificacaoCnae($request, $id)) {
                foreach ($request->cnaes_id as $cnae_id) {
                    $cnae = Cnae::find($cnae_id);
                    if (! $requerimento->empresa->cnaes->contains($cnae)) {
                        $requerimento->empresa->cnaes()->attach($cnae);
                        $modifcacaoCnae = new ModificacaoCnae();
                        $modifcacaoCnae->novo = true;
                        $modifcacaoCnae->cnae_id = $cnae_id;
                        $modifcacaoCnae->historico_id = $historico->id;
                        $modifcacaoCnae->save();
                    } else {
                        $modifcacaoCnae = new ModificacaoCnae();
                        $modifcacaoCnae->novo = true;
                        $modifcacaoCnae->cnae_id = $cnae_id;
                        $modifcacaoCnae->historico_id = $historico->id;
                        $modifcacaoCnae->save();

                        $modifcacaoCnae3 = new ModificacaoCnae();
                        $modifcacaoCnae3->novo = false;
                        $modifcacaoCnae3->cnae_id = $cnae_id;
                        $modifcacaoCnae3->historico_id = $historico->id;
                        $modifcacaoCnae3->save();
                    }
                }
                foreach ($requerimento->empresa->cnaes as $cnae) {
                    if (! in_array($cnae->id, $request->cnaes_id)) {
                        $requerimento->empresa->cnaes()->detach($cnae);
                        $modifcacaoCnae2 = new ModificacaoCnae();
                        $modifcacaoCnae2->novo = false;
                        $modifcacaoCnae2->cnae_id = $cnae->id;
                        $modifcacaoCnae2->historico_id = $historico->id;
                        $modifcacaoCnae2->save();
                    }
                }
            }
            if ($this->possuiModificacaoPorte($request, $id)) {
                $modifcacaoPorte = new ModificacaoPorte();
                $modifcacaoPorte->porte_antigo = $requerimento->empresa->porte;
                $modifcacaoPorte->porte_atual = Empresa::PORTE_ENUM[$request->porte];
                $modifcacaoPorte->historico_id = $historico->id;
                $modifcacaoPorte->save();
                $requerimento->empresa->porte = Empresa::PORTE_ENUM[$request->porte];
                $requerimento->empresa->update();
            }
            Notification::send($requerimento->empresa->user, new EmpresaModificadaNotification($historico, 'Informações modificadas da empresa'));

            return redirect(route('requerimentos.show', ['requerimento' => $requerimento->id]))->with(['success' => 'Informações atualizadas com sucesso.']);
        }

        return redirect(route('requerimentos.show', ['requerimento' => $requerimento->id]))->with(['success' => 'Nenhuma modificação feita.']);
    }

    public function possuiModificacaoCnae($request, $id)
    {
        $requerimento = Requerimento::find($id);
        $cnaes_view = $request->cnaes_id;
        $empresa_canes = $requerimento->empresa->cnaes->pluck('id')->all();
        $cnaes_adicionados = array_diff($cnaes_view, $empresa_canes);
        $cnaes_removidos = array_diff($empresa_canes, $cnaes_view);
        $diff = array_merge($cnaes_adicionados, $cnaes_removidos);

        return ! empty($diff);
    }

    public function possuiModificacaoPorte($request, $id)
    {
        $requerimento = Requerimento::find($id);

        return $requerimento->empresa->porte != Empresa::PORTE_ENUM[$request->porte];
    }

    /**
     * Retorna o protocolista com menos requerimentos.
     *
     * @return User $protocolistaComMenosRequerimentos
     */
    private function protocolistaComMenosRequerimentos()
    {
        return User::whereIn('id', User::protocolistas()->pluck('id'))
            ->withCount(['requerimentos' => function (Builder $qry) {
                $qry->where('status', '<', Requerimento::STATUS_ENUM['documentos_aceitos']);
            }])
            ->orderBy('requerimentos_count', 'ASC')
            ->first();
    }

    public function atribuirPotencialPoluidor(Request $request, $id)
    {
        $this->authorize('isSecretarioOrProtocolista', User::class);

        $request->validate([
            'potencial_poluidor' => 'required',
        ]);

        $requerimento = Requerimento::find($id);
        $requerimento->potencial_poluidor_atribuido = Cnae::POTENCIAL_POLUIDOR_ENUM[$request->potencial_poluidor];
        $requerimento->update();

        if ($requerimento->valor != null) {
            $this->atribuirValor($request, $requerimento);
        }
        $requerimento->update();

        return redirect(route('requerimentos.show', ['requerimento' => $requerimento->id]))->with(['success' => 'Potencial poluidor atribuído ao requerimento com sucesso.']);
    }

    /**
     * Recupera o analista de processo atribuído ao requerimento se ele existir.
     *
     * @param Request $request id do requerimento
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function getAnalistaProcesso(Request $request)
    {
        $this->authorize('isSecretario', User::class);

        $requerimento = Requerimento::find($request->requerimento_id);

        $requerimentoInfo = [
            'id' => $requerimento->id,
            'analista_atribuido' => $requerimento->analistaProcesso ?: null,
        ];

        return response()->json($requerimentoInfo);
    }

    /**
     * Recupera o requerimento e gera o protocolo caso ele não exista.
     *
     * @param Request $request id do requerimento
     * @throws AuthorizationException
     */
    public function protocoloRequerimento($id)
    {
        $requerimento = Requerimento::find($id);
        $this->authorize('verProtocolo', $requerimento);
        if (! $requerimento->protocolo) {
            $requerimento->protocolo = $this->gerarProtocolo($requerimento);
            $requerimento->update();
        }

        return view('requerimento.protocolo', compact('requerimento'));
    }

    public function baixarProtocoloRequerimento($id)
    {
        $requerimento = Requerimento::find($id);
        $this->authorize('verProtocolo', $requerimento);
        $protocolo = PDF::loadview('pdf/protocolo', ['requerimento' => $requerimento]);
        return $protocolo->setPaper('a4')->stream('protocolo.pdf');
    }

    private function gerarProtocolo(Requerimento $requerimento)
    {
        $protocolo = intval(preg_replace(['/[ ]/', '/[^0-9]/'], ['', ''], $requerimento->created_at));
        $incre = 0;
        do {
            $protocolo += $incre;
            $check = Requerimento::where('protocolo', $protocolo)->exists();
            $incre += 1;
        } while ($check != null);

        return strval($protocolo);
    }
}
