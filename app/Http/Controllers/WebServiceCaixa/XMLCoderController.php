<?php

namespace App\Http\Controllers\WebServiceCaixa;

use App\Http\Controllers\Controller;
use App\Models\WebServiceCaixa\Pessoa;
use App\Models\WebServiceCaixa\IncluirBoletoRemessa;
use App\Models\WebServiceCaixa\ConsultarBoletoRemessa;
use App\Models\BoletoCobranca;
use App\Models\Requerimento;
use App\Models\WebServiceCaixa\AlterarBoletoRemessa;
use Illuminate\Http\Request;
use App\Models\WebServiceCaixa\ErrorRemessaException;

class XMLCoderController extends Controller
{
    /**
     * Gera o boleto objeto do requerimento e inclui o arquivo xml de remessa.
     *
     * @param Requerimento $requerimento
     * @return BoletoCobranca $boleto
     */
    public function gerar_incluir_boleto(Requerimento $requerimento)
    {
        $pagador = new Pessoa();
        $beneficiario = new Pessoa();

        $pagador->gerar_pagador($requerimento->empresa);
        $beneficiario->gerar_beneficiario();

        $boleto = new IncluirBoletoRemessa();
        $data_vencimento = now()->addDays(30)->format('Y-m-d');

        $boleto->data_vencimento = $data_vencimento;
        $boleto->requerimento_id = $requerimento->id;
        $boleto->save();

        $boleto->setAttributes([
            'codigo_beneficiario' => $beneficiario->cod_beneficiario,
            'data_vencimento' => $data_vencimento,
            'valor' => $requerimento->valor,
            'pagador' => $pagador,
            'beneficiario' => $beneficiario,
            'tipo_juros_mora' => 'VALOR_POR_DIA',
            'valor_juros_mora' => '0000000000000.01',
            'data_multa' => $data_vencimento,
            'valor_multa' => '0000000000000.79',
            'mensagens_compensacao' => $requerimento->gerarMensagemCompesacao(),
        ]);

        $boleto->salvar_arquivo($boleto->gerar_remessa(), $requerimento);
        $boleto->update();

        return $boleto;
    }

    /**
     * Envia o arquivo de remessa incluir boleto para o web service da caixa e gera exceções
     * ou gera a resposta e salva no boleto objeto.
     *
     * @param  \App\Models\Requerimento $requerimento
     * @return void
     */
    public function incluir_boleto_remessa(BoletoCobranca $boleto)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => IncluirBoletoRemessa::URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_CIPHER_LIST => 'DEFAULT@SECLEVEL=1',
            CURLOPT_POSTFIELDS => file_get_contents(storage_path('').'/app/'.$boleto->caminho_arquivo_remessa),
            CURLOPT_HTTPHEADER => array(
                'SoapAction: INCLUI_BOLETO',
                'Content-Type: text/plain'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $resultado = (new IncluirBoletoRemessa())->to_array($response);

        switch ($resultado['COD_RETORNO']['DADOS']) {
            case 0:
                $boleto->salvar_arquivo_resposta($response);
                $this->salvar_resposta_incluir_boleto_remessa($boleto, $resultado);
                break;
            case 1:
                throw new ErrorRemessaException($resultado['RETORNO']);
                break;
            default:
                throw new ErrorRemessaException($resultado['RETORNO']);
                break;
        }
    }

    /**
     * Salva a resposta de incluir boleto ao boleto objeto.
     *
     * @param BoletoCobranca $boleto
     * @param array $resultado
     * @return void
     */
    private function salvar_resposta_incluir_boleto_remessa(BoletoCobranca $boleto, $resultado)
    {
        $boleto->codigo_de_barras = $resultado['CODIGO_BARRAS'];
        $boleto->linha_digitavel = $resultado['LINHA_DIGITAVEL'];
        $boleto->nosso_numero = $resultado['NOSSO_NUMERO'];
        $boleto->URL = $resultado['URL'];
        $boleto->update();
    }

    /**
     * Gerar e envia o alterar boleto.
     *
     * @param BoletoCobranca $boleto
     * @return void
     */
    public function gerar_alterar_boleto(BoletoCobranca $boleto)
    {
        $pagador = new Pessoa();
        $beneficiario = new Pessoa();
        $remessa_alterar_boleto = new AlterarBoletoRemessa();

        $pagador->gerar_pagador($boleto->requerimento->empresa);
        $beneficiario->gerar_beneficiario();

        $data_vencimento = now()->addDays(30)->format('Y-m-d');

        $remessa_alterar_boleto->setAttributes([
            'codigo_beneficiario' => $beneficiario->cod_beneficiario,
            'data_vencimento' => $data_vencimento,
            'valor' => $boleto->requerimento->valor,
            'pagador' => $pagador,
            'beneficiario' => $beneficiario,
            'tipo_juros_mora' => 'VALOR_POR_DIA',
            'valor_juros_mora' => '0000000000000.01',
            'data_multa' => $data_vencimento,
            'valor_multa' => '0000000000000.79',
            'mensagens_compensacao' => $boleto->requerimento->gerarMensagemCompesacao(),
        ]);

        $boleto->salvar_arquivo($remessa_alterar_boleto->gerar_remessa(), $boleto->requerimento);
        $boleto->update();

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => AlterarBoletoRemessa::URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_CIPHER_LIST => 'DEFAULT@SECLEVEL=1',
            CURLOPT_POSTFIELDS => file_get_contents(storage_path('').'/app/'.$boleto->caminho_arquivo_remessa),
            CURLOPT_HTTPHEADER => array(
                'SoapAction: ALTERA_BOLETO',
                'Content-Type: text/plain'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $resultado = (new IncluirBoletoRemessa())->to_array($response);

        switch ($resultado['COD_RETORNO']['DADOS']) {
            case 0:
                $boleto->salvar_arquivo_resposta($response);
                $this->salvar_resposta_incluir_boleto_remessa($boleto, $resultado);
                break;
            case 1:
                throw new ErrorRemessaException($resultado['RETORNO']);
                break;
            default:
                throw new ErrorRemessaException($resultado['RETORNO']);
                break;
        }
    }
}
