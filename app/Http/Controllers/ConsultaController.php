<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SolicitacaoMuda;
use App\Models\SolicitacaoPoda;
use App\Models\Denuncia;


class ConsultaController extends Controller
{
    public function show(Request $request){
        $solicitacao_muda = SolicitacaoMuda::where('protocolo', $request->protocolo)->first();
        $solicitacao_poda = SolicitacaoPoda::where('protocolo', $request->protocolo)->first();
        $solicitacao_denuncia = Denuncia::where('protocolo', $request->protocolo)->first();
                
        if($solicitacao_muda != null){
            $solicitacao = $solicitacao_muda;            
            return view('solicitacoes.consultas.mudas', compact('solicitacao'));
        }
        elseif($solicitacao_poda != null){
            $solicitacao = $solicitacao_poda;
            return view('solicitacoes.consultas.podas', compact('solicitacao'));
        }

        elseif($solicitacao_denuncia != null){
            $solicitacao = $solicitacao_denuncia;
            return view('solicitacoes.consultas.denuncia', compact('solicitacao'));
        }

        else{
            $message = "Este número de protocolo não consta no nosso sistema";
            return redirect()->back()->with('error', $message);
        }
    }
}
