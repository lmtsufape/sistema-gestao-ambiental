<?php

namespace App\Http\Controllers;

use App\Http\Controllers\WebServiceCaixa\XMLCoderController;
use App\Models\BoletoCobranca;
use App\Models\Requerimento;
use App\Models\User;
use App\Models\WebServiceCaixa\ErrorRemessaException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use PDF;

class BoletoController extends Controller
{
    public function index(Request $request, $filtragem)
    {
        $this->authorize('isSecretario', auth()->user());

        $retorno = $this->filtrarBoletos($request);
        $vencidos = $retorno[0];
        $pendentes = $retorno[1];
        $pagos = $retorno[2];
        $dataAte = $retorno[3];
        $dataDe = $retorno[4];
        $filtro = $retorno[5];

        switch ($filtragem) {
            case 'pendentes':
                $pagamentos = $pendentes;
                break;
            case 'pagos':
                $pagamentos = $pagos;
                break;
            case 'vencidos':
                $pagamentos = $vencidos;
                break;
        }

        return view('boleto.index', compact('pagamentos', 'dataAte', 'dataDe', 'filtro', 'filtragem'));
    }

    private function filtrarBoletos(Request $request)
    {
        $dataAte = $request->dataAte;
        $dataDe = $request->dataDe;
        $filtro = $request->filtro;
        $vencidos = BoletoCobranca::where('status_pagamento', BoletoCobranca::STATUS_PAGAMENTO_ENUM['vencido']);
        $pendentes = BoletoCobranca::where(function ($qry) {
            $qry->whereNull('status_pagamento')
                ->orWhere('status_pagamento', BoletoCobranca::STATUS_PAGAMENTO_ENUM['nao_pago']);
        });
        $pagos = BoletoCobranca::where('status_pagamento', BoletoCobranca::STATUS_PAGAMENTO_ENUM['pago']);
        $condicao = 'vencimento' == $filtro ? 'data_vencimento' : 'created_at';
        if ($dataDe != null) {
            $vencidos = $vencidos->where($condicao, '>=', $dataDe);
            $pendentes = $pendentes->where($condicao, '>=', $dataDe);
            $pagos = $pagos->where($condicao, '>=', $dataDe);
        }
        if ($dataAte != null) {
            $vencidos = $vencidos->where($condicao, '<=', $dataAte);
            $pendentes = $pendentes->where($condicao, '<=', $dataAte);
            $pagos = $pagos->where($condicao, '<=', $dataAte);
        }
        $vencidos = $vencidos->orderBy('created_at', 'DESC')->paginate(20);
        $pendentes = $pendentes->orderBy('created_at', 'DESC')->paginate(20);
        $pagos = $pagos->orderBy('created_at', 'DESC')->paginate(20);

        return [$vencidos, $pendentes, $pagos, $dataAte, $dataDe, $filtro];
    }

    /**
     * Cria um pdf como relatório dos boletos.
     */
    public function gerarRelatorioBoletos(Request $request)
    {
        $retorno = $this->filtrarBoletos($request);

        $pdf = PDF::loadview('pdf/boletos', ['vencidos' => $retorno[0], 'pendentes' => $retorno[1], 'pagos' => $retorno[2],
            'dataAte' => $retorno[3], 'dataDe' => $retorno[4], 'filtro' => $retorno[5], ]);

        return $pdf->setPaper('a4')->stream('boletos.pdf');
    }

    /**
     * Cria um boleto para o requerimento.
     *
     * @param Requerimento $requerimento
     * @return string $url do boleto
     * @throws ErrorRemessaException
     */
    public function boleto(Requerimento $requerimento)
    {
        $xmlBoletoController = new XMLCoderController();
        $boleto = $requerimento->boletos->last();
        if (is_null($boleto) || is_null($boleto->nosso_numero) || is_null($boleto->URL)) {
            return $this->gerarBoleto($requerimento);
        }
        if ($boleto->data_vencimento <= now()) {
            return $this->alterarBoleto($boleto);
        }
        if ($boleto->URL != null) {
            return $boleto->URL;
        }
        try {
            $boleto = $xmlBoletoController->gerarIncluirBoleto($requerimento);
            $xmlBoletoController->incluirBoletoRemessa($boleto);

            return $boleto->URL;
        } catch (ErrorRemessaException $e) {
            throw new ErrorRemessaException($this->formatarMensagem($e->getMessage()));
        }
    }

    /**
     * Gera um boleto para um requerimento
     *
     * @param Requerimento $requerimento
     * @return string URL do boleto
     * @throws ErrorRemessaException
     */
    private function gerarBoleto(Requerimento $requerimento)
    {
        $xmlBoletoController = new XMLCoderController();
        $boleto = $xmlBoletoController->gerarIncluirBoleto($requerimento);
        try {
            $xmlBoletoController->incluirBoletoRemessa($boleto);

            return $boleto->URL;
        } catch (ErrorRemessaException $e) {
            throw new ErrorRemessaException($this->formatarMensagem($e->getMessage()));
        }
    }

    /**
     * Altera o boleto para uma nova data de vencimento
     *
     * @param BoletoCobranca $boleto
     * @return Application|RedirectResponse|Redirector
     * @throws ErrorRemessaException
     */
    private function alterarBoleto(BoletoCobranca $boleto)
    {
        $xmlBoletoController = new XMLCoderController();
        try {
            $xmlBoletoController->gerarAlterarBoleto($boleto);

            return redirect($boleto->URL);
        } catch (ErrorRemessaException $e) {
            throw new ErrorRemessaException($this->formatarMensagem($e->getMessage()));
        }
    }

    /**
     * Formata a mensagem de erro
     *
     * @param string $mensagem
     * @return string $mensagem_formatada
     */
    private function formatarMensagem(string $mensagem)
    {
        if (auth()->user()->role == User::ROLE_ENUM['secretario']) {
            return 'WEBSERVICE ERROR: ' . $mensagem;
        }
        $mensagem_formatada = '';
        $mensagem_lower = strtolower($mensagem);
        $numeros_parenteses = '1234567890()';
        for ($i = 0; $i < strlen($mensagem_lower); $i++) {
            if (! (strpos($numeros_parenteses, $mensagem_lower[$i]))) {
                $mensagem_formatada .= $mensagem_lower[$i];
            }
        }

        return ucfirst($mensagem_formatada);
    }
}
