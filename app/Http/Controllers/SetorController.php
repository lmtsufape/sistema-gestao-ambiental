<?php

namespace App\Http\Controllers;

use App\Models\Setor;
use Illuminate\Http\Request;

class SetorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setores = Setor::orderBy('nome')->get();
        return view('setor.index', compact('setores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('setor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'nome'      => 'required|string',
            'descricao' => 'required|string',
        ]);

        $setor = new Setor();
        $setor->setAtributes($request);
        $setor->save();

        return redirect(route('setores.index'))->with(['success' => 'Setor cadastrado com sucesso!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setor  $setor
     * @return \Illuminate\Http\Response
     */
    public function show(Setor $setor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setor  $setor
     * @return \Illuminate\Http\Response
     */
    public function edit(Setor $setor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setor  $setor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setor $setor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setor  $setor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $setor = Setor::find($id);
        $setor->delete();

        return redirect(route('setores.index'))->with(['success' => 'Setor deletado com sucesso!']);
    }
}
