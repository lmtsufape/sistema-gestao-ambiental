<?php

namespace App\Http\Controllers;

use App\Http\Requests\SolicitacaoMudaAvaliarRequest;
use App\Http\Requests\SolicitacaoMudaRequest;
use App\Models\SolicitacaoMuda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SolicitacaoMudaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SolicitacaoMudaRequest $request)
    {
        $data = $request->validated();
        $solicitacao = new SolicitacaoMuda();
        $solicitacao->fill($data);
        $protocolo = Hash::make(date("Y-m-d H:i:s"));
        $solicitacao->protocolo = $protocolo;
        $solicitacao->save();
        return redirect()->back()->with(['success' => 'Solicitação de muda realizada com sucesso!', 'protocolo' => $protocolo]);
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


    public function status(Request $request)
    {
        $solicitacao = SolicitacaoMuda::where('protocolo', $request->protocolo)->first();
        if($solicitacao == null){
            return redirect()->back()->with(['error' => 'Solicitação não encontrada. Verifique o protocolo informado.']);
        }else{
            return view('solicitacoes.mudas.status', compact('solicitacao'));
        }
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
        $this->authorize('avaliar', SolicitacaoMuda::class);
        $solicitacao->fill($request->validated());
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
