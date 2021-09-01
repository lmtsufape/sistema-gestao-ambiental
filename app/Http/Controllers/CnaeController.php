<?php

namespace App\Http\Controllers;

use App\Models\Cnae;
use App\Models\Setor;
use Illuminate\Http\Request;

class CnaeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cnaes = Cnae::orderBy('nome')->get();
        return view('cnae.index', compact('cnaes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $setor = Setor::find($id);
        return view('cnae.create', compact('setor'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (strlen($request->codigo) < 7) {
            return redirect()->back()->withErrors(['error' => 'O tamanho do código é menor que 8 dígitos!']);
        }

        $validator = $request->validate([
            'nome'      => 'required|string',
            'codigo'    => 'required|string|unique:cnaes,codigo',
            'potencial_poluidor' => 'required',
        ]);

        $cnae = new Cnae();
        $cnae->setAtributes($request);
        $cnae->setor_id = $request->setor;
        $cnae->potencial_poluidor = Cnae::POTENCIAL_POLUIDOR_ENUM[$request->potencial_poluidor];
        $cnae->save();

        return redirect(route('setores.show', ['setore' => $request->setor]))->with(['success' => 'Cnae cadastrado com sucesso!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cnae  $cnae
     * @return \Illuminate\Http\Response
     */
    public function show(Cnae $cnae)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cnae  $cnae
     * @return \Illuminate\Http\Response
     */
    public function edit(Cnae $cnae)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cnae  $cnae
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cnae $cnae)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cnae  $cnae
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cnae = Cnae::find($id);
        $setor = Setor::find($cnae->setor_id);
        $cnae->delete();

        return redirect(route('setores.show', ['setore' => $setor->id]))->with(['success' => 'Cnae deletado com sucesso!']);
    }
}
