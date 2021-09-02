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
        $requerimento = Requerimento::find($id);
        $this->authorize('view', $requerimento);
        $analistas = User::where('role', User::ROLE_ENUM['analista'])->get();

        return view('requerimento.show', compact('requerimento', 'analistas'));
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
     * Cancela um requerimento.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $requerimento = Requerimento::find($id);
        $this->authorize('delete', $requerimento);

        if ($requerimento->status > Requerimento::STATUS_ENUM['requerida']) {
            return redirect()->back()->withErrors(['error' => 'Este requerimento já está em andamento e não pode ser cancelado.']);
        }
        
        $requerimento->status = Requerimento::STATUS_ENUM['cancelada'];
        $requerimento->update();
    }

    /**
     * Atribui um analista a um requerimento.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function atribuirAnalista(Request $request) 
    {
        $this->authorize('isSecretario', User::class);
        $validated = $request->validate([
            'analista' => 'required',
            'requerimento' => 'required',
        ]);
        
        $analista = User::find($request->analista);
        $requerimento = Requerimento::find($request->requerimento);
        $requerimento->analista_id = $analista->id;
        $requerimento->status = Requerimento::STATUS_ENUM['em_andamento'];
        $requerimento->update();

        return redirect(route('requerimentos.index'))->with(['success' => "Requerimento nº " . $requerimento->id . " atribuido com sucesso a " . $analista->name]);
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
