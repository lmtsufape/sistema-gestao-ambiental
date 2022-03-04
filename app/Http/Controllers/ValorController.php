<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ValorRequerimento;
use App\Http\Requests\ValorRequest;

class ValorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('isSecretarioOrAnalista', User::class);
        $valores = ValorRequerimento::orderBy('created_at')->paginate(20);

        $potenciais_poluidores = ValorRequerimento::POTENCIAL_POLUIDOR_ENUM;
        $portes = ValorRequerimento::PORTE_ENUM;
        $tipos_licenca = ValorRequerimento::TIPO_LICENCA_ENUM;

        return view('valor.index', compact('valores', 'potenciais_poluidores', 'portes', 'tipos_licenca'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('isSecretarioOrAnalista', User::class);
        $potenciais_poluidores = ValorRequerimento::POTENCIAL_POLUIDOR_ENUM;
        $portes = ValorRequerimento::PORTE_ENUM;
        $tipos_licenca = ValorRequerimento::TIPO_LICENCA_ENUM;

        return view('valor.create', compact('potenciais_poluidores', 'portes', 'tipos_licenca'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ValorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValorRequest $request)
    {
        $this->authorize('isSecretarioOrAnalista', User::class);
        $request->validated();
        $valor = new ValorRequerimento();
        $valor->setAtributes($request);
        $valor->save();

        return redirect(route('valores.index'))->with(['success' => 'Valor de licença cadastrado com sucesso!']);
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
        $this->authorize('isSecretarioOrAnalista', User::class);
        $potenciais_poluidores = ValorRequerimento::POTENCIAL_POLUIDOR_ENUM;
        $portes = ValorRequerimento::PORTE_ENUM;
        $tipos_licenca = ValorRequerimento::TIPO_LICENCA_ENUM;
        $valor = ValorRequerimento::find($id);

        return view('valor.edit', compact('valor','potenciais_poluidores', 'portes', 'tipos_licenca'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\ValorRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ValorRequest $request, $id)
    {
        $this->authorize('isSecretarioOrAnalista', User::class);
        $request->validated();
        $valor = ValorRequerimento::find($id);
        $valor->setAtributes($request);
        $valor->save();

        return redirect(route('valores.index'))->with(['success' => 'Valor de licença atualizado com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isSecretarioOrAnalista', User::class);
        $valor = ValorRequerimento::find($id);
        $valor->delete();

        return redirect(route('valores.index'))->with(['success' => 'Valor de licença deletado com sucesso!']);
    }
}
