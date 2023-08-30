<?php

namespace App\Http\Controllers;

use App\Http\Requests\LicencaRequest;
use App\Models\Documento;
use App\Models\Empresa;
use App\Models\Licenca;
use App\Models\Requerimento;
use App\Models\RequerimentoDocumento;
use App\Models\User;
use App\Models\Visita;
use App\Notifications\LicencaAprovada;
use App\Notifications\LicencaAtualizada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\DocumentosExigidosNotification;
class LicencaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Mostra a view de emitir uma licença para um requerimento com relatório aceito.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function create(Requerimento $requerimento)
    {
        $this->authorize('isSecretario', User::class);
        $documentos = Documento::all();
        
        return view('licenca.create', compact('requerimento', 'documentos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\LicencaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LicencaRequest $request)
    {
        $this->authorize('isSecretario', User::class);

        $requerimento = Requerimento::find($request->requerimento);

        $licenca = new Licenca();
        $licenca->setAtributes($request, $requerimento);

        $licenca->status = Licenca::STATUS_ENUM['aprovada'];

        if($request->licenca_permanente == "on"){
            $licenca->licenca_permanente = true;
        }else{
            $licenca->licenca_permanente = false;
        }
        
        $requerimento->status = Requerimento::STATUS_ENUM['finalizada'];
        $licenca->update();
        $requerimento->update();

        Notification::send($requerimento->empresa->user, new LicencaAprovada($requerimento, $licenca));

        return redirect(route('requerimentos.index', 'atuais'))->with(['success' => 'Licença criada com sucesso!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $licenca = Licenca::find($id);

        return view('licenca.show', compact('licenca'));
    }

    public function documento(Licenca $licenca)
    {   
        $path = storage_path('app/' . $licenca->caminho);
        $headers = [
            'Content-Type' => $this->getMimeType($path),
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"'
        ];

        return response()->file($path, $headers);
    }

    private function getMimeType($path)
    {
        // Use a helper to determine the MIME type
        return \File::mimeType($path);
    }

    /**
     * Mostra a tela de revisar licença para um analista.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function revisar($visita_id, $licenca_id)
    {
        $visita = Visita::find($visita_id);
        $this->authorize('analistaDaVisitaOrSecretario', $visita);
        $licenca = Licenca::find($licenca_id);

        return view('licenca.revisar', compact('visita', 'licenca'));
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
        $this->authorize('isSecretario', auth()->user());

        $request->validate([
            'tipo_de_licença' => 'required',
            'data_de_validade' => 'required',
            'licença' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $licenca = Licenca::find($id);
        $licenca->tipo = $request->input('tipo_de_licença');
        $licenca->validade = $request->data_de_validade;
        //$licenca->status = Licenca::STATUS_ENUM['gerada'];

        $requerimento = Requerimento::find($licenca->requerimento_id);

        if ($request->file('licença') != null) {
            $licenca->caminho = $licenca->salvarLicenca($request->file('licença'), $licenca->requerimento);
        }

        $licenca->update();

        Notification::send($requerimento->empresa->user, new LicencaAtualizada($requerimento, $licenca));

        return redirect(route('requerimentos.index', 'finalizados'))->with(['success' => 'Licença atualizada com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Atualiza a revisão de uma licença.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function salvarRevisao(Request $request, $licenca_id, $visita_id)
    {
        $visita = Visita::find($visita_id);
        $this->authorize('analistaDaVisita', $visita);

        $request->validate([
            'status' => 'required',
        ]);

        $licenca = Licenca::find($licenca_id);
        if ($request->status == 1) {
            $licenca->status = Licenca::STATUS_ENUM['aprovada'];
            $requerimento = $licenca->requerimento;
            $requerimento->status = Requerimento::STATUS_ENUM['finalizada'];
            $requerimento->update();
            Notification::send($requerimento->empresa->user, new LicencaAprovada($requerimento, $licenca));
        } else {
            $licenca->status = Licenca::STATUS_ENUM['revisar'];
            $licenca->comentario_revisao = $request->motivo;
        }

        $licenca->update();

        return redirect(route('requerimentos.index', 'atuais'))->with(['success' => 'Licença revisada com sucesso!']);
    }

    public function requisitarDocumentos(Request $request, $requerimento_id)
    {   
    // dd($request);
    // $this->authorize('isSecretarioOrIsAnalista', auth()->user());

    $request->validate([
        'documentos' => 'nullable',
        'prazo_exigencia' => 'required',
        'nome_documento' => 'nullable'
    ]);

    $requerimento = Requerimento::find($requerimento_id);
    $empresa = Empresa::find($requerimento->empresa_id);
    $requerimento_documentos = RequerimentoDocumento::where('requerimento_id', $requerimento_id)->get();
    $documentos = Documento::all();

    if ($requerimento_documentos->count() > 0) {
        return redirect()->back()->with(['error' => 'Documentos já requisitados!']);
    }

    if ($request->nome_documento != null && $request->documentos != null) {
        foreach ($request->documentos as $key => $documento_id) {
            $data = [
                'requerimento_id' => $requerimento_id,
                'documento_id' => $documento_id,
                'empresa_id' => $empresa->id,
                'arquivo_outro_documento' => null,
                'nome_outro_documento' => null,
                'prazo_exigencia' => $request->prazo_exigencia,
                'anexo_arquivo' => null,
                'status' => RequerimentoDocumento::STATUS_ENUM['nao_enviado'],
            ];
            $requerimento_documentos = RequerimentoDocumento::create($data);
        }
            $data = [
                'requerimento_id' => $requerimento_id,
                'documento_id' => null,
                'empresa_id' => $empresa->id,
                'arquivo_outro_documento' => null,
                'nome_outro_documento' => $request->nome_documento,
                'prazo_exigencia' => $request->prazo_exigencia,
                'anexo_arquivo' => null,
                'status' => RequerimentoDocumento::STATUS_ENUM['nao_enviado'],
            ];
            $requerimento_documentos = RequerimentoDocumento::create($data);
        
        $all_requerimento_documentos = RequerimentoDocumento::where('requerimento_id', $requerimento_id)->get();
        
        Notification::send($requerimento->empresa->user, new DocumentosExigidosNotification($requerimento, $all_requerimento_documentos, $documentos, 'Documentos exigidos para emissão de licença ambiental'));
        return redirect()->back()->with(['success' => 'Documentos requisitados com sucesso!']);

    } elseif ($request->nome_documento == null && $request->documentos != null) {
        foreach ($request->documentos as $key => $documento_id) {
            $data = [
                'requerimento_id' => $requerimento_id,
                'documento_id' => $documento_id,
                'empresa_id' => $empresa->id,
                'arquivo_outro_documento' => null,
                'nome_outro_documento' => null,
                'prazo_exigencia' => $request->prazo_exigencia,
                'anexo_arquivo' => null,
                'status' => RequerimentoDocumento::STATUS_ENUM['nao_enviado'],
            ];
            $requerimento_documentos = RequerimentoDocumento::create($data);
        }
       
        $all_requerimento_documentos = RequerimentoDocumento::where('requerimento_id', $requerimento_id)->get();

        Notification::send($requerimento->empresa->user, new DocumentosExigidosNotification($requerimento, $all_requerimento_documentos, $documentos, 'Documentos exigidos para emissão de licença ambiental'));
        return redirect()->back()->with(['success' => 'Documentos requisitados com sucesso!']);

    } elseif($request->documentos == null && $request->nome_documento != null) {
        $data = [
            'requerimento_id' => $requerimento_id,
            'documento_id' => null,
            'empresa_id' => $empresa->id,
            'arquivo_outro_documento' => null,
            'nome_outro_documento' => $request->nome_documento,
            'prazo_exigencia' => $request->prazo_exigencia,
            'anexo_arquivo' => null,
            'status' => RequerimentoDocumento::STATUS_ENUM['nao_enviado'],
        ];

        $requerimento_documentos = RequerimentoDocumento::create($data);

        $all_requerimento_documentos = RequerimentoDocumento::where('requerimento_id', $requerimento_id)->get();

        Notification::send($requerimento->empresa->user, new DocumentosExigidosNotification($requerimento, $all_requerimento_documentos, $documentos, 'Documentos exigidos para emissão de licença ambiental'));
        return redirect()->back()->with(['success' => 'Documentos requisitados com sucesso!']);
    } 
}
}
