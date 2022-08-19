<?php

namespace App\Models\WebServiceCaixa;

use App\Models\BoletoCobranca;
use Carbon\Carbon;
use DOMDocument;
use DOMElement;

/**
 * Classe base para todas as categorias de remessas possíveis.
 * Inclui as etiquetas do cabeçalho do arquivo de remessa exceto a etiqueta OPERACAO,
 * colocada nas classes que herdam essa.
 */
abstract class Remessa extends BoletoCobranca
{
    // VERSAO : char[10]
    public $versao = '2.1';

    // AUTENTICACAO : char[64]
    public $autenticacao;

    // USUARIO_SERVICO : char[8]
    public $usuario_servico = 'SGCBS02P';

    // USUARIO : char[8]
    public $usuario;

    // INDICE : short[4]
    public $indice;

    // SISTEMA_ORIGEM : char[5]
    public $sistema_origem = 'SIGCB';

    // UNIDADE : char[4]
    public $unidade;

    // IDENTIFICADOR_ORIGEM : char[255]
    public $identificador_origem;

    // DATA_HORA : date (FORMATO yyyyMMddHHmmss) : char[14]
    public $data_hora;

    // ID_PROCESSO : char[50]
    public $id_processo;

    /**
     * Gera o valor do boleto com 15 casas, zeros a esquerda.
     *
     * @return string $cabeçalho
     */
    protected function gerarValorAtutenticacao()
    {
        $valor_string = number_format($this->valor, 2, '', '');

        return str_pad($valor_string, 15, '0', STR_PAD_LEFT);
    }

    /**
     * Retorna a string sem pontos, barras e traços.
     *
     * @param string $string
     * @return string $string
     */
    protected function retirarFormatacao($string)
    {
        $nova = '';
        for ($i = 0; $i < strlen($string); $i++) {
            if ($string[$i] != '.' && $string[$i] != '/' && $string[$i] != '-') {
                $nova .= $string[$i];
            }
        }

        return $nova;
    }

    /**
     * Retorna a 'string' do valor com ponto.
     *
     * @param float $valor Valor em double para ser formatado
     * @param int $num_casas Quantidade de casas decimais
     * @return string $string do valor com duas casas decimais
     */
    protected function gerarValor($valor, $num_casas): string
    {
        return number_format($valor, $num_casas, '.', '');
    }

    /**
     * Retorna a data formatada (yyyy-mm-dd), se tiver.
     *
     * @return string $string : parte do xml dos descontos
     */
    protected function formatarData($data): string
    {
        $data = new Carbon($data);

        return $data->format('Y-m-d');
    }

    /**
     * Valida o texto com o tamanho passado, se for menor ou igual ao tamanho
     * retorna o mesmo, caso contrario elimina os caracteres a partir do final.
     *
     * @param string $string Texto que deve ser validado e formatada
     * @param int $tamanho Tamanho limite da string
     * @return string $string string formatada
     */
    protected function validarFormartarTamanho(string $string, int $tamanho): string
    {
        $tam_string = strlen($string);
        $string = $this->retirarAcento($string);
        if ($tam_string > $tamanho) {
            return substr($string, 0, $tamanho);
        }

        return $string;
    }

    /**
     * Retira os acentos de uma ‘string’ passada.
     *
     * @param string $string string que o acento será retirado
     * @return string $string string sem acentos
     */
    protected function retirarAcento(string $string): string
    {
        return strtr(
            utf8_decode($string),
            utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ&'),
            'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUYE'
        );
    }

    /**
     * Recebe um reponse string xml com o resultado da chamada e converte para array.
     *
     * @param string $string_response string responsiva com conteudo em xml
     * @return array $array_conteudo array na forma ['tag' => 'conteudo_da_tag']
     */
    public function xmlToArray(string $string_response)
    {
        $dom_document = new DOMDocument();
        $dom_document->loadXML($string_response);
        $conteudo = $dom_document->childNodes[0]->childNodes[0]->childNodes[0];
        $arvore_conteudo = $this->gerarArvoreDeConteudo($conteudo);

        return $this->passaParaArray($arvore_conteudo);
    }

    /** Recebe DOMElement com a lista de nos e retorna uma árvore em array.
     *
     * @param DOMElement $lista_de_nos : Lista de elmentos xml
     * @return array $arvore : arvore de conteudo do xml como ['tag' => 'conteudo_da_tag']
     */
    private function gerarArvoreDeConteudo(DOMElement $lista_de_nos): array
    {
        $arvore = [];
        if ($lista_de_nos != null) {
            if ($lista_de_nos->childNodes != null && $lista_de_nos->childNodes->length == 1 && $lista_de_nos->childNodes[0]->childNodes->length == 0) {
                return [$lista_de_nos->tagName => $lista_de_nos->childNodes->item(0)->data];
            } elseif ($lista_de_nos->childNodes != null && $lista_de_nos->childNodes->length > 1) {
                for ($i = 0; $i < $lista_de_nos->childNodes->length; $i++) {
                    $arvore[] = $this->gerarArvoreDeConteudo($lista_de_nos->childNodes[$i]);
                }
            } elseif ($lista_de_nos->childNodes != null && $lista_de_nos->childNodes->length > 0) {
                return $this->gerarArvoreDeConteudo($lista_de_nos->childNodes[0]);
            }
        }

        return $arvore;
    }

    /**
     * Recebe uma árvore de conteudos e retorna como um único array com ['chave' => 'valor'].
     *
     * @param array $arvore
     * @param array $array
     * @return string $array : array de conteudo do xml como ['chave' => 'valor']
     */
    private function passaParaArray(array $arvore, array $array = [])
    {
        if (array_key_exists(0, $arvore)) {
            foreach ($arvore as $no) {
                $array = $this->passaParaArray($no, $array);
            }
        } else {
            if ($arvore != []) {
                $chave = array_key_first($arvore);
                if (array_key_exists($chave, $array)) {
                    $combinacao = [$chave => [
                        'HEADER' => $array[$chave],
                        'DADOS' => $arvore[$chave],
                    ],
                    ];
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
     * @param string $string string a qual vai ser convertida
     * @return string $resultado resultado em ‘string’ com os valores de cada caracter concatenados
     */
    protected function stringToBytes(string $string): string
    {
        $resultado = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $resultado .= ord($string[$i]);
        }

        return $resultado;
    }
}
