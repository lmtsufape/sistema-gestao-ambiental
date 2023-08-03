<?php

namespace App\Http\Controllers;

use App\Models\Aracao;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Beneficiario;

class AracaoController extends Controller
{
    public function index()
    {   
        $this->authorize('isSecretarioOrBeneficiario', User::class);

        $aracao = Aracao::all();

        // $buscar = $request->input('buscar');

        // if ($buscar != null) {
        //     $buscar = Beneficiario::where('nome', 'LIKE', "%{$buscar}%")->get();
        // } else {
        //     $buscar = Beneficiario::all()->sortBy('nome');
        // }
        
        return view('aracao.index', compact('aracao'));
    }

    public function create()
    {
        $this->authorize('isSecretarioOrBeneficiario', User::class);

        $beneficiarios = Beneficiario::all();

        return view('aracao.create', compact('beneficiarios'));
    }

    public function store(Request $request)
    {
        $this->authorize('isSecretarioOrBeneficiario', User::class);

        $aracao = new Aracao();
        $aracao->setAtributes($request);
        $aracao->save();

        return redirect()->route('aracao.index')->with('success', 'Aração cadastrada com sucesso!');
    }

    public function show($id)
    {
        $this->authorize('isSecretarioOrBeneficiario', User::class);

        $aracao = Aracao::find($id);

        return view('aracao.show', compact('aracao'));
    }

    public function edit($id)
    {
        $this->authorize('isSecretarioOrBeneficiario', User::class);

        $aracao = Aracao::find($id);
        $beneficiarios = Beneficiario::all();

        return view('aracao.edit', compact('aracao', 'beneficiarios'));
    }

    public function update(Request $request, $id)
    {
        $this->authorize('isSecretarioOrBeneficiario', User::class);

        $aracao = Aracao::find($id);
        $aracao->setAtributes($request);
        $aracao->update();

        return redirect()->route('aracao.index')->with('success', 'Aração atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $this->authorize('isSecretarioOrBeneficiario', User::class);
        
        $aracao = Aracao::find($id);
        $aracao->delete();

        return redirect()->route('aracao.index')->with('success', 'Aração excluída com sucesso!');
    }

    // public function gerarPedidosAracao(){
    //     $this->authorize('isSecretarioOrBeneficiario', User::class);
        
    //     $aracaos = Aracao::all();

    //     if (empty($aracao)) {
    //         return redirect()->route('aracao.index')->with('error', 'Não há solicitações de serviço para gerar pedidos!');
    //     } else {
    //         $pdf = PDF::loadView('aracao.PDF.pedidos_aracao', compact('aracaos'));
    //         $pdf->setOption('header-html', view('aracao.PDF.header')->render());
    //         return $pdf->download('pedidos_aracao.pdf');
    //     }
    // }
}
