<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visita;
use App\Models\Relatorio;
use App\Models\Requerimento;
use App\Http\Requests\RelatorioRequest;

class RelatorioController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $this->authorize('isSecretarioOrAnalista', User::class);
        $visita = Visita::find($id);
        return view('relatorio.create', compact('visita'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\RelatorioRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RelatorioRequest $request)
    {
        $this->authorize('isSecretarioOrAnalista', User::class);
        $visita = Visita::find($request->visita);
        $request->validated();
        $relatorio = new Relatorio();
        $relatorio->setAtributes($request);
        $relatorio->save();

        $requerimento = $visita->requerimento;
        $requerimento->status = Requerimento::STATUS_ENUM['visita_realizada'];
        $visita->update(['data_realizada' => now()]);
        $requerimento->update();

        return redirect(route('visitas.index'))->with(['success' => 'Relátorio salvo com sucesso!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('isSecretarioOrAnalista', User::class);
        $relatorio = Relatorio::find($id);
        return view('relatorio.show', compact('relatorio'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('isSecretarioOrAnalista', User::class);
        $relatorio = Relatorio::find($id);
        return view('relatorio.edit', compact('relatorio'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\RelatorioRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RelatorioRequest $request, $id)
    {
        $this->authorize('isSecretarioOrAnalista', User::class);
        $relatorio = Relatorio::find($id);
        $request->validated();
        $relatorio->setAtributes($request);
        $relatorio->motivo_edicao = null;
        $relatorio->update();

        return redirect(route('visitas.index'))->with(['success' => 'Relátorio atualizado com sucesso!']);
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

    public function resultado(Request $request, $id)
    {
        $this->authorize('isSecretario', User::class);
        $relatorio = Relatorio::find($id);
        $resultado = (boolean)$request->aprovacao;
        $relatorio->motivo_edicao = $request->motivo;

        $msg = "";
        if ($resultado) {
            $relatorio->aprovacao = Relatorio::APROVACAO_ENUM['aprovado'];
            $msg = "Relatório aprovado com sucesso!";
        } else {
            $relatorio->aprovacao = Relatorio::APROVACAO_ENUM['reprovado'];
            $msg = "Relatório reprovado com sucesso!";
        }

        $relatorio->update();

        return redirect(route('relatorios.show', ['relatorio' => $relatorio->id]))->with(['success' => $msg]);
    }
}
