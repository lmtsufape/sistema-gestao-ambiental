<?php

namespace App\Http\Controllers;

use App\Models\Telefone;
use App\Models\Endereco;
use App\Models\Feirante;
use Illuminate\Http\Request;
use App\Models\User;

class FeiranteController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('isAnalista', User::class);
        return view('feirantes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('isAnalista', User::class);
        $input = $request->all();

        $feirante = new Feirante();
        $endereco_residencia = new Endereco();
        $endereco_comercio = new Endereco();
        $telefone = new Telefone();

        // Modificando os atributos nulos endereço residencial
        $input['cep'] = $input['cep'] ?? '55299-899';
        $input['numero'] = $input['numero'] ?? 's/n';
        $input['bairro'] = $input['bairro'] ?? $input['rua'];
        $input['complemento'] = $input['complemento'] ?? '';

        // Modificando os atributos nulos endereço do comércio
        $input['cep_comercio'] = $input['cep_comercio'] ?? '55299-899';
        $input['numero_comercio'] = $input['numero_comercio'] ?? 's/n';
        $input['bairro_comercio'] = $input['bairro_comercio'] ?? $input['rua'];
        $input['complemento_comercio'] = $input['complemento_comercio'] ?? '';

        $endereco_residencia->setAtributes($input);
        $endereco_residencia->save();

        $endereco_comercio->setAtributesComercio($input);
        $endereco_comercio->save();

        $telefone->setNumero($input['celular']);
        $telefone->save();

        $feirante->setAtributes($input);
        $feirante->endereco_residencia_id = $endereco_residencia->id;
        $feirante->endereco_comercio_id = $endereco_comercio->id;
        $feirante->telefone_id = $telefone->id;
        $feirante->save();

        return redirect(route('feirantes.create'))->with(['success' => 'Feirante cadastrado com sucesso!']);
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
