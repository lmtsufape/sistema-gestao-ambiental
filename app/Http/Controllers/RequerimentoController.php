<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Requerimento;
use App\Models\Documento;
use App\Models\ValorRequerimento;
use App\Http\Requests\RequerimentoRequest;
use App\Models\Checklist;
use App\Models\Cnae;
use App\Models\Empresa;
use App\Models\Historico;
use App\Models\ModificacaoCnae;
use App\Models\ModificacaoPorte;
use App\Models\Setor;
use App\Models\Visita;
use Illuminate\Support\Facades\Notification;
use App\Notifications\DocumentosNotification;
use App\Notifications\DocumentosEnviadosNotification;
use App\Notifications\DocumentosAnalisadosNotification;
use App\Notifications\EmpresaModificadaNotification;
use App\Models\WebServiceCaixa\ErrorRemessaException;

class RequerimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($filtro)
    {
        $user = auth()->user();
        $requerimentos = collect();
        $requerimentosCancelados = collect();
        $requerimentosFinalizados = collect();
        if ($user->role == User::ROLE_ENUM['requerente']) {
            $requerimentos = auth()->user()->requerimentosRequerente();
        } else {
            if ($user->role == User::ROLE_ENUM['analista']) {
                $requerimentos = Requerimento::where([['status', '!=', Requerimento::STATUS_ENUM['finalizada']], ['status', '!=', Requerimento::STATUS_ENUM['cancelada']], ['analista_id', $user->id]])->orderBy('created_at')->paginate(20);
            }else{
                $requerimentos = Requerimento::where([['status', '!=', Requerimento::STATUS_ENUM['finalizada']], ['status', '!=', Requerimento::STATUS_ENUM['cancelada']]])->orderBy('created_at')->paginate(20);
                $requerimentosFinalizados = Requerimento::where('status', Requerimento::STATUS_ENUM['finalizada'])->orderBy('created_at')->paginate(20);
                $requerimentosCancelados = Requerimento::where('status', Requerimento::STATUS_ENUM['cancelada'])->orderBy('created_at')->paginate(20);
            }
        }
        switch($filtro){
            case 'atuais':
                $requerimentos = $requerimentos;
                break;
            case 'finalizados':
                $requerimentos = $requerimentosFinalizados;
                break;
            case 'cancelados':
                $requerimentos = $requerimentosCancelados;
                break;
        }
        return view('requerimento.index')->with(['requerimentos' => $requerimentos,
                                                 'tipos' => Requerimento::TIPO_ENUM,
                                                 'filtro' => $filtro]);
    }

    public function indexVisitasRequerimento($id)
    {
        $requerimento = Requerimento::find($id);
        $this->authorize('requerimentoDocumentacao', $requerimento);
        $visitas = $requerimento->visitas;

        return view('requerimento.visitasRequerimento', compact('visitas', 'requerimento'));
    }

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
     * Retorna a view dos requerimentos do analista logado.
     *
     * @return \Illuminate\Http\Response
     */
    public function analista()
    {
        $user = auth()->user();
        $requerimentos = $user->requerimentos;

        return view('requerimento.index', compact('requerimentos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequerimentoRequest $request)
    {
        $request->validated();
        $empresa = Empresa::find($request->empresa);

        $requerimentos = Requerimento::where([['empresa_id', $empresa->id], ['status', '!=', Requerimento::STATUS_ENUM['finalizada']], ['status', '!=', Requerimento::STATUS_ENUM['cancelada']]])->get();

        if ($requerimentos->count() > 0) {
            return redirect()->back()->withErrors(['tipo' => 'Você já tem um requerimento pendente.', 'error_modal' => 1]);
        }

        $requerimento = new Requerimento;
        $requerimento->tipo = $request->tipo;
        $requerimento->status = Requerimento::STATUS_ENUM['em_andamento'];
        $requerimento->empresa_id = $empresa->id;
        $requerimento->analista_id = $this->protocolistaComMenosRequerimentos()->id;
        $requerimento->save();

        return redirect(route('requerimentos.index', 'atuais'))->with(['success' => 'Requerimento realizado com sucesso.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $requerimento = Requerimento::find($id);
        $this->authorize('view', $requerimento);
        $protocolistas = User::protocolistas();
        $documentos = Documento::orderBy('nome')->get();
        $definir_valor = Requerimento::DEFINICAO_VALOR_ENUM;

        return view('requerimento.show', compact('requerimento', 'protocolistas', 'documentos', 'definir_valor'));
    }


    public function verRequerimentoVisita($visita_id, $requerimento_id)
    {
        $requerimento = Requerimento::find($requerimento_id);
        $this->authorize('view', $requerimento);
        $protocolistas = User::protocolistas();
        $documentos = Documento::orderBy('nome')->get();
        $visita = true;
        $definir_valor = Requerimento::DEFINICAO_VALOR_ENUM;

        return view('requerimento.show', compact('requerimento', 'protocolistas', 'documentos', 'visita', 'definir_valor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Cancela um requerimento.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $requerimento = Requerimento::find($id);
        $this->authorize('delete', $requerimento);

        if($requerimento->status != \App\Models\Requerimento::STATUS_ENUM['requerida'] &&
        $requerimento->status != \App\Models\Requerimento::STATUS_ENUM['em_andamento'] &&
        $requerimento->status != \App\Models\Requerimento::STATUS_ENUM['documentos_requeridos']) {

            return redirect()->back()->withErrors(['error' => 'Este requerimento já está em andamento e não pode ser cancelado.']);
        }

        $requerimento->status = Requerimento::STATUS_ENUM['cancelada'];
        $requerimento->update();

        return redirect()->back()->with(['success' => 'Requerimento cancelado com sucesso.']);
    }

    /**
     * Atribui um analista a um requerimento.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function atribuirAnalista(Request $request)
    {
        $this->authorize('isSecretario', User::class);
        $validated = $request->validate([
            'analista' => 'required',
            'requerimento' => 'required',
        ]);

        $analista = User::find($request->analista);
        $requerimento = Requerimento::find($request->requerimento);
        if($requerimento->analista_id == null){
            $requerimento->status = Requerimento::STATUS_ENUM['em_andamento'];
        }
        $requerimento->analista_id = $analista->id;
        $requerimento->update();

        return redirect(route('requerimentos.index'))->with(['success' => "Requerimento nº " . $requerimento->id . " atribuído com sucesso a " . $analista->name]);
    }

    /**
     * Salva a lista de documentos para retirar a licença.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeChecklist(Request $request)
    {
        $validated = $request->validate([
            'licença' => 'required',
            'opcão_taxa_serviço' => 'required',
            'valor_da_taxa_de_serviço' => 'required_if:opcão_taxa_serviço,'.Requerimento::DEFINICAO_VALOR_ENUM['manual'],
            'valor_do_juros' => 'required_if:opcão_taxa_serviço,'.Requerimento::DEFINICAO_VALOR_ENUM['automatica_com_juros'],
        ]);

        if ($request->documentos == null) {
            return redirect()->back()->withErrors(['error' => 'Selecione os documentos que devem ser enviados pelo requerente.'])->withInput($request->all());
        }

        $requerimento = Requerimento::find($request->requerimento);
        if ($requerimento->empresa->cnaes->first()->nome == 'Atividades similares' && $requerimento->potencial_poluidor_atribuido == null) {
            return redirect()->back()->withErrors(['error' => 'É necessário atribuir um potencial poluidor ao requerimento.'])->withInput($request->all());
        }
        $this->atribuirValor($request, $requerimento);

        foreach ($request->documentos as $documento_id) {
            $requerimento->documentos()->attach($documento_id);
            $documento = $requerimento->documentos()->where('documento_id', $documento_id)->first()->pivot;
            $documento->status = \App\Models\Checklist::STATUS_ENUM['nao_enviado'];
            $documento->update();
        }
        $requerimento->status = Requerimento::STATUS_ENUM['documentos_requeridos'];
        $requerimento->tipo_licenca = $request->input('licença');
        $requerimento->update();

        Notification::send($requerimento->empresa->user, new DocumentosNotification($requerimento, $requerimento->documentos, 'Documentos requeridos'));

        try {
            $boletoController = new BoletoController();
            $boletoController->boleto($requerimento);
        } catch (ErrorRemessaException $e) {
            return redirect()->back()
            ->with(['success' => 'Checklist salva com sucesso, aguarde o requerente enviar os documentos.'])
            ->withErrors(['error' => 'Erro na geração do boleto: '. $e->getMessage()])
            ->withInput();
        }

        return redirect(route('requerimentos.show', ['requerimento' => $requerimento->id]))->with(['success' => 'Checklist salva com sucesso, aguarde o requerente enviar os documentos.']);
    }

    public function criarNovoBoleto(Request $request)
    {
        $requerimento = Requerimento::find($request->requerimento);
        $this->authorize('isSecretario', auth()->user());
        try {
            $boletoController = new BoletoController();
            $boletoController->criarNovoBoleto($requerimento);
        } catch (ErrorRemessaException $e) {
            return redirect()->back()
            ->with(['success' => 'Boleto gerado com sucesso.'])
            ->withErrors(['error' => 'Erro na geração do boleto: '. $e->getMessage()])
            ->withInput();
        }
        return redirect(route('requerimentos.show', ['requerimento' => $requerimento->id]))->with(['success' => 'Boleto gerado com sucesso.']);
    }

    /**
     * Editar a lista de documentos para retirar a licença.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateChecklist(Request $request)
    {
        $validated = $request->validate([
            'licença' => 'required',
            'opcão_taxa_serviço' => 'required',
            'valor_da_taxa_de_serviço' => 'required_if:opcão_taxa_serviço,'.Requerimento::DEFINICAO_VALOR_ENUM['manual'],
            'valor_do_juros' => 'required_if:opcão_taxa_serviço,'.Requerimento::DEFINICAO_VALOR_ENUM['automatica_com_juros'],
        ]);

        if ($request->documentos == null) {
            return redirect()->back()->withErrors(['error' => 'Selecione os documentos que devem ser enviados pelo requerente.'])->withInput($request->all());
        }

        $requerimento = Requerimento::find($request->requerimento);
        $this->atribuirValor($request, $requerimento);

        // Documentos desmarcados
        foreach ($requerimento->documentos as $documento) {
            if (!in_array($documento->id, $request->documentos)) {
                $requerimento->documentos()->detach($documento->id);
            }
        }

        // Documentos marcados
        foreach ($request->documentos as $documento_id) {
            if (!$requerimento->documentos->contains('id', $documento_id)) {
                $requerimento->documentos()->attach($documento_id);
                $documento = $requerimento->documentos()->where('documento_id', $documento_id)->first()->pivot;
                $documento->status = \App\Models\Checklist::STATUS_ENUM['nao_enviado'];
                $documento->update();
            }
        }

        $requerimento->status = Requerimento::STATUS_ENUM['documentos_requeridos'];

        $requerimento->tipo_licenca = $request->input('licença');
        $requerimento->update();

        return redirect(route('requerimentos.show', ['requerimento' => $requerimento->id]))->with(['success' => 'Checklist atualizada com sucesso, aguarde o requerente enviar os documentos.']);
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
        $valor = null;
        $cnae_maior_poluidor = $requerimento->empresa->cnaes()->orderBy('potencial_poluidor', 'desc')->first();
        if($cnae_maior_poluidor->potencial_poluidor == null){
            $maiorPotencialPoluidor = $requerimento->potencial_poluidor_atribuido;
        }else{
            $maiorPotencialPoluidor = $cnae_maior_poluidor->potencial_poluidor;
        }

        switch ($request->input('opcão_taxa_serviço')) {
            case Requerimento::DEFINICAO_VALOR_ENUM['manual']:
                $valor = $request->input('valor_da_taxa_de_serviço');
                $requerimento->valor_juros = null;
                break;
            case Requerimento::DEFINICAO_VALOR_ENUM['automatica']:
                $valorRequerimento = ValorRequerimento::where([['porte', $requerimento->empresa->porte], ['potencial_poluidor', $maiorPotencialPoluidor], ['tipo_de_licenca', $request->input('licença')]])->first();
                $requerimento->valor_juros = null;
                $valor = $valorRequerimento != null ? $valorRequerimento->valor : null;
                break;
            case Requerimento::DEFINICAO_VALOR_ENUM['automatica_com_juros']:
                $valorRequerimento = ValorRequerimento::where([['porte', $requerimento->empresa->porte], ['potencial_poluidor', $maiorPotencialPoluidor], ['tipo_de_licenca', $request->input('licença')]])->first();
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
     * @return boolean
     */
    private function primeiroRequerimento()
    {

        if (auth()->user()->role == User::ROLE_ENUM['requerente']) {
            $requerimentos = Requerimento::where('empresa_id', auth()->user()->empresa->id)->get();
            if ($requerimentos->count() > 0) {
                return false;
            }
            return true;
        }
        return false;
    }

    public function showRequerimentoDocumentacao($id)
    {
        $requerimento = Requerimento::find($id);
        $this->authorize('verDocumentacao', $requerimento);
        $documentos = $requerimento->documentos;
        if(auth()->user()->role == User::ROLE_ENUM['analista']){
            return view('requerimento.analise-documentos', compact('requerimento', 'documentos'));
        }
        return view('requerimento.envio-documentos', compact('requerimento', 'documentos'));
    }

    public function enviarDocumentos(Request $request)
    {
        $requerimento = Requerimento::find($request->requerimento_id);
        $this->authorize('requerimentoDocumentacao', $requerimento);

        if ($request->documentos == null) {
            return redirect()->back()->withErrors(['error' => 'Anexe os documentos que devem ser enviados.'])->withInput($request->all());
        }

        foreach ($request->documentos_id as $documento_id) {
            if (!$requerimento->documentos->contains('id', $documento_id)) {
                return redirect()->back()->withErrors(['error' => 'Anexe os documentos que devem ser enviados.'])->withInput($request->all());
            }
        }

        $id = 0;
        foreach ($request->documentos_id as $documento_id) {
            $documento = $requerimento->documentos()->where('documento_id', $documento_id)->first()->pivot;
            if($documento->status == Checklist::STATUS_ENUM['nao_enviado'] || $documento->status == \App\Models\Checklist::STATUS_ENUM['recusado']){
                if (Storage::exists($documento->caminho)) {
                    Storage::delete($documento->caminho);
                }
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

        Notification::send($requerimento->analista, new DocumentosEnviadosNotification($requerimento, 'Documentos enviados'));

        return redirect(route('requerimentos.index', 'atuais'))->with(['success' => 'Documentação enviada com sucesso. Aguarde o resultado da avaliação dos documentos.']);
    }

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
            if($documento->status != Checklist::STATUS_ENUM['nao_enviado']){
                $documento->status = $data['analise_'.$documento_id];
                if($data['comentario_'.$documento_id] != null){
                    $documento->comentario = $data['comentario_'.$documento_id];
                }else{
                    $documento->comentario = null;
                }
                $documento->update();
                $id++;
            }
        }
        if($requerimento->documentos()->where('status', Checklist::STATUS_ENUM['recusado'])->first() != null){
            $requerimento->status = Requerimento::STATUS_ENUM['documentos_requeridos'];
            Notification::send($requerimento->empresa->user, new DocumentosAnalisadosNotification($requerimento, $requerimento->documentos, 'Documento recusado'));
        }else{
            $requerimento->status = Requerimento::STATUS_ENUM['documentos_aceitos'];
            Notification::send($requerimento->empresa->user, new DocumentosAnalisadosNotification($requerimento, $requerimento->documentos, 'Documento aceitos'));
        }
        $requerimento->update();
        return redirect(route('requerimentos.analista'))->with(['success' => 'Análise enviada com sucesso.']);

    }

    public function editEmpresa($id)
    {
        $requerimento = Requerimento::find($id);
        $this->authorize('view', $requerimento);
        $setores = Setor::all();

        $setoresSelecionados = collect();
        foreach($requerimento->empresa->cnaes as $cnae){
            if(!$setoresSelecionados->contains($cnae->setor)){
                $setoresSelecionados->push($cnae->setor);
            }
        }

        return view('empresa.edit-protocolista', compact('requerimento', 'setores', 'setoresSelecionados'));
    }

    public function updateEmpresa(Request $request, $id)
    {
        $requerimento = Requerimento::find($id);
        if($request->cnaes_id == null){
            return redirect()->back()->with(['error' => 'Selecione ao menos um cnae.']);
        }

        if($this->possuiModificacaoCnae($request, $id) || $this->possuiModificacaoPorte($request, $id)){
            $historico = new Historico;
            $historico->user_id = auth()->user()->id;
            $historico->empresa_id = $requerimento->empresa->id;
            $historico->save();
            if($this->possuiModificacaoCnae($request, $id)){
                foreach($request->cnaes_id as $cnae_id){
                    $cnae = Cnae::find($cnae_id);
                    if(!$requerimento->empresa->cnaes->contains($cnae)){
                        $requerimento->empresa->cnaes()->attach($cnae);
                        $modifcacaoCnae = new ModificacaoCnae;
                        $modifcacaoCnae->novo = true;
                        $modifcacaoCnae->cnae_id = $cnae_id;
                        $modifcacaoCnae->historico_id = $historico->id;
                        $modifcacaoCnae->save();
                    }else{
                        $modifcacaoCnae = new ModificacaoCnae;
                        $modifcacaoCnae->novo = true;
                        $modifcacaoCnae->cnae_id = $cnae_id;
                        $modifcacaoCnae->historico_id = $historico->id;
                        $modifcacaoCnae->save();

                        $modifcacaoCnae3 = new ModificacaoCnae;
                        $modifcacaoCnae3->novo = false;
                        $modifcacaoCnae3->cnae_id = $cnae_id;
                        $modifcacaoCnae3->historico_id = $historico->id;
                        $modifcacaoCnae3->save();
                    }
                }
                foreach($requerimento->empresa->cnaes as $cnae){
                    if(!in_array($cnae->id, $request->cnaes_id)){
                        $requerimento->empresa->cnaes()->detach($cnae);
                        $modifcacaoCnae2 = new ModificacaoCnae;
                        $modifcacaoCnae2->novo = false;
                        $modifcacaoCnae2->cnae_id = $cnae->id;
                        $modifcacaoCnae2->historico_id = $historico->id;
                        $modifcacaoCnae2->save();
                    }
                }
            }
            if($this->possuiModificacaoPorte($request, $id)){
                $modifcacaoPorte = new ModificacaoPorte;
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
        foreach($request->cnaes_id as $cnae_id){
            $cnae = Cnae::find($cnae_id);
            if(!$requerimento->empresa->cnaes->contains($cnae)){
                return true;
            }
        }

        foreach($requerimento->empresa->cnaes as $cnae){
            if(!in_array($cnae->id, $request->cnaes_id)){
                return true;
            }
        }

        return false;
    }

    public function possuiModificacaoPorte($request, $id)
    {
        $requerimento = Requerimento::find($id);
        if($requerimento->empresa->porte != Empresa::PORTE_ENUM[$request->porte]){
            return true;
        }
        return false;
    }

    /**
     * Retorna o protocolista com menos requerimentos.
     *
     * @return App\Models\User $protocolistaComMenosRequerimentos
     */
    private function protocolistaComMenosRequerimentos()
    {
        $protocolistas = User::protocolistas();
        $protocolistaComMenosRequerimentos = null;
        $min = 30000;
        foreach ($protocolistas as $protocolista) {
            $quantRequerimentos = $protocolista->requerimentos()->where('status', '<', Requerimento::STATUS_ENUM['documentos_aceitos'])->get()->count();
            if ($quantRequerimentos < $min) {
                $min = $quantRequerimentos;
                $protocolistaComMenosRequerimentos = $protocolista;
            }
        }

        return $protocolistaComMenosRequerimentos;
    }

    public function atribuirPotencialPoluidor(Request $request, $id){
        $this->authorize('isSecretarioOrProtocolista', User::class);

        $validator = $request->validate([
            'potencial_poluidor' => 'required',
        ]);

        $requerimento = Requerimento::find($id);
        $requerimento->potencial_poluidor_atribuido = Cnae::POTENCIAL_POLUIDOR_ENUM[$request->potencial_poluidor];
        $requerimento->update();

        if($requerimento->valor != null){
            $this->atribuirValor($request, $requerimento);
        }
        $requerimento->update();

        return redirect(route('requerimentos.show', ['requerimento' => $requerimento->id]))->with(['success' => 'Potencial poluidor atribuído ao requerimento com sucesso.']);
    }

}
