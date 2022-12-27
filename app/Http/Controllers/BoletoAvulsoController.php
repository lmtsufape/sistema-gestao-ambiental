<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;

class BoletoAvulsoController extends Controller
{
    public function index() {
        return view('boletosAvulsos.index');
    }

    public function store(Request $request){
        dd($request);
    }

    public function buscarEmpresa(Request $request) {
        $empresa = Empresa::where('cpf_cnpj', $request->cpf_cnpj)->first();
        if($empresa){
            $endereco = $empresa->endereco;
            $telefone = $empresa->telefone;
            return json_encode([$empresa, $endereco, $telefone]);
        }
        
        return json_encode('inexistente');
    }
}
