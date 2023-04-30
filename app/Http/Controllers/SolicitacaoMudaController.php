<?php

namespace App\Http\Controllers;

use App\Http\Requests\SolicitacaoMudaAvaliarRequest;
use App\Http\Requests\SolicitacaoMudaRequest;
use App\Mail\SolicitacaoMudasCriada;
use App\Models\EspecieMuda;
use App\Models\User;
use App\Models\Requerente;
use App\Models\MudaSolicitada;
use App\Models\SolicitacaoMuda;
use App\Notifications\ParecerSolicitacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class SolicitacaoMudaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($filtro, Request $request)
    {
        $this->authorize('index', SolicitacaoMuda::class);
        $registradas = SolicitacaoMuda::where('status', '1')->orderBy('created_at', 'DESC')->paginate(20);
        $deferidas = SolicitacaoMuda::where('status', '2')->orderBy('created_at', 'DESC')->paginate(20);
        $indeferidas = SolicitacaoMuda::where('status', '3')->orderBy('created_at', 'DESC')->paginate(20);

        switch ($filtro) {
            case 'pendentes':
                $mudas = $registradas;
                break;
            case 'deferidas':
                $mudas = $deferidas;
                break;
            case 'indeferidas':
                $mudas = $indeferidas;
                break;
        }

        $busca = $request->buscar;
        if($busca != null){
            $usuarios= User::where('name', 'ilike', '%'. $busca .'%')->get();
            $usuarios = $usuarios->pluck('id');
            $requerentes = Requerente::whereIn('user_id', $usuarios);
            $requerentes = $requerentes->pluck('id');
            $mudas = SolicitacaoMuda::whereIn('requerente_id', $requerentes)->paginate(20);
        }

        return view('solicitacoes.mudas.index', compact('mudas', 'filtro', 'busca'));
    }

    public function requerenteIndex()
    {
        $this->authorize('requerenteIndex', SolicitacaoMuda::class);
        $solicitacoes = SolicitacaoMuda::where('requerente_id', auth()->user()->requerente->id)->orderBy('created_at', 'DESC')->paginate(10);

        return view('solicitacoes.mudas.requerente.index', compact('solicitacoes'));
    }

    public function create()
    {
        $this->authorize('create', SolicitacaoMuda::class);

        $especies = EspecieMuda::where('disponivel', true)->orderBy('nome')->get();

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

        if($this->periodoMinimo(auth()->user()->requerente->id)){
            return redirect()->back()->with(['error' => 'Temos um período mínimo de 3 meses para novas solicitações. Solicite novamente após 3 meses da última solicitação de muda feita.']);
        }

        $solicitacao = new SolicitacaoMuda();
        $solicitacao->fill($data);
        $solicitacao->requerente_id = auth()->user()->requerente->id;
        $protocolo = null;
        do {
            $protocolo = substr(str_shuffle(Hash::make(date('Y-m-d H:i:s'))), 0, 20);
            $check = SolicitacaoMuda::where('protocolo', $protocolo)->first();
        } while ($check != null);
        $solicitacao->protocolo = $protocolo;
        $solicitacao->save();
        foreach ($request->especie as $i => $especie) {
            if(EspecieMuda::find($especie)->disponivel){
                MudaSolicitada::create([
                    'solicitacao_id' => $solicitacao->id,
                    'especie_id' => $especie,
                    'qtd_mudas' => $request->qtd_mudas[$i],
                ]);
            }
        }
        Mail::to($solicitacao->requerente->user->email)->send(new SolicitacaoMudasCriada($solicitacao));

        if($this->verificarEndereco($solicitacao)){
            return redirect()->back()->with(['message' => 'Solicitação de muda realizada com sucesso!']);
        }

        return redirect()->back()->with(['success' => 'Solicitação de muda realizada com sucesso!', 'protocolo' => $protocolo]);
    }

    public function verificarEndereco($solicitacao){
        $local = strtolower($solicitacao->local);

        if(stripos($local, 'garanhuns') !== false){
            return false;
        }
        else{
            return true;
        }
    }

    public function periodoMinimo($requerente_id){
        $solicitacoes = solicitacaoMuda::where('requerente_id', $requerente_id)
                ->whereDate('updated_at', '>', Carbon::now()->subMonths(3)->format('Y-m-d'))->first();
        if($solicitacoes != null){
            return true;
        }
        return false;
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
        if ($solicitacao == null) {
            return redirect()->back()->with(['error' => 'Solicitação não encontrada.']);
        }

        return Storage::download($solicitacao->arquivo);
    }

    public function status(Request $request)
    {
        $solicitacao = SolicitacaoMuda::where('protocolo', $request->protocolo)->first();
        if ($solicitacao == null) {
            return redirect()->back()->with(['error' => 'Solicitação não encontrada. Verifique o protocolo informado.']);
        }

        return view('solicitacoes.mudas.requerente.status', compact('solicitacao'));
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
        if ($request->file('arquivo')) {
            $solicitacao->arquivo = $data['arquivo']->store("mudas/{$solicitacao->id}/documento");
        }
        if ($data['status'] == 2) {
            Notification::send($solicitacao->requerente->user, new ParecerSolicitacao($solicitacao, 'muda', 'deferida'));
        } elseif ($data['status'] == 3) {
            Notification::send($solicitacao->requerente->user, new ParecerSolicitacao($solicitacao, 'muda', 'indeferida', $data['motivo_indeferimento']));
        }
        $solicitacao->update();

        return redirect()->route('mudas.index', 'pendentes')->with('success', 'Solicitação de muda avalida com sucesso');
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
