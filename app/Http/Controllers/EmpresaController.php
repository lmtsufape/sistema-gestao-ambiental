<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EmpresaRequest;
use App\Models\User;
use App\Models\Setor;
use App\Models\Empresa;
use App\Models\Endereco;
use App\Models\Telefone;
use App\Models\Cnae;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('isRequerente', User::class);
        $empresas = auth()->user()->empresas;

        return view('empresa.index', compact('empresas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('isRequerente', User::class);
        $setores = Setor::orderBy('nome')->get();

        return view('empresa.create', compact('setores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\EmpresaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmpresaRequest $request)
    {
        $this->authorize('isRequerente', User::class);
        $enderecoEmpresa = new Endereco();
        $telefoneEmpresa = new Telefone();
        $empresa = new Empresa();
        $enderecoEmpresa->setAtributesEmpresa($request->all());
        $enderecoEmpresa->save();
        $telefoneEmpresa->setNumero($request->celular_da_empresa);
        $telefoneEmpresa->save();
        $empresa->setAtributes($request->all());
        $empresa->user_id = auth()->user()->id;
        $empresa->endereco_id = $enderecoEmpresa->id;
        $empresa->telefone_id = $telefoneEmpresa->id;
        $empresa->save();

        foreach ($request->cnaes_id as $cnae_id) {
            $empresa->cnaes()->attach((Cnae::find($cnae_id)));
        }

        return redirect(route('empresas.index'))->with(['success' => 'Empresa cadastrada com sucesso!']);
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
        //
    }
}
