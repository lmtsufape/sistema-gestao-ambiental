<?php

namespace App\Http\Controllers\WebServiceCaixa;

use App\Http\Controllers\Controller;
use App\Models\BoletoCobranca;
use App\Models\Requerimento;
use App\Models\WebServiceCaixa\AlterarBoletoRemessa;
use App\Models\WebServiceCaixa\ErrorRemessaException;
use App\Models\WebServiceCaixa\GerirBoletoRemessa;
use App\Models\WebServiceCaixa\IncluirBoletoRemessa;
use App\Models\WebServiceCaixa\Pessoa;
use Illuminate\Support\Facades\Storage;

class XMLCoderController extends Controller
{
    /**
     * Gera o boleto objeto do requerimento e inclui o arquivo de remessa.
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

        $data_vencimento = now()->addDays(30)->format('Y-m-d');

        $boleto = new IncluirBoletoRemessa([
            'data_vencimento' => $data_vencimento,
            'requerimento_id' => $requerimento->id,
        ]);
        $boleto->save();

        $boleto->setAttributes([
            'codigo_beneficiario' => $beneficiario->cod_beneficiario,
            'data_vencimento' => $data_vencimento,
            'valor' => $requerimento->valor,
            'pagador' => $pagador,
            'beneficiario' => $beneficiario,
            'tipo_juros_mora' => 'VALOR_POR_DIA',
            'valor_juros_mora' => 0.01,
            'data_multa' => $data_vencimento,
            'valor_multa' => 0.79,
            'mensagens_compensacao' => $requerimento->gerarMensagemCompesacao(),
        ]);

        $boleto->salvar_arquivo($boleto->gerar_remessa());
        $boleto->update();

        return $boleto;
    }

    /**
     * Envia o arquivo de remessa incluir boleto para o WebService da Caixa e gera a resposta e salva no boleto objeto,
     * ou trata a exceção lançada.
     *
     * @param BoletoCobranca $boleto
     * @return void
     * @throws ErrorRemessaException
     */
    public function incluir_boleto_remessa(BoletoCobranca $boleto)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => IncluirBoletoRemessa::URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_CIPHER_LIST => 'DEFAULT@SECLEVEL=1',
            CURLOPT_POSTFIELDS => file_get_contents(storage_path('') . '/app/' . $boleto->caminho_arquivo_remessa),
            CURLOPT_HTTPHEADER => [
                'SoapAction: INCLUI_BOLETO',
                'Content-Type: text/plain',
            ],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        $resultado = (new IncluirBoletoRemessa())->to_array($response);

        if (array_key_exists('COD_RETORNO', $resultado) && is_array($resultado['COD_RETORNO']) && array_key_exists('DADOS', $resultado['COD_RETORNO'])) {
            switch ($resultado['COD_RETORNO']['DADOS']) {
                case 0:
                    $boleto->salvar_arquivo_resposta($response);
                    $this->salvar_resposta_incluir_boleto_remessa($boleto, $resultado);
                    break;
                default:
                    throw new ErrorRemessaException($resultado['RETORNO']);
            }
        }
        throw new ErrorRemessaException($response);
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
        $boleto = BoletoCobranca::find($boleto->id);
        $boleto->codigo_de_barras = $resultado['CODIGO_BARRAS'];
        $boleto->linha_digitavel = $resultado['LINHA_DIGITAVEL'];
        $boleto->nosso_numero = $resultado['NOSSO_NUMERO'];
        $boleto->URL = $resultado['URL'];
        $boleto->update();
    }

    /**
     * Salva a resposta de alterar boleto ao boleto objeto.
     *
     * @param BoletoCobranca $boleto
     * @param array $resultado
     * @return void
     */
    private function salvar_resposta_alterar_boleto_remessa(BoletoCobranca $boleto, array $resultado)
    {
        $boleto = BoletoCobranca::find($boleto->id);
        $boleto->codigo_de_barras = $resultado['CODIGO_BARRAS'];
        $boleto->linha_digitavel = $resultado['LINHA_DIGITAVEL'];
        $boleto->URL = $resultado['URL'];
        $boleto->update();
    }

    /**
     * Gerar e envia o alterar boleto.
     *
     * @param BoletoCobranca $boleto
     * @return void
     * @throws ErrorRemessaException
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
            'valor_juros_mora' => 0.01,
            'data_multa' => $data_vencimento,
            'valor_multa' => 0.79,
            'mensagens_compensacao' => $boleto->requerimento->gerarMensagemCompesacao(),
            'nosso_numero' => $boleto->nosso_numero,
            'numero_do_documento' => strval($boleto->id),
        ]);

        $caminho = 'remessas/alterar_boleto_remessa_' . $boleto->id . '.xml';
        Storage::put($caminho, $remessa_alterar_boleto->gerar_remessa());
        $boleto->update();

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => GerirBoletoRemessa::URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_CIPHER_LIST => 'DEFAULT@SECLEVEL=1',
            CURLOPT_POSTFIELDS => file_get_contents(storage_path('') . '/app/' . $caminho),
            CURLOPT_HTTPHEADER => [
                'SoapAction: ALTERA_BOLETO',
                'Content-Type: text/plain',
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);
        $resultado = (new AlterarBoletoRemessa())->to_array($response);

        if (array_key_exists('COD_RETORNO', $resultado) && is_array($resultado['COD_RETORNO']) && array_key_exists('DADOS', $resultado['COD_RETORNO'])) {
            switch ($resultado['COD_RETORNO']['DADOS']) {
                case 0:
                    $boleto->salvar_arquivo_resposta($response);
                    Storage::put('resposta_alterar_boleto_remessa_' . $boleto->id . '.xml', $response);
                    $this->salvar_resposta_alterar_boleto_remessa($boleto, $resultado);
                    break;
                default:
                    throw new ErrorRemessaException($resultado['RETORNO']);
            }
        }
        throw new ErrorRemessaException($response);
    }
}
