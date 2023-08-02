<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Beneficiario;
use App\Models\Endereco;
use App\Models\Telefone;
use App\Models\User;
use Illuminate\Http\Request;

class BeneficiarioController extends Controller
{
    public function index(Request $request)
{
    $this->authorize('isSecretarioOrBeneficiario', User::class);

    $buscar = $request->input('buscar');

    if ($buscar != null) {
        $beneficiario = Beneficiario::where('nome', 'LIKE', "%{$buscar}%")->get();
    } else {
        $beneficiario = Beneficiario::all()->sortBy('nome');
    }

    return view('beneficiarios.index', compact('beneficiario', 'buscar'));
    }


    public function create()
    {
        $this->authorize('isSecretarioOrBeneficiario', User::class);
        return view('beneficiarios.create');
    }

    public function edit($id)
    {
        $this->authorize('isSecretarioOrBeneficiario', User::class);
        $beneficiario = Beneficiario::find($id);
        $endereco = Endereco::find($beneficiario->endereco_id);
        $telefone = Telefone::find($beneficiario->telefone_id);
        return view('beneficiarios.edit', compact('beneficiario', 'endereco', 'telefone'));
    }

    public function store(Request $request)
    {       
        $this->authorize('isSecretarioOrBeneficiario', User::class);
        $input = $request->all();

        $beneficiario = new Beneficiario();
        $endereco = new Endereco();
        $telefone = new Telefone();
        $endereco->setAtributes($input);
        $endereco->save();
        $telefone->setNumero($input['celular']);
        $telefone->save();
        $beneficiario->setAtributes($input);
        $beneficiario->endereco_id = $endereco->id;
        $beneficiario->telefone_id = $telefone->id;
        $beneficiario->save();
        
        return redirect(route('beneficiarios.index'))->with(['success' => 'Beneficiário cadastrado com sucesso!']);
    }

    public function show($id)
    {
        $this->authorize('isSecretarioOrBeneficiario', User::class);
        $beneficiario = Beneficiario::find($id);
        $endereco = Endereco::find($beneficiario->endereco_id);
        $telefone = Telefone::find($beneficiario->telefone_id);
        return view('beneficiarios.show', compact('beneficiario', 'endereco', 'telefone'));
        
    }

   
    public function update(Request $request, $id)
    {   
        $this->authorize('isSecretarioOrBeneficiario', User::class);

        $beneficiario = Beneficiario::find($id);
        $input = $request->all();
        $endereco = Endereco::find($beneficiario->endereco_id);
        $telefone = Telefone::find($beneficiario->telefone_id);
        $endereco->setAtributes($input);
        $endereco->update();
        $telefone->setNumero($input['celular']);
        $telefone->update();
        $beneficiario->setAtributes($input);
        $beneficiario->endereco_id = $endereco->id;
        $beneficiario->telefone_id = $telefone->id;
        $beneficiario->update();

        return redirect(route('beneficiarios.index'))->with(['success' => 'Beneficiário editado com sucesso!']);
    }

    
    public function destroy($id)
    {
        $this->authorize('isSecretarioOrBeneficiario', User::class);
        $beneficiario = Beneficiario::find($id);
        $endereco = Endereco::find($beneficiario->endereco_id);
        $telefone = Telefone::find($beneficiario->telefone_id);
        $beneficiario->delete();
        $endereco->delete();
        $telefone->delete();
        return redirect(route('beneficiarios.index'))->with(['success' => 'Beneficiário excluído com sucesso!']);
    }
}
