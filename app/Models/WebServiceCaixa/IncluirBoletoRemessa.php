<?php

namespace App\Models\WebServiceCaixa;

/**
 * Utilizada para a inclusão de boletos (somente emissão BENEFICIÁRIO) no sistema CAIXA.
 */
class IncluirBoletoRemessa extends GerirBoletoRemessa
{
    protected $table = 'boleto_cobrancas';

    public string $operacao = 'INCLUI_BOLETO';

    // DATA_EMISSAO : date (Formato yyyy-MM-dd)
    public $data_emissao;

    // CODIGO_MOEDA : short
    public $codigo_moeda = '09';

    /** Seta os dados da remessa.
     *
     * @param array $data
     * @return void
     */
    public function setAttributes($data)
    {
        parent::setAttributes($data);
        $this->data_emissao = now()->format('Y-m-d');
        $this->data_juros_mora = array_key_exists('data_juros_mora', $data) ? $data['data_juros_mora'] : now()->addDays(31)->format('Y-m-d');
        $this->codigo_moeda = array_key_exists('codigo_moeda', $data) ? $data['codigo_moeda'] : '09';
    }
}
