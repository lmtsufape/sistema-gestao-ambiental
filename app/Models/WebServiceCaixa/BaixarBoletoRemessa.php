<?php

namespace App\Models\WebServiceCaixa;

/**
 * Utilizada para baixar um boleto, ou seja, encerrar o compromisso de dívida do pagador
 * (devedor) perante o beneficiário (credor). Aplica-se somente para títulos com situação EM
 * ABERTO.
 */
class BaixarBoletoRemessa extends Remessa
{
    public const URL = 'https://barramento.caixa.gov.br/sibar/ManutencaoCobrancaBancaria/Boleto/Externo';

    public string $operacao = 'BAIXA_BOLETO';

    /**
     * Código do Convênio no Banco (Código do Beneficiário).
     * Código fornecido pela CAIXA, através da agência de relacionamento do cliente.
     * Deve ser preenchido com o código do Beneficiário, até 7 posições, da esquerda para direita.
     * @var string
     */
    public string $codigo_beneficiario;

    /**
     * Nosso Número — Informação de entrada.
     * Se informado zeros, o nosso número será gerado pelo banco. Caso contrário deverá ser informado número iniciando com 14.
     * @var string
     */
    public string $nosso_numero;

    public function setAttributes($data)
    {
        $this->codigo_beneficiario = $data['codigo_beneficiario'];
        $this->nosso_numero = $data['nosso_numero'];
        $this->beneficiario = $data['beneficiario'];
        $this->data_hora = now()->format('YmdHms');
    }

    /**
     * Gera o arquivo de remessa.
     * @return string $cabeçalho
     */
    public function gerarRemessa()
    {
        $xml_array = [
            'soapenv:Body' => [
                'ext:SERVICO_ENTRADA' => [
                    'sib:HEADER' => [
                        'VERSAO' => $this->versao,
                        'AUTENTICACAO' => $this->gerarAutenticacao(),
                        'USUARIO_SERVICO' => $this->usuario_servico,
                        'OPERACAO' => $this->operacao,
                        'SISTEMA_ORIGEM' => $this->sistema_origem,
                        'DATA_HORA' => $this->data_hora,
                    ],
                    'DADOS' => [
                        $this->operacao => [
                            'CODIGO_BENEFICIARIO' => $this->codigo_beneficiario,
                            'NOSSO_NUMERO' => $this->nosso_numero,
                        ],
                    ],
                ],
            ],
        ];
        $xml_root = 'soapenv:Envelope';
        $xml = new XmlDomConstruct('1.0', 'ISO8859-1');
        $xml->formatOutput = true;
        $xml->fromMixed([$xml_root => $xml_array]);
        $xml_root_item = $xml->getElementsByTagName($xml_root)->item(0);
        $xml_root_item->setAttribute('xmlns:sib', 'http://caixa.gov.br/sibar');
        $xml_root_item->setAttribute('xmlns:ext', 'http://caixa.gov.br/sibar/manutencao_cobranca_bancaria/boleto/externo');
        $xml_root_item->setAttribute('xmlns:soapenv', 'http://schemas.xmlsoap.org/soap/envelope/');

        return $xml->saveXML();
    }

    /**
     * Gera a hash de atutenticação do cabeçalho do arquivo.
     * @return string $cabeçalho
     */
    private function gerarAutenticacao()
    {
        $autenticacao = $this->codigo_beneficiario . $this->nosso_numero . '00000000' . '000000000000000' . $this->retirarFormatacao($this->beneficiario->cnpj);
        $hash = hash('sha256', $autenticacao, true);

        return base64_encode($hash);
    }
}
