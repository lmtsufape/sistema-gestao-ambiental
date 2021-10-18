<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Requerimento;
use App\Http\Requests\LicencaRequest;
use App\Models\Licenca;

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
        $requerimento = Requerimento::find($id);
        
        return view('licenca.create', compact('requerimento'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\LicencaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LicencaRequest $request)
    {
        $requerimento = Requerimento::find($request->requerimento);
        
        $licenca = new Licenca();
        $licenca->setAtributes($request, $requerimento);

        $requerimento->status = Requerimento::STATUS_ENUM['finalizada'];
        $requerimento->update();

        return redirect(route('visitas.index'))->with(['success' => 'Licença emitida com sucesso!']);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
}
