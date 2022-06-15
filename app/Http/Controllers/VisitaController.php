<?php

namespace App\Http\Controllers;

use App\Models\FotoVisita;
use App\Models\Requerimento;
use App\Models\Visita;
use App\Models\User;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDF;

class VisitaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('isSecretarioOrAnalista', User::class);
        $visitas = collect();
        if (auth()->user()->role == User::ROLE_ENUM['secretario']) {
            $visitas = Visita::orderBy('data_marcada', 'DESC')->paginate(10);
        } else if (auth()->user()->role == User::ROLE_ENUM['analista']) {
            $visitas = Visita::where('analista_id', auth()->user()->id)->orderBy('data_marcada', 'DESC')->paginate(10);
        }

        return view('visita.index', compact('visitas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('isSecretario', User::class);
        $requerimentos = Requerimento::where([['status', '>=', Requerimento::STATUS_ENUM['documentos_aceitos']], ['status', '<=', Requerimento::STATUS_ENUM['visita_realizada']]])->orderBy('created_at', 'ASC')->get();
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
            'analista'     => 'required',
        ]);

        $visita = new Visita();
        $visita->setAtributesRequerimento($request);
        $visita->requerimento->status = Requerimento::STATUS_ENUM['visita_marcada'];
        $visita->requerimento->update();
        $visita->analista_id = $request->analista;
        $visita->save();

        return redirect(route('visitas.index'))->with(['success' => 'Visita programada com sucesso!']);
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
        $requerimentos = Requerimento::where('status', Requerimento::STATUS_ENUM['documentos_aceitos'])->orderBy('created_at', 'ASC')->get();
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

        $request->validate([
            'data_marcada' => 'required|date',
            'requerimento' => 'required',
            'analista'     => 'required',
        ]);

        if ($visita->requerimento_id != $request->requerimento) {
            $visita->requerimento->update(['status' => Requerimento::STATUS_ENUM['documentos_aceitos']]);
        }
        $visita->setAtributesRequerimento($request);
        $visita->analista_id = $request->analista;
        $visita->update();

        $requerimento = Requerimento::find($visita->requerimento_id);
        $requerimento->update(['status' => Requerimento::STATUS_ENUM['visita_marcada']]);

        return redirect(route('visitas.index'))->with(['success' => 'Visita editada com sucesso!']);
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
        if($visita->requerimento_id != null){
            if($visita->requerimento->status == Requerimento::STATUS_ENUM['visita_realizada'] || $visita->requerimento->status == Requerimento::STATUS_ENUM['finalizada']){
                return redirect()->back()->with(['error' => "As informações desta visita não podem ser excluídas."]);
            }else{
                $visita->requerimento->status = Requerimento::STATUS_ENUM['documentos_aceitos'];
                $visita->requerimento->update();
            }
        }
        $visita->delete();

        return redirect(route('visitas.index'))->with(['success' => 'Visita deletada com sucesso!']);
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
            'analista' => 'required'
        ]);

        $visita = new Visita();
        $visita->data_marcada = $request->data;
        $visita->denuncia_id = $request->denuncia_id;
        $visita->analista_id = $request->analista;
        $visita->save();

        return redirect(route('denuncias.index', 'pendentes'))->with(['success' => 'Visita agendada com sucesso!']);
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
