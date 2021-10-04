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
use Illuminate\Support\Facades\Notification;
use App\Notifications\DocumentosNotification;
use App\Notifications\DocumentosEnviadosNotification;
use App\Notifications\DocumentosAnalisadosNotification;
use App\Models\Empresa;
use App\Models\TipoAnalista;

class RequerimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $requerimentos = collect();
        $requerimentosCancelados = collect();
        $requerimentosFinalizados = collect();
        if ($user->role == User::ROLE_ENUM['requerente']) {
            $requerimentos = auth()->user()->requerimentosRequerente();
        } else {
            $requerimentos = Requerimento::where([['status', '!=', Requerimento::STATUS_ENUM['finalizada']], ['status', '!=', Requerimento::STATUS_ENUM['cancelada']]])->orderBy('created_at')->get();
            $requerimentosFinalizados = Requerimento::where('status', Requerimento::STATUS_ENUM['finalizada'])->orderBy('created_at')->get();
            $requerimentosCancelados = Requerimento::where('status', Requerimento::STATUS_ENUM['cancelada'])->orderBy('created_at')->get();
        }
        return view('requerimento.index')->with(['requerimentos' => $requerimentos,
                                                 'requerimentosFinalizados' => $requerimentosFinalizados,
                                                 'requerimentosCancelados' => $requerimentosCancelados, 
                                                 'tipos' => Requerimento::TIPO_ENUM]);
    }

    public function indexVisitasRequerimento($id)
    {
        $requerimento = Requerimento::find($id);
        $this->authorize('requerimentoDocumentacao', $requerimento);
        $visitas = $requerimento->visitas;

        return view('visita.visitasRequerimento', compact('visitas', 'requerimento'));
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

        return redirect(route('requerimentos.index'))->with(['success' => 'Requerimento realizado com sucesso.']);
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
        $protocolistas = $this->protocolistas();
        $documentos = Documento::orderBy('nome')->get();

        return view('requerimento.show', compact('requerimento', 'protocolistas', 'documentos'));
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

        if (auth()->user()->role != User::ROLE_ENUM['secretario']) {
            if ($requerimento->status > Requerimento::STATUS_ENUM['requerida']) {
                return redirect()->back()->withErrors(['error' => 'Este requerimento já está em andamento e não pode ser cancelado.']);
            }
        }

        $requerimento->status = Requerimento::STATUS_ENUM['cancelada'];
        $requerimento->update();

        return redirect(route('requerimentos.index'))->with(['success' => 'Requerimento cancelado com sucesso.']);
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

        return redirect(route('requerimentos.index'))->with(['success' => "Requerimento nº " . $requerimento->id . " atribuido com sucesso a " . $analista->name]);
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
        ]);

        if ($request->documentos == null) {
            return redirect()->back()->withErrors(['error' => 'Selecione os documentos que devem ser enviados pelo requerente.'])->withInput($request->all());
        }

        $requerimento = Requerimento::find($request->requerimento);
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

        return redirect(route('requerimentos.show', ['requerimento' => $requerimento->id]))->with(['success' => 'Checklist salva com sucesso, aguarde o requerente enviar os documentos.']);
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

                $requerimento->status = Requerimento::STATUS_ENUM['documentos_enviados'];
            }
        }

        // Documentos marcados
        foreach ($request->documentos as $documento_id) {
            if (!$requerimento->documentos->contains('id', $documento_id)) {
                $requerimento->documentos()->attach($documento_id);
                $documento = $requerimento->documentos()->where('documento_id', $documento_id)->first()->pivot;
                $documento->status = \App\Models\Checklist::STATUS_ENUM['nao_enviado'];
                $documento->update();

                $requerimento->status = Requerimento::STATUS_ENUM['documentos_requeridos'];
            }
        }

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
        $cnae_maior_poluidor = $requerimento->empresa->cnaes()->orderBy('potencial_poluidor', 'desc')->first();
        $valorRequerimento = ValorRequerimento::where([['porte', $requerimento->empresa->porte], ['potencial_poluidor', $cnae_maior_poluidor->potencial_poluidor], ['tipo_de_licenca', $request->input('licença')]])->first();

        $requerimento->valor = $valorRequerimento != null ? $valorRequerimento->valor : null;
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
                if (Storage::disk()->exists('public/' . $documento->caminho)) {
                    Storage::delete('public/' . $documento->caminho);
                }
                $arquivo = $request->documentos[$id];
                $path = 'documentos/requerimentos/'. $requerimento->id .'/';
                $nome = $arquivo->getClientOriginalName();
                Storage::putFileAs('public/'.$path, $arquivo, $nome);
                $documento->caminho = $path . $nome;
                $documento->comentario = null;
                $documento->status = Checklist::STATUS_ENUM['enviado'];
                $documento->update();
                $id++;
            }
        }
        $requerimento->status = Requerimento::STATUS_ENUM['documentos_enviados'];
        $requerimento->update();

        Notification::send($requerimento->analista, new DocumentosEnviadosNotification($requerimento, 'Documentos enviados'));

        return redirect(route('requerimentos.index'))->with(['success' => 'Documentação enviada com sucesso. Aguarde o resultado da avaliação dos documentos.']);
    }

    public function showDocumento($requerimento_id, $documento_id)
    {
        $requerimento = Requerimento::find($requerimento_id);
        $this->authorize('verDocumentacao', $requerimento);
        $documento = $requerimento->documentos()->where('documento_id', $documento_id)->first()->pivot;
        return Storage::disk()->exists('public/' . $documento->caminho) ? response()->file('storage/' . $documento->caminho) : abort(404);
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

    /**
     * Retorna o protocolista com menos requerimentos.
     *
     * @return App\Models\User $protocolistaComMenosRequerimentos
     */
    private function protocolistaComMenosRequerimentos()
    {
        $protocolistas = $this->protocolistas();
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

    /**
     * Retorna os protocolistas cadastrados.
     *
     * @return App\Models\User $protocolistas
     */
    private function protocolistas() 
    {
        $protocolistas = collect();
        $analistas = User::where('role', User::ROLE_ENUM['analista'])->get();
        
        foreach ($analistas as $analista) {
            if ($analista->tipo_analista()->where('tipo', TipoAnalista::TIPO_ENUM['protocolista'])->get()->count() > 0) {
                $protocolistas->push($analista);
            }
        }

        return $protocolistas;
    }
}
