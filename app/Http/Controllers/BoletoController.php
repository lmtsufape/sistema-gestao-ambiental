<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\WebServiceCaixa\XMLCoderController;
use App\Models\User;
use App\Models\BoletoCobranca;
use App\Models\Requerimento;
use App\Models\WebServiceCaixa\ErrorRemessaException;


class BoletoController extends Controller
{

    public function index()
    {
        $this->authorize('isSecretario', auth()->user());
        $vencidos = BoletoCobranca::where('status_pagamento', BoletoCobranca::STATUS_PAGAMENTO_ENUM['vencido'])->orderBy('created_at', 'DESC')->get();
        $pendentes = BoletoCobranca::where('status_pagamento', null)->orWhere('status_pagamento', BoletoCobranca::STATUS_PAGAMENTO_ENUM['nao_pago'])->orderBy('created_at', 'DESC')->get();
        $pagos = BoletoCobranca::where('status_pagamento', BoletoCobranca::STATUS_PAGAMENTO_ENUM['pago'])->orderBy('created_at', 'DESC')->get();
        return view('boleto.index', compact('vencidos', 'pendentes', 'pagos'));
    }
    
    /**
     * Cria um boleto para o requerimento.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $xmlBoletoController = new XMLCoderController();
        $requerimento = Requerimento::find($id);
        $boleto = $requerimento->boleto;
        // dd($boleto);
        if (is_null($boleto)) {
            return $this->gerarBoleto($requerimento);
        } else {
            if ($boleto > now()) {
                return $this->alterarBoleto($boleto);
            } else {
                if ($boleto->URL != null) {
                    return redirect($boleto->URL);
                } else {
                    try {
                        $xmlBoletoController->incluir_boleto_remessa($boleto);
                        return redirect($boleto->URL);
                    } catch (ErrorRemessaException $e) {
                        return redirect()->back()->withErrors(['error' => $this->formatar_mensagem($e->getMessage())])->withInput();
                    }
                }
            }
        }
    }

    /**
     * Gera um boleto para um requerimento
     *
     * @param  App\Models\Requerimento
     * @return redirect
     */
    private function gerarBoleto(Requerimento $requerimento)
    {
        $xmlBoletoController = new XMLCoderController();
        $boleto = $xmlBoletoController->gerar_incluir_boleto($requerimento);

        try {
            $xmlBoletoController->incluir_boleto_remessa($boleto);
            return redirect($boleto->URL);
        } catch (ErrorRemessaException $e) {
            return redirect()->back()->withErrors(['error' => $this->formatar_mensagem($e->getMessage())])->withInput();
        }
    }

    /**
     * Altera o boleto para um nova data de vencimento
     *
     * @param  App\Models\BoletoCobranca
     * @return redirect
     */
    private function alterarBoleto(BoletoCobranca $boleto)
    {
        $xmlBoletoController = new XMLCoderController();

        try {
            $xmlBoletoController->gerar_alterar_boleto($boleto);
            return redirect($boleto->URL);
        } catch (ErrorRemessaException $e) {
            return redirect()->back()->withErrors(['error' => $this->formatar_mensagem($e->getMessage())])->withInput();
        }
    }

    /**
     * Formata a mensagem de erro
     *
     * @param  string $mensagem
     * @return string $mensagem_formatada
     */
    private function formatar_mensagem($mensagem)
    {
        if (auth()->user()->role == User::ROLE_ENUM['secretario']) {
            return 'WEBSERVICE ERROR: ' . $mensagem;
        } else {
            $mensagem_formatada = '';
            $mensagem_lower = strtolower($mensagem);
            $numeros_parenteses = '1234567890()';

            for ($i = 0; $i < strlen($mensagem_lower); $i++) {
                if (!(strpos($numeros_parenteses, $mensagem_lower[$i]))) {
                    $mensagem_formatada .= $mensagem_lower[$i];
                }
            }

            $mensagem_formatada = ucfirst($mensagem_formatada);
            return $mensagem_formatada;
        }
    }

}
