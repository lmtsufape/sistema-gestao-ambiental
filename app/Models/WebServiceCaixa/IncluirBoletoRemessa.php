<?php

namespace App\Models\WebServiceCaixa;

use App\Models\WebServiceCaixa\Remessa;
use Carbon\Carbon;

class IncluirBoletoRemessa extends Remessa
{
    public const URL = 'https://barramento.caixa.gov.br/sibar/ManutencaoCobrancaBancaria/Boleto/Externo';

    protected $table = 'boleto_cobrancas';

    // OPERACAO : char[50]
    public $operacao = "INCLUI_BOLETO";

    // CODIGO_BENEFICIARIO : int
    public $codigo_beneficiario;

    // NOSSO_NUMERO : long
    public $nosso_numero;

    // NUMERO_DOCUMENTO : char[11]
    public $numero_do_documento;
    
    // // DATA_VENCIMENTO : date (FORMATO yyyy-MM-dd)
    // public $data_vencimento;

    // VALOR : decimal com até 13,2 casas decimais
    public $valor;

    // TIPO_ESPECIE : short
    public $tipo_especie;

    // FLAG_ACEITE : char[1]
    public $flag_aceite;

    // DATA_EMISSAO : date (Formato yyyy-MM-dd)
    public $data_emissao;

    // JUROS_MORA : Boolean
    public $juros_mora = true;

    // TIPO_JUROS_MORA : string
    public $tipo_juros_mora;

    // DATA_JUROS_MORA : date (FORMATO yyyy-MM-dd)
    public $data_juros_mora;

    // VALOR_JUROS_MORA : decimal com até 13,2 casas decimais
    public $valor_juros_mora;

    // PERCENTUAL_JUROS_MORA : decimal com até 13,2 casas decimais
    public $percentual_juros_mora;

    // VALOR_ABATIMENTO : decimal com até 13,2 casas decimais
    public $valor_abatimento;

    // POS_VENCIMENTO : Bool
    public $pos_vecimento = true;

    // ACAO_POS_VENCIMENTO : string
    public $acao_pos_vecimento;

    // NUMERO_DIAS_POS_VENCIMENTO : short
    public $numero_dias_pos_vencimento;

    // CODIGO_MOEDA : short
    public $codigo_moeda = "09";

    // PAGADOR : Pessoa
    public $pagador;

    // BENEFICIARIO : Pessoa
    public $beneficiario;

    // SACADOR_AVALISTA : Pessoa
    public $sacador_avalista;

    // MULTA : Bool
    public $multa = false;

    // DATA_MULTA : date (Formato yyyy-MM-dd)
    public $data_multa;

    // VALOR_MULTA : decimal com até 13,2 casas decimais
    public $valor_multa;

    // PERCENTUAL : decimal com até 10,5 casas decimais
    public $percentual_multa;

    // DESCONTOS : integer, max 3
    public $descontos = 0;

    // DATAS_DOS_DESCONTOS : date (Formato yyyy-MM-dd)
    public $datas_desconto;

    // VALORES_DOS_DESCONTOS : decimal com até 13,2 casas decimais
    public $valores_desconto;

    // PERCENTUAIS_DOS_DESCONTOS : decimal com até 10,5 casas decimais
    public $percentuais_desconto;

    // TIPOS_DOS_DESCONTOS : ISENTO, VALOR_FIXO_ATE_DATA ou PERCENTUAL_ATE_DATA
    public $tipos_de_desconto;

    // VALOR_IOF : decimal com até 13,2 casas decimais
    public $valor_iof;

    // IDENTIFICACAO_EMPRESA : char[25]
    public $identificacao_empresa;

    // QUANTIDADE_DE_MENSAGENS_DE_COMPENSACAO : integer, max 2
    public $quant_mensagens_compensacao = 0;

    // MENSAGENS_COMPENSACAO : char[40]
    public $mensagens_compensacao;

    // QUANTIDADE_DE_MENSAGENS_DE_RECIBO_PAGADOR : integer, max 4
    public $quant_mensagens_pagador = 0;

    // MENSAGENS_COMPENSACAO : char[40]
    public $mensagens_pagador;

    // OPCOES_PAGAMENTO : Bool
    public $opcoes_pagamento = false;

    // QUANT_PAGAMENTOS_PERMITIDOS : short de 1 a 99
    public $quant_pagamento_permitido = 0;

    // TIPOS_DE_PAGAMENTO, Valores: ACEITA_QUALQUER_VALOR, ACEITA_VALORES_ENTRE_MINIMO_MAXIMO, NAO_ACEITA_VALOR_DIVERGENTE, SOMENTE_VALOR_MINIMO ou NÃO_ACEITA_VALOR_DIVERGENTE
    public $tipos_de_pagamento;

    // VALOR_MINIMO : decimal com até 13,2 casas decimais
    public $valor_minimo_pagamento;

    // VALOR_MAXIMO : decimal com até 13,2 casas decimais
    public $valor_maximo_pagamento;

    // PERCENTUAL_MINIMO : decimal com até 10,5 casas decimais
    public $pencentual_minimo_pagamento;

    // PERCENTUAL_MAXIMO : decimal com até 10,5 casas decimais
    public $pencentual_maximo_pagamento;

    /** Seta os dados da remessa.
     *
     * @param  Array $data
     * @return void
    */
    public function setAttributes($data)
    {
        $this->codigo_beneficiario = $data["codigo_beneficiario"];
        $this->data_vencimento = $data["data_vencimento"];
        $this->valor = $data["valor"];
        $this->pagador = $data["pagador"];
        $this->beneficiario = $data["beneficiario"];

        $this->nosso_numero = array_key_exists("nosso_numero", $data) ? $data["nosso_numero"] : "00000000000000000";
        $this->numero_do_documento = array_key_exists("numero_do_documento", $data) ? $data["numero_do_documento"] : $this->id;
        $this->tipo_especie = array_key_exists("tipo_especie", $data) ? $data["tipo_especie"] : "04";
        $this->flag_aceite = "S";
        $this->data_emissao = now()->format("Y-m-d");
        $this->juros_mora = array_key_exists("tipo_juros_mora", $data) && $data["tipo_juros_mora"] != "ISENTO" ? true : false;
        $this->tipo_juros_mora = array_key_exists("tipo_juros_mora", $data) ? $data["tipo_juros_mora"] : "ISENTO";
        $this->data_juros_mora = array_key_exists("data_juros_mora", $data) ? now()->addDays($data["data_juros_mora"])->format("Y-m-d") : now()->addDays(3)->format("Y-m-d");
        $this->valor_juros_mora = array_key_exists("valor_juros_mora", $data) ? $data["valor_juros_mora"] : "0000000000000.00";
        $this->percentual_juros_mora = array_key_exists("percentual_juros_mora", $data) ? $data["percentual_juros_mora"] : "00000000000.00000";
        $this->valor_abatimento = array_key_exists("valor_abatimento", $data) ? $data["valor_abatimento"] : "0000000000000.00";
        $this->acao_pos_vecimento = array_key_exists("acao_pos_vecimento", $data) ? $data["acao_pos_vecimento"] : "DEVOLVER";
        $this->numero_dias_pos_vencimento = array_key_exists("numero_dias_pos_vencimento", $data) ? $data["numero_dias_pos_vencimento"] : "00";
        $this->data_hora = now()->format("YmdHms");
        $this->codigo_moeda = array_key_exists("codigo_moeda", $data) ? $data['codigo_moeda'] : "09";
        $this->sacador_avalista = array_key_exists("sacador_avalista", $data) ? $data['sacador_avalista'] : null;
        $this->multa = array_key_exists("data_multa", $data);
        $this->data_multa = array_key_exists("data_multa", $data) ? $data['data_multa'] : null;
        $this->valor_multa = array_key_exists("valor_multa", $data) ? $data['valor_multa'] : null;
        $this->percentual_multa = array_key_exists("percentual_multa", $data) ? $data['percentual_multa'] : null;
        $this->descontos = array_key_exists("datas_desconto", $data) ? (count($data['datas_desconto']) <= 3 ? count($data['datas_desconto']) : 3) : 0;
        $this->datas_desconto = array_key_exists("datas_desconto", $data) ? $data['datas_desconto'] : [null, null, null];
        $this->valores_desconto = array_key_exists("valores_desconto", $data) ? $data['valores_desconto'] : [null, null, null];
        $this->percentuais_desconto = array_key_exists("percentuais_desconto", $data) ? $data['percentuais_desconto'] : [null, null, null];
        $this->tipos_de_desconto = array_key_exists("tipos_de_desconto", $data) ? $data['tipos_de_desconto'] : [null, null, null];
        $this->valor_iof = array_key_exists("valor_iof", $data) ? $data['valor_iof'] : null;
        $this->quant_mensagens_compensacao = array_key_exists("mensagens_compensacao", $data) ? (count($data["mensagens_compensacao"]) <= 2 ? count($data["mensagens_compensacao"]) : 2) : 0;
        $this->mensagens_compensacao = array_key_exists("mensagens_compensacao", $data) ? $data["mensagens_compensacao"] : [null, null];
        $this->quant_mensagens_pagador = array_key_exists("mensagens_pagador", $data) ? (count($data["mensagens_pagador"]) <= 4 ? count($data["mensagens_pagador"]) : 4) : 0;
        $this->mensagens_pagador = array_key_exists("mensagens_pagador", $data) ? $data["mensagens_pagador"] : [null, null, null, null];
        $this->quant_pagamento_permitido =  array_key_exists("quant_pagamento_permitido", $data) ?  count($data["quant_pagamento_permitido"]) : 0;
        $this->tipos_de_pagamento = array_key_exists("tipos_de_pagamento", $data) ? $data["tipos_de_pagamento"] : null;
        $this->valor_minimo_pagamento = array_key_exists("valor_minimo_pagamento", $data) ? $data["valor_minimo_pagamento"] : null;
        $this->valor_maximo_pagamento = array_key_exists("valor_maximo_pagamento", $data) ? $data["valor_maximo_pagamento"] : null;
        $this->pencentual_minimo_pagamento = array_key_exists("pencentual_minimo_pagamento", $data) ? $data["pencentual_minimo_pagamento"] : null;
        $this->pencentual_maximo_pagamento = array_key_exists("pencentual_maximo_pagamento", $data) ? $data["pencentual_maximo_pagamento"] : null;
    }

    /** Gera o arquivo de remessa.
     *
     * @return String $cabeçalho
    */
    public function gerar_remessa() 
    {
        return "<?xml version='1.0' encoding='ISO8859-1'?>
                <soapenv:Envelope xmlns:soapenv='http://schemas.xmlsoap.org/soap/envelope/'>
                <soapenv:Header/>
                <soapenv:Body>
                <manutencaocobrancabancaria:SERVICO_ENTRADA xmlns:manutencaocobrancabancaria='http://caixa.gov.br/sibar/manutencao_cobranca_bancaria/boleto/externo' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:schemaLocation='http://caixa.gov.br/sibar/manutencao_cobranca_bancaria/boleto/externo Emite_Boleto.xsd'>
                \t<sibar_base:HEADER xmlns:sibar_base='http://caixa.gov.br/sibar' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:schemaLocation='http://caixa.gov.br/sibar MensagensBarramento.xsd'>
                \t\t<VERSAO>".$this->versao."</VERSAO>
                \t\t<AUTENTICACAO>".$this->gerar_autenticacao()."</AUTENTICACAO>
                \t\t<USUARIO_SERVICO>".$this->usuario_servico."</USUARIO_SERVICO>
                \t\t<OPERACAO>".$this->operacao."</OPERACAO>
                \t\t<SISTEMA_ORIGEM>".$this->sistema_origem."</SISTEMA_ORIGEM>
                \t\t<DATA_HORA>".$this->data_hora."</DATA_HORA>
                \t</sibar_base:HEADER>
                \t<DADOS>
                \t<INCLUI_BOLETO>
                \t\t<CODIGO_BENEFICIARIO>".$this->codigo_beneficiario."</CODIGO_BENEFICIARIO>
                \t\t<TITULO>
                \t\t\t<NOSSO_NUMERO>".$this->nosso_numero."</NOSSO_NUMERO>
                \t\t\t<NUMERO_DOCUMENTO>".$this->numero_do_documento."</NUMERO_DOCUMENTO>
                \t\t\t<DATA_VENCIMENTO>".$this->data_vencimento."</DATA_VENCIMENTO>
                \t\t\t<VALOR>".$this->gerar_valor($this->valor, 2)."</VALOR>
                \t\t\t<TIPO_ESPECIE>".$this->tipo_especie."</TIPO_ESPECIE>
                \t\t\t<FLAG_ACEITE>".$this->flag_aceite."</FLAG_ACEITE>
                \t\t\t<DATA_EMISSAO>".$this->data_emissao."</DATA_EMISSAO>
                \t\t\t<JUROS_MORA>
                \t\t\t\t<TIPO>".$this->tipo_juros_mora."</TIPO>".($this->tipo_juros_mora != 'ISENTO' ? "\t\t\t\t<DATA>".$this->data_juros_mora."</DATA>" : "") ."
                \t\t\t\t".($this->tipo_juros_mora == 'ISENTO' ? "<VALOR>".$this->valor_juros_mora."</VALOR>" : ($this->valor_juros_mora != "0000000000000.00" ? "<VALOR>".$this->gerar_valor($this->valor_juros_mora, 2)."</VALOR>" : "<PERCENTUAL>".$this->gerar_valor($this->percentual_juros_mora, 5)."</PERCENTUAL>"))."
                \t\t\t</JUROS_MORA>
                \t\t\t<VALOR_ABATIMENTO>".($this->valor_abatimento != "0000000000000.00" ? $this->gerar_valor($this->valor_abatimento, 2) : $this->valor_abatimento)."</VALOR_ABATIMENTO>\n".($this->pos_vecimento ?
                "\t\t\t<POS_VENCIMENTO>
                \t\t\t\t<ACAO>".$this->acao_pos_vecimento."</ACAO>
                \t\t\t\t<NUMERO_DIAS>".$this->numero_dias_pos_vencimento."</NUMERO_DIAS>
                \t\t\t</POS_VENCIMENTO>" : "")."
                \t\t\t<CODIGO_MOEDA>".$this->codigo_moeda."</CODIGO_MOEDA>
                \t\t\t<PAGADOR>
                \t\t\t\t".($this->pagador->cpf ? "<CPF>".$this->retirar_formatacao($this->pagador->cpf)."</CPF>" : "<CNPJ>".$this->retirar_formatacao($this->pagador->cnpj)."</CNPJ>")."
                \t\t\t\t".($this->pagador->cpf ? "<NOME>".$this->validar_formartar_tamanho($this->pagador->nome, 40)."</NOME>" : "<RAZAO_SOCIAL>".$this->validar_formartar_tamanho($this->pagador->razao_social, 40)."</RAZAO_SOCIAL>")."
                \t\t\t\t<ENDERECO>
                \t\t\t\t\t<LOGRADOURO>".$this->validar_formartar_tamanho($this->pagador->logradouro, 40)."</LOGRADOURO>
                \t\t\t\t\t<BAIRRO>".$this->validar_formartar_tamanho($this->pagador->bairro, 15)."</BAIRRO>
                \t\t\t\t\t<CIDADE>".$this->validar_formartar_tamanho($this->pagador->cidade, 15)."</CIDADE>
                \t\t\t\t\t<UF>".$this->validar_formartar_tamanho($this->pagador->uf, 2)."</UF>
                \t\t\t\t\t<CEP>".$this->retirar_formatacao($this->pagador->cep)."</CEP>
                \t\t\t\t</ENDERECO>
                \t\t\t</PAGADOR>".($this->sacador_avalista != null ? 
                "\t\t\t<SACADOR_AVALISTA>
                \t\t\t\t".($this->sacador_avalista->cpf ? "<CPF>".$this->retirar_formatacao($this->sacador_avalista->cpf)."</CPF>" : "<CNPJ>".$this->retirar_formatacao($this->sacador_avalista->cnpj)."</CNPJ>") ."
                \t\t\t\t".($this->sacador_avalista->nome ? "<NOME>".$this->validar_formartar_tamanho($this->sacador_avalista->nome, 40)."</NOME>" : "<RAZAO_SOCIAL>".$this->validar_formartar_tamanho($this->sacador_avalista->razao_social, 40)."</RAZAO_SOCIAL>")."
                \t\t\t</SACADOR_AVALISTA>"
                : "")."".($this->multa ? "
                \t\t\t<MULTA>
                \t\t\t\t<DATA>".$this->formatar_data($this->data_multa)."</DATA> 
                \t\t\t\t".($this->valor_multa != null ? "<VALOR>".$this->gerar_valor($this->valor_multa, 2)."</VALOR>" : "<PERCENTUAL>".$this->gerar_valor($this->percentual_multa, 5)."</PERCENTUAL>")."
                \t\t\t\t</MULTA>" : "")."".($this->descontos > 0 ? $this->gerar_descontos(): "")."".($this->valor_iof != null ? "\t\t\t\t<VALOR_IOF>".$this->formatar_data($this->valor_iof, 2)."</VALOR_IOF>" : "")."
                \t\t\t\t<IDENTIFICACAO_EMPRESA>".$this->id."</IDENTIFICACAO_EMPRESA>".($this->quant_mensagens_compensacao > 0 ? $this->gerar_mensagens(): "")."".($this->quant_mensagens_pagador > 0 ? $this->gerar_mensagens_pagador() : "")."".($this->quant_pagamento_permitido > 0 ? $this->gerar_tipos_de_pagamento() : "")."
                \t\t\t</TITULO>
                \t\t</INCLUI_BOLETO>
                \t</DADOS>
                </manutencaocobrancabancaria:SERVICO_ENTRADA>
                </soapenv:Body>
                </soapenv:Envelope>";
    }

    /** Gera a hash de atutenticação do cabeçalho do arquivo.
     *
     * @return String $cabeçalho
    */

    private function gerar_autenticacao()
    {
        $data_vencimento_formatada = (new Carbon($this->data_vencimento))->format("dmY");
        $autenticacao = $this->codigo_beneficiario . $this->nosso_numero . $data_vencimento_formatada . $this->gerar_valor_atutenticacao() . $this->retirar_formatacao($this->beneficiario->cnpj); 

        $hash = hash("sha256", $autenticacao);
        return base64_encode($hash);
    }

    /** Retorna a parte dos descontos do xml, se tiver.
     *
     * @return String $string : parte do xml dos descontos
    */
    private function gerar_descontos()
    {
        $retorno = "\t\t\t\t<DESCONTOS>";
        for($i = 0; $i < $this->descontos; $i++) {
            $retorno .=  "\t\t\t\t\t<DESCONTO>
                          \t\t\t\t\t\t<DATA>".$this->formatar_data($this->datas_desconto[$i])."</DATA>
                          \t\t\t\t\t\t".($this->valores_desconto[$i] != null ? "<VALOR>".$this->gerar_valor($this->valores_desconto[$i], 2)."</VALOR>" : "<PERCENTUAL>".$this->gerar_valor($this->percentuais_desconto[$i], 5)."</PERCENTUAL>" )."
                          \t\t\t\t\t\t<TIPO>".$this->tipos_de_desconto[$i]."<TIPO>
                          \t\t\t\t\t</DESCONTO>";
        }
        return $retorno . "\t\t\t\t</DESCONTOS>";
    }

    private function gerar_mensagens()
    {
        $retorno = "\t\t\t\t<FICHA_COMPENSACAO>\t\t\t\t\t<MENSAGENS>";
        for($i = 0; $i < $this->descontos; $i++) {
            $retorno .= "\t\t\t\t\t\t<MENSAGEM>".$this->mensagens_compensacao[$i]."</MENSAGEM>";
        }
        return $retorno . "\t\t\t\t\t</MENSAGENS>\t\t\t\t</FICHA_COMPENSACAO>";
    }

    private function gerar_mensagens_pagador() 
    {
        $retorno = "\t\t\t\t<RECIBO_PAGADOR>\t\t\t\t\t<MENSAGENS>";
        for($i = 0; $i < $this->quant_mensagens_pagador; $i++) {
            $retorno .= "\t\t\t\t\t\t<MENSAGEM>".$this->mensagens_pagador[$i]."</MENSAGEM>";
        }
        return $retorno . "\t\t\t\t\t</MENSAGENS>\t\t\t\t</RECIBO_PAGADOR>";
    }

    private function gerar_tipos_de_pagamento()
    {
        $retorno = "\t\t\t\t<PAGAMENTO><QUANTIDADE_PERMITIDA>".$this->quant_pagamento_permitido."</QUANTIDADE_PERMITIDA>";
        for($i = 0; $i < $this->quant_pagamento_permitido; $i++) {
            $retorno .= "\t\t\t\t\t<TIPO>".$this->tipos_de_pagamento[$i]."</TIPO>";
            $retorno .= "\t\t\t\t\t".($this->valor_minimo_pagamento[$i] ? "<VALOR_MINIMO>".$this->gerar_valor($this->valor_minimo_pagamento[$i], 2)."</VALOR_MINIMO>" : "<PERCENTUAL_MINIMO>".$this->gerar_valor($this->pencentual_minimo_pagamento[$i], 5)."</PERCENTUAL_MINIMO>")."";
            $retorno .= "\t\t\t\t\t".($this->valor_maximo_pagamento[$i] ? "<VALOR_MAXIMO>".$this->gerar_valor($this->valor_maximo_pagamento[$i], 2)."</VALOR_MAXIMO>" : "<PERCENTUAL_MAXIMO>".$this->gerar_valor($this->pencentual_maximo_pagamento[$i], 5)."</PERCENTUAL_MAXIMO>")."";
        }
        return $retorno . "\t\t\t\t</PAGAMENTO>";
    }
}
