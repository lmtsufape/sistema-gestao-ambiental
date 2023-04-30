<?php

namespace App\Http\Controllers;

use App\Models\Denuncia;
use App\Models\Empresa;
use App\Models\FotoVisita;
use App\Models\Requerimento;
use App\Models\SolicitacaoPoda;
use App\Models\User;
use App\Models\Visita;
use App\Notifications\VisitaAlteradaPoda;
use App\Notifications\VisitaAlteradaRequerimento;
use App\Notifications\VisitaCanceladaPoda;
use App\Notifications\VisitaCanceladaRequerimento;
use App\Notifications\VisitaMarcadaPoda;
use App\Notifications\VisitaMarcadaRequerimento;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use PDF;


class VisitaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($filtro, $ordenacao, $ordem, Request $request)
    {
        $this->authorize('isSecretarioOrAnalista', User::class);
        $analistas = collect();
        if (auth()->user()->role == User::ROLE_ENUM['secretario']) {
            switch ($filtro) {
                case 'requerimento':
                    $analistas = User::analistas();
                    $visitas = Visita::whereHas('requerimento', function (Builder $qry) {
                        $qry->where('status', '!=', Requerimento::STATUS_ENUM['finalizada'])
                                ->where('cancelada', false);
                    });
                    $visitas = $this->ordenar($visitas, $filtro, $ordenacao, $ordem)->paginate(10);
                    break;
                case 'denuncia':
                    $analistas = User::analistas();
                    $visitas = Visita::where('denuncia_id', '!=', null);
                    $visitas = $this->ordenar($visitas, $filtro, $ordenacao, $ordem)->paginate(10);
                    break;
                case 'poda':
                    $analistas = User::analistasPoda();
                    $visitas = Visita::where('solicitacao_poda_id', '!=', null);
                    $visitas = $this->ordenar($visitas, $filtro, $ordenacao, $ordem)->paginate(10);
                    break;
                case 'finalizado':
                        $analistas = User::analistas();
                        $visitas = Requerimento::where([['status', Requerimento::STATUS_ENUM['finalizada']], ['cancelada', false]])->orderBy('created_at', 'DESC')->paginate(20);
                        $visitas = Visita::whereIn('requerimento_id', $visitas->pluck('id'))->paginate(20);
                        break;
            }
        } elseif (auth()->user()->role == User::ROLE_ENUM['analista']) {
            switch ($filtro) {
                case 'requerimento':
                    $visitas = Visita::whereHas('requerimento', function (Builder $qry) {
                        $qry->where('status', '!=', Requerimento::STATUS_ENUM)
                                ->where('cancelada', false);
                    })->where('analista_id', auth()->user()->id);
                    $visitas = $this->ordenar($visitas, $filtro, $ordenacao, $ordem)->paginate(10);
                    break;
                case 'denuncia':
                    $visitas = Visita::where([['denuncia_id', '!=', null], ['analista_id', auth()->user()->id]]);
                    $visitas = $this->ordenar($visitas, $filtro, $ordenacao, $ordem)->paginate(10);
                    break;
                case 'poda':
                    $visitas = Visita::where([['solicitacao_poda_id', '!=', null], ['analista_id', auth()->user()->id]]);
                    $visitas = $this->ordenar($visitas, $filtro, $ordenacao, $ordem)->paginate(10);
                    break;
                case 'finalizado':
                    $visitas = Requerimento::where([['status', Requerimento::STATUS_ENUM['finalizada']], ['cancelada', false]], ['analista_id', auth()->user()->id])->orderBy('created_at', 'DESC')->paginate(20);
                    $visitas = Visita::whereIn('requerimento_id', $visitas->pluck('id'))->paginate(20);
                        break;
            }
        }

        $busca = $request->buscar;
        if($busca != null) {
            $empresas = Empresa::where('nome', 'ilike', '%'. $busca .'%')->get();
            $empresas = $empresas->pluck('id');

            $requerimentos = Requerimento::whereIn('empresa_id', $empresas);
            $requerimentos = $requerimentos->pluck('id');

            $visitas = Visita::whereIn('requerimento_id', $requerimentos)->paginate(20);
        }

        return view('visita.index', compact('visitas', 'filtro', 'analistas', 'ordenacao', 'ordem', 'busca'));
    }

    private function ordenar($qry,$filtro, $ordenacao, $ordem)
    {

        switch ($ordenacao) {
            case 'created_at':
                $qry = $qry->orderBy($ordenacao, $ordem);
                break;
            case 'data_marcada':
                $qry = $qry->orderBy($ordenacao, $ordem);
                break;
            case 'data_realizada':
                $qry = $qry->orderBy($ordenacao, $ordem);
                break;
            case 'empresa':
                switch ($filtro) {
                    case 'requerimento':
                        $qry->orderBy(
                            Empresa::join('requerimentos', 'empresas.id', 'requerimentos.empresa_id')
                                ->whereColumn('visitas.requerimento_id', 'requerimentos.id')
                                ->select('empresas.nome'),
                            $ordem
                        );
                        break;
                    case 'denuncia':
                        $qry->orderBy(
                            Denuncia::leftJoin('empresas', 'empresas.id', 'denuncias.empresa_id')
                                ->whereColumn('visitas.denuncia_id', 'denuncias.id')
                                ->select(DB::raw("CASE WHEN denuncias.empresa_id IS NULL THEN denuncias.empresa_nao_cadastrada ELSE empresas.nome END AS nome")),
                            $ordem
                        );
                        break;
                }
                break;
            case 'analista':
                $qry->orderBy(
                    User::select('name')->whereColumn('users.id', 'visitas.analista_id'),
                    $ordem
                );
                break;
            case 'requerente':
                $qry->orderBy(
                    User::join('requerentes', 'users.id', 'requerentes.user_id')
                        ->join('solicitacoes_podas', 'requerentes.id', 'solicitacoes_podas.requerente_id')
                        ->whereColumn('solicitacoes_podas.id', 'visitas.solicitacao_poda_id')
                        ->select('users.name'),
                    $ordem
                );
                break;
        }
        return $qry->orderBy('created_at', 'DESC');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('isSecretario', User::class);
        $requerimentos = Requerimento::where([['status', '=', Requerimento::STATUS_ENUM['documentos_aceitos']], ['cancelada', false]])->orderBy('created_at', 'ASC')->get();
        $analistas = User::analistas();

        return view('visita.create', compact('requerimentos', 'analistas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('isSecretario', User::class);
        $request->validate([
            'data_marcada' => 'required|date',
            'requerimento' => 'required',
            'analista' => 'required',
        ]);

        $visita = new Visita();
        $visita->setAtributesRequerimento($request);
        $visita->requerimento->status = Requerimento::STATUS_ENUM['visita_marcada'];
        $visita->requerimento->update();
        $visita->analista_id = $request->analista;
        $visita->save();

        $requerimento = Requerimento::find($request['requerimento']);
        $requerimento->analista_processo_id = $request->analista;
        $requerimento->update();
        $user = $requerimento->empresa->user;
        $data_marcada = $request['data_marcada'];
        Notification::send($user, new VisitaMarcadaRequerimento($requerimento, $data_marcada));

        return redirect(route('visitas.index', ['filtro' => 'requerimento', 'ordenacao' => 'data_marcada', 'ordem' => 'DESC']))->with(['success' => 'Visita programada com sucesso!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Visita  $visita
     * @return \Illuminate\Http\Response
     */
    public function show(Visita $visita)
    {
        //
    }

    public function foto(Visita $visita, FotoVisita $foto)
    {
        $this->authorize('view', $visita);

        return Storage::download($foto->caminho);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Visita  $visita
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('isSecretario', User::class);
        $visita = Visita::find($id);
        $requerimentos = collect();
        $requerimentos->push($visita->requerimento);
        $analistas = User::analistas();

        return view('visita.edit', compact('visita', 'requerimentos', 'analistas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Visita  $visita
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('isSecretario', User::class);
        $visita = Visita::find($id);

        if ($visita->data_realizada != null) {
            return redirect()->back()->with(['error' => 'Você não pode editar uma visita já realizada.']);
        }

        $request->validate([
            'data_marcada' => 'required|date',
            'requerimento' => 'required',
            'analista' => 'required',
        ]);

        if ($visita->requerimento_id != $request->requerimento) {
            $visita->requerimento->update(['status' => Requerimento::STATUS_ENUM['documentos_aceitos']]);
        }
        $visita->setAtributesRequerimento($request);
        $visita->analista_id = $request->analista;
        $visita->update();

        if ($visita->requerimento) {
            $requerimento = Requerimento::find($request['requerimento']);
            $user = $requerimento->empresa->user;
            $data_marcada = $request['data_marcada'];
            Notification::send($user, new VisitaAlteradaRequerimento($requerimento, $data_marcada));
        } elseif ($visita->solicitacaoPoda) {
            $poda = $visita->solicitacaoPoda;
            $user = $poda->requerente->user;
            $data_marcada = $request['data_marcada'];
            Notification::send($user, new VisitaAlteradaPoda($poda, $data_marcada));
        }

        $requerimento = Requerimento::find($visita->requerimento_id);
        $requerimento->update(['status' => Requerimento::STATUS_ENUM['visita_marcada']]);

        return redirect(route('visitas.index', ['filtro' => 'requerimento', 'ordenacao' => 'data_marcada', 'ordem' => 'DESC']))->with(['success' => 'Visita editada com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Visita  $visita
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isSecretario', User::class);
        $visita = Visita::find($id);
        if ($visita->requerimento_id != null) {
            if ($visita->requerimento->status == Requerimento::STATUS_ENUM['visita_realizada'] || $visita->requerimento->status == Requerimento::STATUS_ENUM['finalizada']) {
                return redirect()->back()->with(['error' => 'As informações desta visita não podem ser excluídas.']);
            } else {
                $visita->requerimento->status = Requerimento::STATUS_ENUM['documentos_aceitos'];
                $visita->requerimento->update();
            }
        }

        if ($visita->requerimento) {
            $requerimento = $visita->requerimento;
            $user = $requerimento->empresa->user;
            $data_marcada = $visita->data_marcada;
            Notification::send($user, new VisitaCanceladaRequerimento($requerimento, $data_marcada));
        } elseif ($visita->solicitacaoPoda) {
            $poda = $visita->solicitacaoPoda;
            $user = $poda->requerente->user;
            $data_marcada = $visita->data_marcada;
            Notification::send($user, new VisitaCanceladaPoda($poda, $data_marcada));
        }

        $visita->delete();

        return redirect(route('visitas.index', ['filtro' => 'requerimento', 'ordenacao' => 'data_marcada', 'ordem' => 'DESC']))->with(['success' => 'Visita deletada com sucesso!']);
    }

    /**
     * Cria uma visita para o analista especificado da denúncia selecionada.
     *
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createVisitaDenuncia(Request $request)
    {
        $this->authorize('isSecretario', User::class);
        $request->validate([
            'data' => 'required',
            'analista' => 'required',
        ]);

        $visita = new Visita();
        $visita->data_marcada = $request->data;
        $visita->denuncia_id = $request->denuncia_id;
        $visita->analista_id = $request->analista;
        $visita->save();

        return redirect(route('denuncias.index', 'pendentes'))->with(['success' => 'Visita agendada com sucesso!']);
    }

    /**
     * Edita o analista e data de uma visita.
     *
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function editVisita(Request $request)
    {
        $this->authorize('isSecretario', User::class);
        $visita = Visita::find($request->visita_id);
        if ($visita->data_realizada != null) {
            return redirect()->back()->with(['error' => 'Você não pode editar uma visita já realizada.']);
        } else {
            $request->validate([
                'data' => 'required|date',
                'analista' => 'required',
            ]);
        }

        $visita->data_marcada = $request->data;
        $visita->analista_id = $request->analista;
        $visita->save();

        if($request->filtro){
            return redirect()->back()->with(['success' => 'Visita editada com sucesso!']);
        }

        return redirect(route('visitas.index', ['filtro' => $request->filtro, 'ordenacao' => 'data_marcada', 'ordem' => 'DESC']))->with(['success' => 'Visita editada com sucesso!']);
    }

    /**
     * Recupera as informações básicas de uma visita agendada.
     *
     * @param  Illuminate\Http\Request  $request
     */
    public function infoVisita(Request $request)
    {
        $this->authorize('isSecretario', User::class);

        $visita = Visita::find($request->visita_id);

        $visitaInfo = [
            'id' => $visita->id,
            'analista_visita' => $visita->analista,
            'marcada' => $visita->data_marcada,
            'realizada' => $visita->data_realizada,
        ];

        return response()->json($visitaInfo);
    }

    public function createVisitaSolicitacaoPoda(Request $request)
    {
        $request->validate([
            'data' => 'required',
            'analista' => 'required',
            'solicitacao_id' => 'required',
        ]);

        $visita = new Visita();
        $visita->data_marcada = $request->data;
        $visita->solicitacao_poda_id = $request->solicitacao_id;
        $visita->analista_id = $request->analista;
        $visita->save();

        $poda = SolicitacaoPoda::find($request['solicitacao_id']);
        $user = $poda->requerente->user;
        $data_marcada = $request['data'];
        Notification::send($user, new VisitaMarcadaPoda($poda, $data_marcada));

        return redirect()->back()->with(['success' => 'Visita agendada com sucesso!']);
    }

    /**
     * Gera o relátorio das visitas do dia.
     *
     * @return PDF
     */
    public function gerarRelatorioVisitas()
    {
        $visitas = Visita::all();

        $pdf = PDF::loadview('pdf/visitas', ['visitas' => $visitas]);

        return $pdf->setPaper('a4')->stream('visitas.pdf');
    }
}