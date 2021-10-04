<?php

namespace App\Http\Controllers;

use App\Models\Requerimento;
use App\Models\Visita;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\TipoAnalista;

class VisitaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $visitas = collect();
        if (auth()->user()->role == User::ROLE_ENUM['secretario']) {
            $visitas = Visita::orderBy('data_marcada')->get();
        } else if (auth()->user()->role == User::ROLE_ENUM['analista']) {
            $visitas = auth()->user()->visitas;
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
        $requerimentos = Requerimento::where([['status', '>=', Requerimento::STATUS_ENUM['documentos_aceitos']], ['status', '<=', Requerimento::STATUS_ENUM['visita_realizada']]])->orderBy('created_at', 'ASC')->get();
        $analistas = $this->analistas();
        
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
        $request->validate([
            'data_marcada' => 'required|date',
            'requerimento' => 'required',
            'analista'     => 'required',
        ]);

        $visita = new Visita();
        $visita->setAtributesRequerimento($request);
        $visita->requerimento->update(['status' => Requerimento::STATUS_ENUM['visita_marcada']]);
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Visita  $visita
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $visita = Visita::find($id);
        $requerimentos = Requerimento::where('status', Requerimento::STATUS_ENUM['documentos_aceitos'])->orderBy('created_at', 'ASC')->get();
        $requerimentos->push($visita->requerimento);
        return view('visita.edit', compact('visita', 'requerimentos'));
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
        $visita = Visita::find($id);

        $request->validate([
            'data_marcada' => 'required|date',
            'requerimento' => 'required',
        ]);

        if ($visita->requerimento_id != $request->requerimento) {
            $visita->requerimento->update(['status' => Requerimento::STATUS_ENUM['documentos_aceitos']]);
        }
        $visita->setAtributesRequerimento($request);
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
        $visita = Visita::find($id);
        $visita->delete();

        return redirect(route('visitas.index'))->with(['success' => 'Visita deletada com sucesso!']);
    }

    /**
     * Retorna todos os analistas do sistema.
     *
     * @return collect \App\Models\User $analistas
     */
    private function analistas() 
    {
        $analistas = collect();
        $users = User::where('role', User::ROLE_ENUM['analista'])->get();
        
        foreach ($users as $analista) {
            if ($analista->tipo_analista()->where('tipo', TipoAnalista::TIPO_ENUM['processo'])->get()->count() > 0) {
                $analistas->push($analista);
            }
        }

        return $analistas;
    }
}
