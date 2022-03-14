<?php

namespace App\Http\Controllers;

use App\Http\Requests\SolicitacaoMudaAvaliarRequest;
use App\Http\Requests\SolicitacaoMudaRequest;
use App\Mail\SolicitacaoMudasCriada;
use App\Models\Endereco;
use App\Models\EspecieMuda;
use App\Models\SolicitacaoMuda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SolicitacaoMudaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('index', SolicitacaoMuda::class);
        $registradas = SolicitacaoMuda::where('status', '1')->get();
        $deferidas   = SolicitacaoMuda::where('status', '2')->get();
        $indeferidas = SolicitacaoMuda::where('status', '3')->get();
        return view('solicitacoes.mudas.index', compact('registradas','deferidas', 'indeferidas'));
    }

    public function requerenteIndex()
    {
        $this->authorize('requerenteIndex', SolicitacaoMuda::class);
        $solicitacoes = SolicitacaoMuda::where('requerente_id', auth()->user()->requerente->id)->get();
        return view('solicitacoes.mudas.requerente.index', compact('solicitacoes'));
    }


    public function create()
    {
        $this->authorize('create', SolicitacaoMuda::class);

        $especies = EspecieMuda::orderBy('nome')->get();
        return view('solicitacoes.mudas.requerente.create', compact('especies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SolicitacaoMudaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SolicitacaoMudaRequest $request)
    {
        $this->authorize('create', SolicitacaoMuda::class);
        $data = $request->validated();
        $solicitacao = new SolicitacaoMuda();
        $solicitacao->fill($data);
        $solicitacao->requerente_id = auth()->user()->requerente->id;
        $solicitacao->especie_id = $request->especie;
        $protocolo = null;
        do {
            $protocolo = substr(str_shuffle(Hash::make(date("Y-m-d H:i:s"))), 0, 20);
            $check = SolicitacaoMuda::where('protocolo', $protocolo)->first();
        } while($check != null);
        $solicitacao->protocolo = $protocolo;
        $solicitacao->save();
        Mail::to($solicitacao->requerente->user->email)->send(new SolicitacaoMudasCriada($solicitacao));
        return redirect()->back()->with(['success' => 'Solicitação de mudas realizada com sucesso!', 'protocolo' => $protocolo]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SolicitacaoMuda  $solicitacaoMuda
     * @return \Illuminate\Http\Response
     */
    public function show(SolicitacaoMuda $solicitacao)
    {
        $this->authorize('viewAny', SolicitacaoMuda::class);
        return view('solicitacoes.mudas.show', ['solicitacao' => $solicitacao]);
    }

    public function documento(Request $request, $id)
    {
        $solicitacao = SolicitacaoMuda::find($id);
        if($solicitacao == null){
            return redirect()->back()->with(['error' => 'Solicitação não encontrada.']);
        } else {
            return Storage::download('/public//'.$solicitacao->arquivo);
        }
    }

    public function status(Request $request)
    {
        $solicitacao = SolicitacaoMuda::where('protocolo', $request->protocolo)->first();
        if($solicitacao == null){
            return redirect()->back()->with(['error' => 'Solicitação não encontrada. Verifique o protocolo informado.']);
        }else{
            return view('solicitacoes.mudas.requerente.status', compact('solicitacao'));
        }
    }

    public function mostrar(SolicitacaoMuda $solicitacao)
    {
        $this->authorize('view', $solicitacao);
        return view('solicitacoes.mudas.requerente.status', compact('solicitacao'));
    }

    public function edit(SolicitacaoMuda $solicitacao)
    {
        $this->authorize('edit', SolicitacaoMuda::class);
        return view('solicitacoes.mudas.edit', ['solicitacao' => $solicitacao]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SolicitacaoMudaAvaliarRequest  $request
     * @param  \App\Models\SolicitacaoMuda  $solicitacaoMuda
     * @return \Illuminate\Http\Response
     */
    public function avaliar(SolicitacaoMudaAvaliarRequest $request, SolicitacaoMuda $solicitacao)
    {
        $data = $request->validated();
        $solicitacao->fill($data);
        if (array_key_exists("arquivo", $data)) {
            $path = sprintf('public/mudas/%u/documento/', $solicitacao->id);
            Storage::putFileAs($path, $data['arquivo'], $data['arquivo']->getClientOriginalName());
            $solicitacao->arquivo = sprintf('mudas/%u/documento/%s', $solicitacao->id, $data['arquivo']->getClientOriginalName());
        }
        $solicitacao->update();
        return redirect()->action([SolicitacaoMudaController::class, 'index'])->with('success', 'Solicitação de muda avalida com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SolicitacaoMuda  $solicitacaoMuda
     * @return \Illuminate\Http\Response
     */
    public function destroy(SolicitacaoMuda $solicitacaoMuda)
    {
        //
    }
}
