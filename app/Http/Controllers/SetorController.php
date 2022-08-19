<?php

namespace App\Http\Controllers;

use App\Models\Cnae;
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
        $this->authorize('isSecretario', User::class);

        $setores = Setor::orderBy('nome')->paginate(20);

        return view('setor.index', compact('setores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('isSecretario', User::class);

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
        $this->authorize('isSecretario', User::class);

        $validator = $request->validate([
            'nome' => 'required|string',
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
    public function show($id)
    {
        $this->authorize('isSecretario', User::class);

        $setor = Setor::find($id);
        $cnaes = Cnae::where('setor_id', '=', $setor->id)->orderBy('nome', 'ASC')->paginate(20);

        return view('setor.show', compact('setor', 'cnaes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setor  $setor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('isSecretario', User::class);

        $setor = Setor::find($id);

        return view('setor.edit', compact('setor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setor  $setor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('isSecretario', User::class);

        $setor = Setor::find($id);

        $validator = $request->validate([
            'nome' => 'required|string',
            'descricao' => 'required|string',
        ]);

        $setor->setAtributes($request);
        $setor->update();

        return redirect(route('setores.index'))->with(['success' => 'Setor editado com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setor  $setor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isSecretario', User::class);

        $setor = Setor::find($id);

        if ($setor->existemEmpresas()) {
            return redirect()->back()->withErrors(['error' => 'Existem cnaes deste setor que estão ligados a empresas, logo o setor não pode ser deletado.']);
        }

        $setor->deletarCnaes();
        $setor->delete();

        return redirect(route('setores.index'))->with(['success' => 'Setor deletado com sucesso!']);
    }

    public function ajaxCnaes(Request $request)
    {
        $cnaes = Cnae::where('setor_id', '=', $request->setor_id)->orderBy('nome', 'ASC')->get();
        $data = [
            'success' => true,
            'cnaes' => $cnaes,
        ];
        echo json_encode($data);
    }
}
