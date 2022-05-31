<?php

namespace App\Http\Controllers;

use App\Http\Requests\SolicitacaoPodaAvaliarRequest;
use App\Http\Requests\SolicitacaoPodaRequest;
use App\Mail\SolicitacaoPodasCriada;
use App\Models\Endereco;
use App\Models\FotoPoda;
use App\Models\SolicitacaoPoda;
use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SolicitacaoPodaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($filtro)
    {
        $this->authorize('index', SolicitacaoPoda::class);

        $userPolicy = new UserPolicy();
        if($userPolicy->isAnalistaPoda(auth()->user())){
            $solicitacoes   = SolicitacaoPoda::where([['status', '2'], ['analista_id', auth()->user()->id]])->paginate(20);
            $analistas = User::analistasPoda();
            $filtro = 'deferidas';
            return view('solicitacoes.podas.index', compact('filtro', 'analistas', 'solicitacoes'));
        }else{
            $registradas = SolicitacaoPoda::where('status', '1')->paginate(20);
            $indeferidas = SolicitacaoPoda::where('status', '3')->paginate(20);

            $solicitacoes_podas_concluidas = DB::table('solicitacoes_podas')->join('visitas', 'visitas.solicitacao_poda_id', '=', 'solicitacoes_podas.id')
                ->where('visitas.data_realizada', '!=', null)
                ->get('solicitacoes_podas.id');

            $solicitacoes_podas_deferidas = DB::table('solicitacoes_podas')
            ->where('solicitacoes_podas.status', '=', 2)
            ->select('solicitacoes_podas.id');

            $solicitacoes_podas_deferidas_collection = collect();

            foreach($solicitacoes_podas_deferidas->get() as $denuncia){
                if($solicitacoes_podas_concluidas->doesntContain($denuncia)){
                    $solicitacoes_podas_deferidas_collection->push($denuncia);
                }
            }

            $deferidas = SolicitacaoPoda::whereIn('id', $solicitacoes_podas_deferidas_collection->pluck('id'))->orderBy('created_at', 'DESC')->paginate(20);
            $concluidas = SolicitacaoPoda::whereIn('id', $solicitacoes_podas_concluidas->pluck('id'))->orderBy('created_at', 'DESC')->paginate(20);

            switch($filtro){
                case 'pendentes':
                    $solicitacoes = $registradas;
                    break;
                case 'deferidas':
                    $solicitacoes = $deferidas;
                    break;
                case 'indeferidas':
                    $solicitacoes = $indeferidas;
                    break;
                case 'concluidas':
                    $solicitacoes = $concluidas;
                    break;
            }
            $analistas = User::analistasPoda();
            return view('solicitacoes.podas.index', compact('filtro', 'analistas', 'solicitacoes'));
        }
    }

    public function infoSolicitacao(Request $request)
    {
        $this->authorize('isSecretario', User::class);

        $solicitacao = SolicitacaoPoda::find($request->solicitacao_id);

        $solicitacaoInfo = [
            'id' => $solicitacao->id,
            'analista_atribuido' => $solicitacao->analista ? $solicitacao->analista : null,
            'analista_visita' => $solicitacao->visita ? $solicitacao->visita->analista : null,
            'marcada' => $solicitacao->visita ? $solicitacao->visita->data_marcada : null,
            'realizada' => $solicitacao->visita ? $solicitacao->visita->data_realizada : null,
        ];

        return response()->json($solicitacaoInfo);
    }


    public function requerenteIndex()
    {
        $this->authorize('requerenteIndex', SolicitacaoPoda::class);
        $solicitacoes = SolicitacaoPoda::where('requerente_id', auth()->user()->requerente->id)->get();
        return view('solicitacoes.podas.requerente.index', compact('solicitacoes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SolicitacaoPodaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SolicitacaoPodaRequest $request)
    {
        $data = $request->validated();
        $solicitacao = new SolicitacaoPoda();
        $solicitacao->fill($data);
        $endereco = new Endereco();
        $endereco->fill($data);
        $endereco->save();
        $solicitacao->endereco()->associate($endereco);
        $solicitacao->requerente_id = auth()->user()->requerente->id;
        $protocolo = null;
        do {
            $protocolo = substr(str_shuffle(Hash::make(date("Y-m-d H:i:s"))), 0, 20);
            $check = SolicitacaoPoda::where('protocolo', $protocolo)->first();
        } while($check != null);
        $solicitacao->protocolo = $protocolo;
        $solicitacao->save();

        if (array_key_exists("imagem", $data)) {
            for ($i = 0; $i < count($data['imagem']); $i++) {
                $foto_poda = new FotoPoda();
                $foto_poda->solicitacao_poda_id = $solicitacao->id;
                $foto_poda->comentario = $data['comentarios'][$i] ?? "";
                $nomeImg = $data['imagem'][$i]->getClientOriginalName();
                $path = 'podas/' . $solicitacao->id .'/imagens'.'/';
                Storage::putFileAs('public/' . $path, $data['imagem'][$i], $nomeImg);
                $foto_poda->caminho = $path . $nomeImg;
                $foto_poda->save();
            }
        }
        Mail::to($solicitacao->requerente->user->email)->send(new SolicitacaoPodasCriada($solicitacao));
        return redirect()->back()->with(['success' => 'Solicitação de poda/supressão realizada com sucesso!', 'protocolo' => $protocolo]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SolicitacaoPoda  $solicitacaoPoda
     * @return \Illuminate\Http\Response
     */
    public function show(SolicitacaoPoda $solicitacao)
    {
        $this->authorize('viewAny', SolicitacaoPoda::class);
        return view('solicitacoes.podas.show', ['solicitacao' => $solicitacao]);
    }


    public function status(Request $request)
    {
        $solicitacao = SolicitacaoPoda::where('protocolo', $request->protocolo)->first();
        if($solicitacao == null){
            return redirect()->back()->with(['error' => 'Solicitação não encontrada. Verifique o protocolo informado.']);
        }else{
            return view('solicitacoes.podas.requerente.status', compact('solicitacao'));
        }
    }

    public function mostrar(SolicitacaoPoda $solicitacao)
    {
        $this->authorize('view', $solicitacao);
        return view('solicitacoes.podas.requerente.status', compact('solicitacao'));
    }

    public function edit(SolicitacaoPoda $solicitacao)
    {
        $this->authorize('edit', SolicitacaoPoda::class);
        return view('solicitacoes.podas.edit', ['solicitacao' => $solicitacao]);
    }

    public function ficha(SolicitacaoPoda $solicitacao)
    {
        $this->authorize('viewAny', SolicitacaoPoda::class);
        return view('solicitacoes.podas.fichas.create', ['solicitacao' => $solicitacao]);
    }

    public function laudo(SolicitacaoPoda $solicitacao)
    {
        $this->authorize('viewAny', SolicitacaoPoda::class);
        return view('solicitacoes.podas.laudos.create', ['solicitacao' => $solicitacao]);
    }

    public function atribuirAnalistaSolicitacao(Request $request)
    {
        $this->authorize('isSecretario', User::class);

        $request->validate([
            'solicitacao_id_analista' => 'required',
            'analista'                => 'required',
        ]);

        $solicitacao = SolicitacaoPoda::find($request->solicitacao_id_analista);
        $solicitacao->analista_id = $request->analista;
        $solicitacao->update();

        return redirect()->back()->with(['success' => 'Solicitação atribuida com sucesso ao analista.']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SolicitacaoPodaAvaliarRequest  $request
     * @param  \App\Models\SolicitacaoPoda  $solicitacaoPoda
     * @return \Illuminate\Http\Response
     */
    public function avaliar(SolicitacaoPodaAvaliarRequest $request, SolicitacaoPoda $solicitacao)
    {
        $this->authorize('avaliar', SolicitacaoPoda::class);
        $solicitacao->fill($request->validated());
        $solicitacao->update();
        return redirect()->route('podas.index', 'pendentes')->with('success', 'Solicitação de poda/supressão avalida com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SolicitacaoPoda  $solicitacaoPoda
     * @return \Illuminate\Http\Response
     */
    public function destroy(SolicitacaoPoda $solicitacaoPoda)
    {
        //
    }
}
