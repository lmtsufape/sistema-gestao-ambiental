<?php

namespace App\Models\WebServiceCaixa;

use App\Models\WebServiceCaixa\Remessa;
use Carbon\Carbon;

class ConsultarBoletoRemessa extends Remessa
{
    // VERSAO : char[10]
    public $versao = "4.1";

    // OPERACAO : char[50]
    public $operacao = "CONSULTA_BOLETO";

    // CODIGO_BENEFICIARIO : int
    public $codigo_beneficiario;

    // NOSSO_NUMERO : long
    public $nosso_numero;

    // BENEFICIARIO : Pessoa
    public $beneficiario;

    public function setAttributes($data)
    {
        $this->codigo_beneficiario = $data["codigo_beneficiario"];
        $this->nosso_numero = $data["nosso_numero"];
        $this->beneficiario = $data["beneficiario"];

        $this->data_hora = now()->format('YmdHms');
    }

    /** Gera o arquivo de remessa.
     *
     * @return String $cabeçalho
    */
    public function gerar_remessa() 
    {
        return "<?xml version='1.0' encoding='UTF-8'?>
                <manutencaocobrancabancaria:SERVICO_ENTRADA xmlns:manutencaocobrancabancaria='http://caixa.gov.br/sibar/manutencao_cobranca_bancaria/boleto/externo' xmlns:sibar_base='http://caixa.gov.br/sibar'>
                \t<sibar_base:HEADER>
                \t\t<VERSAO>".$this->versao."</VERSAO>
                \t\t<AUTENTICACAO>".$this->gerar_autenticacao()."</AUTENTICACAO>
                \t\t<USUARIO_SERVICO>".$this->usuario_servico."</USUARIO_SERVICO>
                \t\t<OPERACAO>".$this->operacao."</OPERACAO>
                \t\t<SISTEMA_ORIGEM>".$this->sistema_origem."</SISTEMA_ORIGEM>
                \t\t<DATA_HORA>".$this->data_hora."</DATA_HORA>
                \t</sibar_base:HEADER>
                \t<DADOS>
                \t\t<CONSULTA_BOLETO>
                \t\t\t<CODIGO_BENEFICIARIO>".$this->codigo_beneficiario."</CODIGO_BENEFICIARIO>
                \t\t\t<NOSSO_NUMERO>".$this->nosso_numero."</NOSSO_NUMERO>
                \t\t</CONSULTA_BOLETO>
                \t</DADOS>
                </manutencaocobrancabancaria:SERVICO_ENTRADA>
                ";
    }

    /** Gera a hash de atutenticação do cabeçalho do arquivo.
     *
     * @return String $cabeçalho
    */

    private function gerar_autenticacao()
    {
        $autenticacao = $this->codigo_beneficiario . $this->nosso_numero . "00000000" . "000000000000000" . $this->retirar_formatacao($this->beneficiario->cnpj); 

        $hash = hash("sha256", $autenticacao);
        return base64_encode($hash);
    }

}
