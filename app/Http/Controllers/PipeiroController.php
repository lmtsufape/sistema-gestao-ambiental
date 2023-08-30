<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SolicitacaoServico;
use Illuminate\Http\Request;
use App\Models\Pipeiro;

class PipeiroController extends Controller
{

    public function index(Request $request)
    {
        $this->authorize('isSecretarioOrBeneficiario', User::class);

        $motoristas = Pipeiro::all();

        return view('pipeiro.index', compact('motoristas'));
    }

    public function create()
    {
        $this->authorize('isSecretarioOrBeneficiario', User::class);

        return view('pipeiro.create');
    }

    public function store(Request $request)
    {
        $this->authorize('isSecretarioOrBeneficiario', User::class);

        $pipeiro = new Pipeiro();
        $pipeiro->setAtributes($request);
        $pipeiro->save();

        return redirect()->route('pipeiros.index')->with('sucess', 'Motorista cadastrado com sucesso!');
    }

    public function show($id)
    {
        $this->authorize('isSecretarioOrBeneficiario', User::class);

       $pipeiro = Pipeiro::find($id);

        return view('pipeiro.show', compact('pipeiro'));
    }

    public function edit($id)
    {
        $this->authorize('isSecretarioOrBeneficiario', User::class);

        $pipeiro = Pipeiro::find($id);

        return view('pipeiro.edit', compact('pipeiro'));
    }

    public function update(Request $request, $id)
    {
        $this->authorize('isSecretarioOrBeneficiario', User::class);

        $pipeiro = Pipeiro::find($id);
        $pipeiro->setAtributes($request);
        $pipeiro->update();

        return redirect()->route('pipeiros.index')->with('success', 'Motorista atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $this->authorize('isSecretarioOrBeneficiario', User::class);

        $pipeiro = Pipeiro::find($id);
        $solicitacao_servico = SolicitacaoServico::where('pipeiro_id', $pipeiro->id)->first();
        if($solicitacao_servico == null)
            $pipeiro->delete();
        else{
            return redirect()->route('pipeiros.index')->with('error', 'Não é possível excluir um motorista que está vinculado a uma solicitação!');
        }
    }
}
