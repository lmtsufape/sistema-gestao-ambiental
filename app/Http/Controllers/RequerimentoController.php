<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Requerimento;
use App\Http\Requests\RequerimentoRequest;

class RequerimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $requerimentos = null;
        $primeiroRequerimento = $this->primeiroRequerimento();
        if ($user->role == User::ROLE_ENUM['requerente']) {
            $requerimentos = Requerimento::where('empresa_id', $user->empresa->id)->get();
        } else {
            $requerimentos = Requerimento::all();
        }
        return view('requerimento.index', compact('requerimentos', 'primeiroRequerimento'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequerimentoRequest $request)
    {
        $request->validated();
        $primeiroRequerimento = Requerimento::where([['empresa_id', auth()->user()->empresa->id], ['tipo', $request->tipo, ['status', Requerimento::STATUS_ENUM['requerida']]]])->get();
        if ($primeiroRequerimento->count() > 0) {
            return redirect()->back()->withErrors(['tipo' => 'Você já tem um requerimento pendente.', 'error_modal' => 1]);
        }

        $requerimento = new Requerimento;
        $requerimento->tipo = $request->tipo;
        $requerimento->status = Requerimento::STATUS_ENUM['requerida'];
        $requerimento->empresa_id = auth()->user()->empresa->id;
        $requerimento->save();

        return redirect(route('requerimentos.index'))->with(['success' => 'Requerimento realizado com sucesso.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $requerimento = Requerimento::find($id);

        if ($requerimento->status > Requerimento::STATUS_ENUM['requerida']) {
            return redirect()->back()->withErrors(['error' => 'Este requerimento já está em andamento e não pode ser cancelado.']);
        }
        
        $requerimento->status = Requerimento::STATUS_ENUM['cancelada'];
        $requerimento->update();
    }

    /**
     * Checa se é a primeira licença do usuário.
     *
     * @return boolean
     */
    private function primeiroRequerimento()
    {
        if (auth()->user()->role == User::ROLE_ENUM['requerente']) {
            $requerimentos = Requerimento::where('empresa_id', auth()->user()->empresa->id)->get();
            if ($requerimentos->count() > 0) {
                return false;
            } 
            return true;
        } 
        return false;
    }
}
