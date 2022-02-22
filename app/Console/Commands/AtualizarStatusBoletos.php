<?php

namespace App\Console\Commands;

use App\Models\BoletoCobranca;
use App\Models\WebServiceCaixa\ConsultarBoletoRemessa;
use App\Models\WebServiceCaixa\Pessoa;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AtualizarStatusBoletos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'atualizar:boletos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualiza o status de pagamento dos boletos não vencidos ainda não pagos';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $boletos = BoletoCobranca::
            whereNotNull('nosso_numero')
            ->where(function($qry) {
                $qry->whereNull('status_pagamento')
                    ->orWhere('status_pagamento', BoletoCobranca::STATUS_PAGAMENTO_ENUM['nao_pago']);
            })
            ->lazy()->each(function ($boleto) {
                DB::table('boleto_cobrancas')
                    ->where('id', $boleto->id)
                    ->update(['status_pagamento' => $this->consultaStatus($boleto)]);
            });
    }

    private function consultaStatus(BoletoCobranca $boleto){
        $beneficiario = new Pessoa();
        $beneficiario->gerar_beneficiario();
        $consulta = new ConsultarBoletoRemessa();
        $consulta->setAttributes([
            'codigo_beneficiario' => $beneficiario->cod_beneficiario,
            'nosso_numero' => $boleto->nosso_numero,
            'beneficiario' => $beneficiario,
        ]);
        $string = $consulta->gerar_remessa();
        $caminho_arquivo = "remessas/";
        $documento_nome = "consultar_boleto_remessa_".$boleto->requerimento->id.".xml";

        $file = fopen(storage_path('').'/app/'.$caminho_arquivo.$documento_nome, 'w+');
        fwrite($file, $string);
        fclose($file);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => ConsultarBoletoRemessa::URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_CIPHER_LIST => 'DEFAULT@SECLEVEL=1',
            CURLOPT_POSTFIELDS => file_get_contents(storage_path('').'/app/'.$caminho_arquivo.$documento_nome),
            CURLOPT_HTTPHEADER => array(
                'SoapAction: CONSULTA_BOLETO',
                'Content-Type: text/plain'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $resultado = (new ConsultarBoletoRemessa())->to_array($response);

        if ($boleto->resposta_consultar_boleto != null) {
            if (Storage::disk()->exists($this->resposta_consultar_boleto)) {
                Storage::delete($this->resposta_consultar_boleto);
            }
        }
        $caminho_arquivo = "remessas/";
        $documento_nome = "resposta_consultar_boleto_remessa_".$boleto->requerimento->id.".xml";

        $file = fopen(storage_path('').'/app/'.$caminho_arquivo.$documento_nome, 'w+');
        fwrite($file, $response);
        fclose($file);

        $this->resposta_consultar_boleto = $caminho_arquivo . $documento_nome;

        switch ($resultado['COD_RETORNO']['DADOS']) {
            case 0:
                switch ($resultado['RETORNO']) {
                    case '(0) OPERACAO EFETUADA - SITUACAO DO TITULO = EM ABERTO':
                        return BoletoCobranca::STATUS_PAGAMENTO_ENUM['nao_pago'];
                    case '(0) OPERACAO EFETUADA - SITUACAO DO TITULO = BAIXA POR DEVOLUCAO':
                        return BoletoCobranca::STATUS_PAGAMENTO_ENUM['vencido'];
                    case '(0) OPERACAO EFETUADA - SITUACAO DO TITULO = LIQUIDADO':
                        return BoletoCobranca::STATUS_PAGAMENTO_ENUM['pago'];
                    default:
                        # tratar excecao
                        return BoletoCobranca::STATUS_PAGAMENTO_ENUM['nao_pago'];
                        break;
                }
            default:
                # tratar excecao
                return BoletoCobranca::STATUS_PAGAMENTO_ENUM['nao_pago'];
                break;
        }
        return BoletoCobranca::STATUS_PAGAMENTO_ENUM['nao_pago'];
    }
}
