<?php

namespace App\Http\Controllers;

use App\Http\Requests\SolicitacaoPodaAvaliarRequest;
use App\Http\Requests\SolicitacaoPodaRequest;
use App\Mail\SolicitacaoPodasCriada;
use App\Mail\SolicitacaoPodasEncaminhada;
use App\Models\Endereco;
use App\Models\FotoPoda;
use App\Models\Requerente;
use App\Models\Relatorio;
use App\Models\Telefone;
use App\Models\SolicitacaoPoda;
use App\Models\User;
use App\Notifications\ParecerSolicitacao;
use App\Policies\UserPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use DateTime;

class SolicitacaoPodaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($filtro, Request $request)
    {
        $this->authorize('index', SolicitacaoPoda::class);
        $busca = $request->buscar;

        $userPolicy = new UserPolicy();
        if ($userPolicy->isAnalistaPoda(auth()->user())) {
            if(!in_array($filtro, ['encaminhadas', 'concluidas'])) {
                $filtro = 'encaminhadas';
            }
            $concluidas = SolicitacaoPoda::where('analista_id', auth()->user()->id)
                ->whereHas('laudo')
                ->orderBy('created_at', 'DESC')
                ->paginate(20);
            $encaminhadas = SolicitacaoPoda::whereNotIn('id', $concluidas->pluck('id'))
                ->where('status', 4)
                ->where('analista_id', auth()->user()->id)
                ->orderBy('created_at', 'DESC')
                ->paginate(20);
            switch ($filtro) {
                case 'encaminhadas':
                    $solicitacoes = $encaminhadas;
                    break;
                case 'concluidas':
                    $solicitacoes = $concluidas;
                    break;
            }
            $analistas = User::analistasPoda();

            if($busca != null) {
                $usuarios = User::where('name', 'ilike', '%'. $busca .'%')->get();
                $usuarios = $usuarios->pluck('id');
                $requerentes = Requerente::whereIn('user_id', $usuarios);
                $requerentes = $requerentes->pluck('id');

                $enderecos = Endereco::where('rua', 'ilike', '%' . $busca . '%')->orWhere('bairro', 'ilike', '%' . $busca . '%')->orWhere('numero', 'ilike', '%' . $busca . '%')->get();
                $enderecos = $enderecos->pluck('id');

                $solicitacoes = SolicitacaoPoda::whereIn('requerente_id', $requerentes)
                                ->orWhereIn('endereco_id', $enderecos)->paginate(20);
            }

            return view('solicitacoes.podas.index', compact('filtro', 'analistas', 'solicitacoes', 'busca'));
        } else {
            if(!in_array($filtro, ['pendentes', 'deferidas', 'indeferidas', 'encaminhadas'])) {
                $filtro = 'pendentes';
            }
            switch ($filtro) {
                case 'pendentes':
                    $solicitacoes = SolicitacaoPoda::where('status', SolicitacaoPoda::STATUS_ENUM['registrada'])->orderBy('created_at', 'DESC')->paginate(20);
                    break;
                case 'deferidas':
                    $solicitacoes = SolicitacaoPoda::where('status', SolicitacaoPoda::STATUS_ENUM['deferido'])->orderBy('created_at', 'DESC')->paginate(20);
                    break;
                case 'indeferidas':
                    $solicitacoes = SolicitacaoPoda::where('status', SolicitacaoPoda::STATUS_ENUM['indeferido'])->orderBy('created_at', 'DESC')->paginate(20);
                    break;
                case 'encaminhadas':
                    $solicitacoes = SolicitacaoPoda::where('status', SolicitacaoPoda::STATUS_ENUM['encaminhada'])->orderBy('created_at', 'DESC')->paginate(20);
                    break;
            }
            $analistas = User::analistasPoda();

            if($busca != null) {
                $usuarios = User::where('name', 'ilike', '%'. $busca .'%')->get();
                $usuarios = $usuarios->pluck('id');
                $requerentes = Requerente::whereIn('user_id', $usuarios);
                $requerentes = $requerentes->pluck('id');
                
                $enderecos = Endereco::where('rua', 'ilike', '%' . $busca . '%')->orWhere('bairro', 'ilike', '%' . $busca . '%')->orWhere('numero', 'ilike', '%' . $busca . '%')->get();
                $enderecos = $enderecos->pluck('id');
                $solicitacoes = SolicitacaoPoda::whereIn('requerente_id', $requerentes)->orWhereIn('endereco_id', $enderecos)->paginate(20);
            }

            return view('solicitacoes.podas.index', compact('filtro', 'analistas', 'solicitacoes', 'busca'));
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
        $solicitacoes = SolicitacaoPoda::where('requerente_id', auth()->user()->requerente->id)->orderBy('created_at', 'DESC')->get();

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

        if($this->limiteSolicitacao($data, auth()->user()->requerente->id)){
            return redirect()->back()->with(['error' => 'No momento já existe uma solicitação de poda para este endereço em nosso sistema. Em breve daremos continuidade a sua solicitação.']);
        }

        if($this->tempoMinimo($data, auth()->user()->requerente->id)){
            return redirect()->back()->with(['error' => 'É necessário aguardar no mínimo um ano para solicitar uma nova poda, pois a árvore precisa recuperar sua estrutura novamente. 
                                Tente novamente após um ano da última solicitação para esse endereço.']);
        }

        $solicitacao = new SolicitacaoPoda();
        $solicitacao->fill($data);

        $endereco = new Endereco();
        $endereco->fill($data);
        $endereco->save();

        if($request->celular != null) {
            $telefone = new Telefone();
            $telefone->numero = $request->celular;
            $telefone->save();

            $solicitacao->telefone()->associate($telefone);
        }

        $solicitacao->endereco()->associate($endereco);
        $solicitacao->requerente_id = auth()->user()->requerente->id;
        $protocolo = null;
        do {
            $protocolo = substr(str_shuffle(Hash::make(date('Y-m-d H:i:s'))), 0, 20);
            $check = SolicitacaoPoda::where('protocolo', $protocolo)->first();
        } while ($check != null);
        $solicitacao->protocolo = $protocolo;
        $solicitacao->save();

        if (array_key_exists('imagem', $data)) {
            $count = count($data['imagem']);
            for ($i = 0; $i < $count; $i++) {
                $foto_poda = new FotoPoda();
                $foto_poda->solicitacao_poda_id = $solicitacao->id;
                $foto_poda->comentario = $data['comentarios'][$i] ?? '';
                $foto_poda->caminho = $data['imagem'][$i]->store("podas/{$solicitacao->id}/imagens");
                $foto_poda->save();
            }
        }
        Mail::to($solicitacao->requerente->user->email)->send(new SolicitacaoPodasCriada($solicitacao));

        return redirect()->back()->with(['success' => 'Solicitação de poda/supressão realizada com sucesso!', 'protocolo' => $protocolo]);
    }

    public function limiteSolicitacao($data, $requerente_id)
    {
        $requisicoes = SolicitacaoPoda::where([['requerente_id', $requerente_id], ['status', 1]])->get();
        $endereco = new Endereco();
        $endereco->fill($data);

        foreach($requisicoes as $requisicao){
            if($endereco->cep == $requisicao->endereco->cep && $endereco->numero == $requisicao->endereco->numero){
                return true;
            }
        }
        return false; 
    }

    public function tempoMinimo($data, $requerente_id)
    {
        $requisicoes = SolicitacaoPoda::where('requerente_id', $requerente_id)->get();
        $endereco = new Endereco();
        $endereco->fill($data);
        $dataAtual = new DateTime();

        foreach($requisicoes as $requisicao) {
            $requisicaoData = DateTime::createFromFormat('Y-m-d H:i:s', $requisicao->updated_at)->setTime(0, 0);

            $diferenca = $dataAtual->diff($requisicaoData);
            $anosDiferenca = $diferenca->y;

            if($endereco->cep == $requisicao->endereco->cep && $endereco->numero == $requisicao->endereco->numero
                && $anosDiferenca < 1) {
                return true;
            }
        }
        return false; 
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

    public function foto(SolicitacaoPoda $solicitacao, FotoPoda $foto)
    {
        $this->authorize('view', $solicitacao);

        return Storage::download($foto->caminho);
    }

    public function status(Request $request)
    {
        $solicitacao = SolicitacaoPoda::where('protocolo', $request->protocolo)->first();
        if ($solicitacao == null) {
            return redirect()->back()->with(['error' => 'Solicitação não encontrada. Verifique o protocolo informado.']);
        }

        return view('solicitacoes.podas.requerente.status', compact('solicitacao'));
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
            'analista' => 'required',
        ]);

        $solicitacao = SolicitacaoPoda::find($request->solicitacao_id_analista);
        $solicitacao->analista_id = $request->analista;
        $solicitacao->status = SolicitacaoPoda::STATUS_ENUM['encaminhada'];
        $solicitacao->update();

        Mail::to($solicitacao->requerente->user->email)->send(new SolicitacaoPodasEncaminhada($solicitacao));

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
        $data = $request->validated();
        $solicitacao->fill($data);
        if ($data['status'] == 2) {
            Notification::send($solicitacao->requerente->user, new ParecerSolicitacao($solicitacao, 'poda', 'deferida'));
        } elseif ($data['status'] == 3) {
            Notification::send($solicitacao->requerente->user, new ParecerSolicitacao($solicitacao, 'poda', 'indeferida', $data['motivo_indeferimento']));
        }
        $solicitacao->update();

        return redirect()->route('podas.index', 'pendentes')->with('success', 'Solicitação de poda/supressão avaliada com sucesso');
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
