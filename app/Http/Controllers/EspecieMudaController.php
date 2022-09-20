<?php

namespace App\Http\Controllers;

use App\Models\EspecieMuda;
use Illuminate\Http\Request;

class EspecieMudaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('isSecretarioOrDefinirMudas', User::class);

        $especies = EspecieMuda::orderBy('nome')->paginate(20);

        return view('solicitacoes.mudas.especie.index', compact('especies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('isSecretarioOrDefinirMudas', User::class);

        return view('solicitacoes.mudas.especie.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('isSecretarioOrDefinirMudas', User::class);

        $validator = $request->validate([
            'nome' => 'required|string|max:200',
        ]);

        $especie = new EspecieMuda();
        $especie->setAtributes($request);
        $especie->save();

        return redirect(route('especies.index'))->with(['success' => 'Espécie cadastrada com sucesso!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EspecieMuda  $especieMuda
     * @return \Illuminate\Http\Response
     */
    public function show(EspecieMuda $especieMuda)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EspecieMuda  $especieMuda
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('isSecretarioOrDefinirMudas', User::class);

        $especie = EspecieMuda::find($id);

        return view('solicitacoes.mudas.especie.edit', compact('especie'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EspecieMuda  $especieMuda
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('isSecretarioOrDefinirMudas', User::class);

        $especie = EspecieMuda::find($id);

        $validator = $request->validate([
            'nome' => 'required|string|max:200',
        ]);

        $especie->setAtributes($request);
        $especie->update();

        return redirect(route('especies.index'))->with(['success' => 'Espécie editada com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EspecieMuda  $especieMuda
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isSecretarioOrDefinirMudas', User::class);

        $especie = EspecieMuda::find($id);

        if ($especie->solicitacoes()->first() != null) {
            return redirect()->back()->with(['error' => 'Existem solicitações de mudas desta espécie.']);
        }

        $especie->delete();

        return redirect(route('especies.index'))->with(['success' => 'Espécie deletada com sucesso!']);
    }
}
