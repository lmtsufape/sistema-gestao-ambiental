<?php

namespace App\Models\WebServiceCaixa;

/**
 * Utilizada para alterar dados de um boleto registrado na CAIXA. Útil para situações onde o
 * pagador necessita de atualização de instruções de devolução/protesto, prazos,
 * vencimento, descontos, juros, entre outros.
 */
class AlterarBoletoRemessa extends GerirBoletoRemessa
{
    public string $operacao = 'ALTERA_BOLETO';

    /** Seta os dados da remessa.
     *
     * @param array $data
     * @return void
     */
    public function setAttributes(array $data)
    {
        parent::setAttributes($data);
        $this->data_juros_mora = array_key_exists('data_juros_mora', $data) ? now()->addDays($data['data_juros_mora'])->format('Y-m-d') : now()->addDays(31)->format('Y-m-d');
    }
}
