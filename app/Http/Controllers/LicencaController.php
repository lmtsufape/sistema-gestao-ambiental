<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Requerimento;
use App\Http\Requests\LicencaRequest;
use App\Models\Licenca;
use App\Models\Visita;
use App\Models\User;

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
    public function create($id)
    {
        $visita = Visita::find($id);
        $this->authorize('isSecretario', User::class);

        $requerimento = $visita->requerimento;

        return view('licenca.create', compact('requerimento', 'visita'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\LicencaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LicencaRequest $request)
    {
        $visita = Visita::find($request->visita);
        $this->authorize('isSecretario', User::class);

        $requerimento = Requerimento::find($request->requerimento);

        $licenca = new Licenca();
        $licenca->setAtributes($request, $requerimento);

        $requerimento->update();

        return redirect(route('visitas.index'))->with(['success' => 'Licença criada com sucesso!']);
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

    /**
     * Mostra a tela de revisar licença para um analista.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function revisar($licenca_id, $visita_id)
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
            'licença'   => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $licenca = Licenca::find($id);
        $licenca->tipo = $request->input('tipo_de_licença');
        $licenca->validade = $request->data_de_validade;
        $licenca->status = Licenca::STATUS_ENUM['gerada'];

        if ($request->file('licença') != null) {
            $licenca->caminho = $licenca->salvarLicenca($request->file('licença'), $licenca->requerimento);
        }

        $licenca->update();

        return redirect(route('visitas.index'))->with(['success' => 'Licença atualizada com sucesso!']);
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
    public function salvar_revisao(Request $request, $licenca_id, $visita_id) 
    {
        $visita = Visita::find($visita_id);
        $this->authorize('analistaDaVisita', $visita);

        $request->validate([
            'status' => 'required',
        ]);
        
        $licenca = Licenca::find($licenca_id);
        if ($request->status == 1) {
            $licenca->status = Licenca::STATUS_ENUM['aprovada'];
        } else {
            $licenca->status = Licenca::STATUS_ENUM['revisar'];
            $licenca->comentario_revisao = $request->motivo;
        }

        $licenca->update();

        return redirect(route('visitas.index'))->with(['success' => 'Licença revisada com sucesso!']);
    }
}
