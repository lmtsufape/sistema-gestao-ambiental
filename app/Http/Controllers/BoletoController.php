<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\WebServiceCaixa\XMLCoderController;
use App\Models\User;
use App\Models\BoletoCobranca;
use App\Models\Requerimento;
use App\Models\WebServiceCaixa\ErrorRemessaException;
use PDF;


class BoletoController extends Controller
{

    public function index(Request $request)
    {
        $this->authorize('isSecretario', auth()->user());

        $retorno = $this->filtrarBoletos($request);
        $vencidos = $retorno[0];
        $pendentes = $retorno[1];
        $pagos = $retorno[2];
        $dataAte = $retorno[3];
        $dataDe = $retorno[4]; 
        $filtro = $retorno[5];
        return view('boleto.index', compact('vencidos', 'pendentes', 'pagos', 'dataAte', 'dataDe', 'filtro'));
    }

    private function filtrarBoletos(Request $request)
    {
        if($request->filtro != null && $request->filtro == "vencimento"){
            if($request->dataDe != null){
                if($request->dataAte != null){
                    $vencidos = BoletoCobranca::where([['status_pagamento', BoletoCobranca::STATUS_PAGAMENTO_ENUM['vencido']], ['data_vencimento', '>=', $request->dataDe], ['data_vencimento', '<=', $request->dataAte]])->orderBy('created_at', 'DESC')->get();
                    $pendentes = BoletoCobranca::where([['status_pagamento', null], ['data_vencimento', '>=', $request->dataDe], ['data_vencimento', '<=', $request->dataAte]])->orWhere([['status_pagamento', BoletoCobranca::STATUS_PAGAMENTO_ENUM['nao_pago']], ['data_vencimento', '>=', $request->dataDe], ['data_vencimento', '<=', $request->dataAte]])->orderBy('created_at', 'DESC')->get();
                    $pagos = BoletoCobranca::where([['status_pagamento', BoletoCobranca::STATUS_PAGAMENTO_ENUM['pago']], ['data_vencimento', '>=', $request->dataDe], ['data_vencimento', '<=', $request->dataAte]])->orderBy('created_at', 'DESC')->get();
                }else{
                    $vencidos = BoletoCobranca::where([['status_pagamento', BoletoCobranca::STATUS_PAGAMENTO_ENUM['vencido']], ['data_vencimento', '>=', $request->dataDe]])->orderBy('created_at', 'DESC')->get();
                    $pendentes = BoletoCobranca::where([['status_pagamento', null], ['data_vencimento', '>=', $request->dataDe]])->orWhere([['status_pagamento', BoletoCobranca::STATUS_PAGAMENTO_ENUM['nao_pago']], ['data_vencimento', '>=', $request->dataDe]])->orderBy('created_at', 'DESC')->get();
                    $pagos = BoletoCobranca::where([['status_pagamento', BoletoCobranca::STATUS_PAGAMENTO_ENUM['pago']], ['data_vencimento', '>=', $request->dataDe]])->orderBy('created_at', 'DESC')->get();
                }
            }elseif($request->dataAte != null){
                $vencidos = BoletoCobranca::where([['status_pagamento', BoletoCobranca::STATUS_PAGAMENTO_ENUM['vencido']], ['data_vencimento', '<=', $request->dataAte]])->orderBy('created_at', 'DESC')->get();
                $pendentes = BoletoCobranca::where([['status_pagamento', null], ['data_vencimento', '<=', $request->dataAte]])->orWhere([['status_pagamento', BoletoCobranca::STATUS_PAGAMENTO_ENUM['nao_pago']], ['data_vencimento', '<=', $request->dataAte]])->orderBy('created_at', 'DESC')->get();
                $pagos = BoletoCobranca::where([['status_pagamento', BoletoCobranca::STATUS_PAGAMENTO_ENUM['pago']], ['data_vencimento', '<=', $request->dataAte]])->orderBy('created_at', 'DESC')->get();
            }
        }else{
            if($request->dataDe != null){
                if($request->dataAte != null){
                    $vencidos = BoletoCobranca::where([['status_pagamento', BoletoCobranca::STATUS_PAGAMENTO_ENUM['vencido']], ['created_at', '>=', $request->dataDe], ['created_at', '<=', $request->dataAte]])->orderBy('created_at', 'DESC')->get();
                    $pendentes = BoletoCobranca::where([['status_pagamento', null], ['created_at', '>=', $request->dataDe], ['created_at', '<=', $request->dataAte]])->orWhere([['status_pagamento', BoletoCobranca::STATUS_PAGAMENTO_ENUM['nao_pago']], ['created_at', '>=', $request->dataDe], ['created_at', '<=', $request->dataAte]])->orderBy('created_at', 'DESC')->get();
                    $pagos = BoletoCobranca::where([['status_pagamento', BoletoCobranca::STATUS_PAGAMENTO_ENUM['pago']], ['created_at', '>=', $request->dataDe], ['created_at', '<=', $request->dataAte]])->orderBy('created_at', 'DESC')->get();
                }else{
                    $vencidos = BoletoCobranca::where([['status_pagamento', BoletoCobranca::STATUS_PAGAMENTO_ENUM['vencido']], ['created_at', '>=', $request->dataDe]])->orderBy('created_at', 'DESC')->get();
                    $pendentes = BoletoCobranca::where([['status_pagamento', null], ['created_at', '>=', $request->dataDe]])->orWhere([['status_pagamento', BoletoCobranca::STATUS_PAGAMENTO_ENUM['nao_pago']], ['created_at', '>=', $request->dataDe]])->orderBy('created_at', 'DESC')->get();
                    $pagos = BoletoCobranca::where([['status_pagamento', BoletoCobranca::STATUS_PAGAMENTO_ENUM['pago']], ['created_at', '>=', $request->dataDe]])->orderBy('created_at', 'DESC')->get();
                }
            }elseif($request->dataAte != null){
                $vencidos = BoletoCobranca::where([['status_pagamento', BoletoCobranca::STATUS_PAGAMENTO_ENUM['vencido']], ['created_at', '<=', $request->dataAte]])->orderBy('created_at', 'DESC')->get();
                $pendentes = BoletoCobranca::where([['status_pagamento', null], ['created_at', '<=', $request->dataAte]])->orWhere([['status_pagamento', BoletoCobranca::STATUS_PAGAMENTO_ENUM['nao_pago']], ['created_at', '<=', $request->dataAte]])->orderBy('created_at', 'DESC')->get();
                $pagos = BoletoCobranca::where([['status_pagamento', BoletoCobranca::STATUS_PAGAMENTO_ENUM['pago']], ['created_at', '<=', $request->dataAte]])->orderBy('created_at', 'DESC')->get();
            }else{
                $vencidos = BoletoCobranca::where('status_pagamento', BoletoCobranca::STATUS_PAGAMENTO_ENUM['vencido'])->orderBy('created_at', 'DESC')->get();
                $pendentes = BoletoCobranca::where('status_pagamento', null)->orWhere('status_pagamento', BoletoCobranca::STATUS_PAGAMENTO_ENUM['nao_pago'])->orderBy('created_at', 'DESC')->get();
                $pagos = BoletoCobranca::where('status_pagamento', BoletoCobranca::STATUS_PAGAMENTO_ENUM['pago'])->orderBy('created_at', 'DESC')->get();
            }
        }
        $dataAte = $request->dataAte;
        $dataDe = $request->dataDe;
        $filtro = $request->filtro;

        return [$vencidos, $pendentes, $pagos, $dataAte, $dataDe, $filtro];
    }

    /**
     * Cria um pdf como relatório dos boletos.
     *
     */

    public function gerarRelatorioBoletos(Request $request)
    {
        $retorno = $this->filtrarBoletos($request);
        
        $pdf = PDF::loadview('pdf/boletos', ['vencidos' => $retorno[0], 'pendentes' => $retorno[1], 'pagos' => $retorno[2], 
            'dataAte' => $retorno[3], 'dataDe' => $retorno[4], 'filtro' => $retorno[5]]);
        return $pdf->setPaper('a4')->stream('boletos.pdf');
    }
    
    /**
     * Cria um boleto para o requerimento.
     *
     * @param App\Models\Requerimento $requerimento
     * @return string $url do boleto 
     */
    public function boleto($requerimento)
    {
        $xmlBoletoController = new XMLCoderController();
        $boleto = $requerimento->boleto;

        if (is_null($boleto)) {
            return $this->gerarBoleto($requerimento);
        } else {
            if ($boleto->data_vencimento > now()) {
                return $this->alterarBoleto($boleto);
            } else {
                if ($boleto->URL != null) {
                    return $boleto->URL;
                } else {
                    try {
                        $xmlBoletoController->incluir_boleto_remessa($boleto);
                        return $boleto->URL;
                    } catch (ErrorRemessaException $e) {
                        throw new ErrorRemessaException($this->formatar_mensagem($e->getMessage()));
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
            return $boleto->URL;
        } catch (ErrorRemessaException $e) {
            throw new ErrorRemessaException($this->formatar_mensagem($e->getMessage()));
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
            throw new ErrorRemessaException($this->formatar_mensagem($e->getMessage()));
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
