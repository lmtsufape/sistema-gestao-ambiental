<?php

namespace App\Models\WebServiceCaixa;

use App\Models\BoletoCobranca;
use Carbon\Carbon;
use DOMDocument;
use DOMElement;

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

    /** Valida a string com o tamanho passado, se for menor ou igual ao tamanho
     *  retorna a mesma string, caso contrario elimina os caracteres a partir
     *  do ultimo para ficar do tamanho passado.
     *
     * @param String $string : string que deve ser validade e formatada
     * @param Integer $tamanho : tamanho limite da string
     * @return String $string : string formatada
    */
    protected function validar_formartar_tamanho($string, $tamanho) 
    {
        $tam_string = strlen($string);

        if ($tam_string > $tamanho) {
            $string = $this->retirar_acento($string);
            $string_formatada = "";
            for ($i = 0; $i < $tamanho; $i++) {
                $string_formatada .= $string[$i];
            }
            return $string_formatada;
        }

        return $string;
    }

    /** Retira os acentos de uma string passada.
     *
     * @param String $string : string que o acento será retirado
     * @return String $string : string sem acentos
    */
    protected function retirar_acento($string) 
    {
        return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"), explode(" ","a A e E i I o O u U n N"), $string);
    }

    /** Recebe um reponse string xml com o resultado da chamada e converte para array.
     *
     * @param String $string_response : string responsiva com conteudo em xml
     * @return String $array_conteudo : array na forma ['tag' => 'conteudo_da_tag']
    */
    public function to_array($string_response) 
    {
        $dom_document = new DOMDocument();
        $dom_document->loadXML($string_response);
        $conteudo = $dom_document->childNodes[0]->childNodes[0]->childNodes[0];
        $arvore_conteudo = $this->gerar_arvore_de_conteudo($conteudo);
        $array_conteudo = $this->passa_para_array($arvore_conteudo); 

        return $array_conteudo;
    }

    /** Recebe DOMElement com a lista de nos e retorna uma arvore em array.
     *
     * @param DOMElement $lista_de_nos : Lista de elmentos xml
     * @return String $arvore : arvore de conteudo do xml como ['tag' => 'conteudo_da_tag']
    */
    private function gerar_arvore_de_conteudo($lista_de_nos)
    {
        $arvore = [];

        if ($lista_de_nos != null) {
            if ($lista_de_nos->childNodes != null && $lista_de_nos->childNodes->length == 1 && $lista_de_nos->childNodes[0]->childNodes->length == 0) {
                return [$lista_de_nos->tagName => $lista_de_nos->childNodes->item(0)->data];
            } else if ($lista_de_nos->childNodes != null && $lista_de_nos->childNodes->length > 1) {
                for ($i = 0; $i < $lista_de_nos->childNodes->length; $i++) {
                    array_push($arvore, $this->gerar_arvore_de_conteudo($lista_de_nos->childNodes[$i]));
                }
            } else {
                if ($lista_de_nos->childNodes != null && $lista_de_nos->childNodes->length > 0) {
                    return $this->gerar_arvore_de_conteudo($lista_de_nos->childNodes[0]);
                }
            }
        }

        return $arvore;
    }

     /** Recebe uma árvore de conteudos e retorna como um único array com ['chave' => 'valor'].
     *
     * @param Array $arvore_conteudo : árvore com conteudos
     * @return String $array : array de conteudo do xml como ['chave' => 'valor']
    */
    private function passa_para_array($arvore, $array = []) 
    {
        
        if (array_key_exists(0, $arvore)) {
            foreach ($arvore as $no) {
                $array = $this->passa_para_array($no, $array);
            }
        } else {
            if ($arvore != []) {
                $chave = array_key_first($arvore);
                if (array_key_exists($chave, $array)) {
                    $combinacao = array( $chave =>
                        [
                            'HEADER' => $array[$chave],
                            'DADOS' => $arvore[$chave],
                        ],
                    );
                    unset($array[$chave]);
                    $array = array_merge($array, $combinacao);
                } else {
                    $array = array_merge($array, $arvore);
                }
            }
        }

        return $array;
    }

    /** Converte uma string para bytes respeitando o valor da tabela ASCII.
     *
     * @param string $string : string a qual vai ser convertida
     * @return string $resultado : resultado em string com os valores de cada caracter concatenados
    */
    protected function string_to_bytes($string) {
        $resultado = '';
        
        for($i = 0; $i < strlen($string); $i++){
            $resultado .= ord($string[$i]);
        }

        return $resultado;
    }
}
