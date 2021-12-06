<?php

namespace App\Models\WebServiceCaixa;

use App\Models\BoletoCobranca;
use Carbon\Carbon;

abstract class Remessa extends BoletoCobranca
{
    /*
        Classe base para todos os tipos de remessas possiveis
        Inclui as tags do cabeçalho do arquivo de remessa exceto a tag OPERACAO que 
        é colocada nas classes que herdam essa.
    */

    // VERSAO : char[10]
    public $versao = "2.1";

    // AUTENTICACAO : char[64]
    public $autenticacao;

    // USUARIO_SERVICO : char[8]
    public $usuario_servico = "SGCBS02P";

    // USUARIO : char[8]
    public $usuario;

    // INDICE : short[4]
    public $indice;

    // SISTEMA_ORIGEM : char[5]
    public $sistema_origem = "SIGCB";

    // UNIDADE : char[4]
    public $unidade;

    // IDENTIFICADOR_ORIGEM : char[255]
    public $identificador_origem;

    // DATA_HORA : date (FORMATO yyyyMMddHHmmss) : char[14]
    public $data_hora;

    // ID_PROCESSO : char[50]
    public $id_processo;

    /** Gera o valor do boleto com 15 casas, zeros a esquerda.
     *
     * @return String $cabeçalho
    */
    protected function gerar_valor_atutenticacao()
    {
        $valor_string = number_format($this->valor, 2, "", "");
        $tamanho = strlen($valor_string);

        for ($i = 0; $i < 15 - $tamanho; $i++) {
            $valor_string = "0" . $valor_string;
        }
        
        return $valor_string;
    }

    /** Retorna a string sem pontos, barras e traços.
     *
     * @param String $string
     * @return String $string
    */
    protected function retirar_formatacao($string)
    {
        $nova = "";
        for ($i = 0; $i < strlen($string); $i++) {
            if ($string[$i] != "." && $string[$i] != "/" && $string[$i] != "-") {
                $nova .= $string[$i];
            }
        }

        return $nova;
    }

    /** Retorna a string do valor com ponto.
     *
     * @param double $valor : valor em double para ser formatado
     * @param int $num_casas : quantidade de casas decimais
     * @return String $string do valor com duas casas decimais
    */
    protected function gerar_valor($valor, $num_casas) 
    {
        return number_format($valor, $num_casas, '.', "");
    }

    /** Retorna a data formatada (yyyy-mm-dd), se tiver.
     *
     * @return String $string : parte do xml dos descontos
    */
    protected function formatar_data($data) 
    {
        $data = new Carbon($data);
        return $data->format('Y-m-d');
    }
}
