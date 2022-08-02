<?php

namespace App\Models\WebServiceCaixa;

use Carbon\Carbon;

abstract class GerirBoletoRemessa extends Remessa
{
    public const URL = 'https://barramento.caixa.gov.br/sibar/ManutencaoCobrancaBancaria/Boleto/Externo';

    public string $operacao;

    /**
     * Código do Convênio no Banco (Código do Beneficiário).
     * Código fornecido pela CAIXA, através da agência de relacionamento do cliente.
     * Deve ser preenchido com o código do Beneficiário, até 7 posições, da esquerda para direita.
     * @var string $codigo_beneficiario
     */
    public string $codigo_beneficiario;

    /**
     * Nosso Número — Informação de entrada.
     * Se informado zeros, o nosso número será gerado pelo banco. Caso contrário deverá ser informado número iniciando com 14.
     * @var string $nosso_numero
     */
    public string $nosso_numero;

    /**
     * Número utilizado e controlado pelo Cliente, para identificar o título de cobrança. Poderá conter número de
     * duplicata, no caso de cobrança de duplicatas; número da apólice, no caso de cobrança de seguros, etc.
     * Campo de preenchimento obrigatório.
     * @var string $numero_do_documento
     */
    public string $numero_do_documento;

    /**
     * Data de vencimento do título de cobrança no formato YYYY-MM-DD
     * @var string $data_vencimento
     */
    public string $data_vencimento;

    /**
     * Valor original do Título. Valor expresso em moeda corrente, utilizar 2 casas decimais. Exemplo: 0000000000000.00
     * @var float $valor
     */
    public float $valor;

    /**
     * Código adotado para identificar o tipo de título de cobrança:
     * @var int $tipo_especie
     */
    public int $tipo_especie;

    /**
     * Identificação de Título Aceito / Não Aceito
     * Código adotado para identificar se o título de cobrança foi aceite (reconhecimento da dívida pelo Pagador):
     * @var string $flag_aceite
     */
    public string $flag_aceite;

    public bool $juros_mora = true;

    /**
     * Define o tipo de pagamento de juros de mora. ISENTO, VALOR_POR_DIA ou TAXA_MENSAL
     * @var string $tipo_juros_mora
     */
    public string $tipo_juros_mora;

    /**
     * Data indicativa do início da cobrança de Juros de Mora de um título de cobrança. Deverá ser maior que a Data de
     * Vencimento do título de cobrança. Utilizar o formato yyyy-MM-dd
     * @var string $data_juros_mora
     */
    public string $data_juros_mora;

    /**
     * Valor sobre o valor do título a ser cobrado de juros de mora.
     * @var float $valor_juros_mora
     */
    public float $valor_juros_mora;

    /**
     * Porcentagem sobre o valor do título a ser cobrado de juros de mora.
     * @var float $percentual_juros_mora
     */
    public float $percentual_juros_mora;

    /**
     * Indica se o boleto terá abatimento
     * @var bool $abatimento
     */
    public bool $abatimento = false;

    /**
     * Valor do abatimento (redução do valor do documento, devido a algum problema), expresso em moeda corrente
     * @var float $valor_abatimento
     */
    public float $valor_abatimento;

    /**
     * Indica se existe ação pós-vencimento.
     * @var bool $pos_vecimento
     */
    public bool $pos_vecimento = true;

    /**
     * Código de Instrução de Protesto ou Devolução. Valores admissíveis: PROTESTAR ou DEVOLVER
     * @var string $acao_pos_vecimento
     */
    public string $acao_pos_vecimento;

    /**
     * Número de dias para o protesto ou baixa por devolução do título não pago após o vencimento. Valores admissíveis:
     * PROTESTAR = 02 A 90 DIAS
     * DEVOLVER = 00 A 999 DIAS
     * @var int $numero_dias_pos_vencimento
     */
    public int $numero_dias_pos_vencimento;

    public Pessoa $pagador;

    public Pessoa $beneficiario;

    public $sacador_avalista;

    /**
     * Indica se será cobrado multa por atraso de pagamento.
     * @var bool $multa
     */
    public bool $multa = false;

    /**
     * Data a partir da qual a multa deverá ser cobrada. Na ausência, será considerada a data de vencimento.
     * Utilizar o formato yyyy-MM-dd
     * @var string $data_multa
     */
    public string $data_multa;

    /**
     * Valor de multa a ser aplicado sobre o valor do Título, por atraso no pagamento.
     * @var float $valor_multa
     */
    public float $valor_multa;

    /**
     * Percentual de multa a ser aplicado sobre o valor do Título, por atraso no pagamento.
     * @var float $percentual_multa
     */
    public float $percentual_multa;

    /**
     * Quantidade de descontos aplicados. Max: 3
     * @var int $descontos
     */
    public int $descontos = 0;

    /**
     * Data limite do desconto do título de cobrança. O Desconto 1 é aquele de maior valor e data de aplicação mais
     * distante da Data de Vencimento, enquanto o Desconto 3 é o de menor valor e mais próximo da Data de Vencimento.
     * Utilizar o formato yyyy-MM-dd
     * @var string[] $datas_desconto
     */
    public array $datas_desconto = [null, null, null];

    /**
     * Valor dos descontos a serem aplicados sobre o valor do Título.
     * @var float[] $valores_desconto
     */
    public array $valores_desconto = [null, null, null];

    /**
     * Percentuais de descontos a serem aplicados sobre o valor do Título
     * @var float[] $percentuais_desconto
     */
    public array $percentuais_desconto = [null, null, null];

    /**
     * Tipos de decontos. Valores aceitaveis: ISENTO, VALOR_FIXO_ATE_DATA ou PERCENTUAL_ATE_DATA
     * @var string[] $tipos_de_desconto
     */
    public array $tipos_de_desconto = [null, null, null];

    /**
     * Indica se o boleto tem IOF
     * @var bool $iof
     */
    public bool $iof = false;

    /**
     * Valor original do IOF — Imposto sobre Operações Financeiras de um título prêmio de seguro na sua data de
     * emissão, expresso conforme a moeda.
     * @var float $valor_iof
     */
    public float $valor_iof;

    /**
     * Campo destinado para uso da Empresa Beneficiário para identificação do Título.
     * @var string $identificacao_empresa
     */
    public string $identificacao_empresa;

    /**
     * Quantidade de mensagens da Ficha de Compensação. Max: 2
     * @var int $quant_mensagens_compensacao
     */
    public int $quant_mensagens_compensacao;

    /**
     * Texto de observações destinado ao envio de mensagens livres, a serem impressas no campo instruções da Ficha de
     * Compensação e na parte Recibo do Pagador do boleto. Ocorre até 2 vezes.
     * @var string[] $mensagens_compensacao
     */
    public array $mensagens_compensacao = [null, null];

    /**
     * Quantidade de mensagens do Recibo Pagador. Max: 4
     * @var int
     */
    public int $quant_mensagens_pagador;

    /**
     * Texto de observações destinado ao envio de mensagens livres, a serem impressas na parte Recibo do Pagador do
     * boleto. Max: 4.
     * @var string[] $mensagens_pagador
     */
    public array $mensagens_pagador = [null, null, null, null];

    // OPCOES_PAGAMENTO : Bool
    public bool $opcoes_pagamento = false;

    /**
     * Identificar a Quantidade de Pagamentos possíveis: de 1 a 99
     * @var int $quant_pagamento_permitido
     */
    public int $quant_pagamento_permitido = 0;

    /**
     * Registro para Identificação do Tipo de Pagamento
     * Valores: ACEITA_QUALQUER_VALOR, ACEITA_VALORES_ENTRE_MINIMO_MAXIMO, NAO_ACEITA_VALOR_DIVERGENTE,
     * SOMENTE_VALOR_MINIMO ou NÃO_ACEITA_VALOR_DIVERGENTE
     * @var string $tipos_de_pagamento
     */
    public string $tipos_de_pagamento;

    /**
     * Identificar o valor mínimo admissível para pagamento.
     * @var float $valor_minimo_pagamento
     */
    public float $valor_minimo_pagamento;

    /**
     * Identificar o valor máximo admissível para pagamento.
     * @var float $valor_maximo_pagamento
     */
    public float $valor_maximo_pagamento;

    /**
     * Identificar o percentual mínimo admissível para pagamento.
     * @var float $pencentual_minimo_pagamento
     */
    public float $pencentual_minimo_pagamento;

    /**
     * Identificar o percentual máximo admissível para pagamento.
     * @var float $pencentual_maximo_pagamento
     */
    public float $pencentual_maximo_pagamento;

    public function setAttributes(array $data)
    {
        $this->codigo_beneficiario = $data["codigo_beneficiario"];
        $this->data_vencimento = $data["data_vencimento"];
        $this->valor = $data["valor"];
        $this->pagador = $data["pagador"];
        $this->beneficiario = $data["beneficiario"];
        $this->nosso_numero = array_key_exists("nosso_numero", $data) ? $data["nosso_numero"] : "00000000000000000";
        $this->numero_do_documento = array_key_exists("numero_do_documento", $data) ? $data["numero_do_documento"] : $this->id;
        $this->tipo_especie = array_key_exists("tipo_especie", $data) ? $data["tipo_especie"] : "02";
        $this->flag_aceite = "N";
        $this->juros_mora = array_key_exists("tipo_juros_mora", $data) && $data["tipo_juros_mora"] != "ISENTO";
        $this->tipo_juros_mora = array_key_exists("tipo_juros_mora", $data) ? $data["tipo_juros_mora"] : "ISENTO";
        $this->valor_juros_mora = array_key_exists("valor_juros_mora", $data) ? $data["valor_juros_mora"] : 0;
        $this->percentual_juros_mora = array_key_exists("percentual_juros_mora", $data) ? $data["percentual_juros_mora"] : 0;
        $this->valor_abatimento = array_key_exists("valor_abatimento", $data) ? $data["valor_abatimento"] : 0;
        $this->acao_pos_vecimento = array_key_exists("acao_pos_vecimento", $data) ? $data["acao_pos_vecimento"] : "DEVOLVER";
        $this->numero_dias_pos_vencimento = array_key_exists("numero_dias_pos_vencimento", $data) ? $data["numero_dias_pos_vencimento"] : 15;
        $this->data_hora = now()->format("YmdHms");
        $this->sacador_avalista = array_key_exists("sacador_avalista", $data) ? $data['sacador_avalista'] : null;
        $this->multa = array_key_exists("data_multa", $data);
        $this->data_multa = array_key_exists("data_multa", $data) ? $data['data_multa'] : null;
        $this->valor_multa = array_key_exists("valor_multa", $data) ? $data['valor_multa'] : 0;
        $this->percentual_multa = array_key_exists("percentual_multa", $data) ? $data['percentual_multa'] : 0;
        $this->descontos = array_key_exists("datas_desconto", $data) ? (min(count($data['datas_desconto']), 3)) : 0;
        $this->datas_desconto = array_key_exists("datas_desconto", $data) ? $data['datas_desconto'] : [null, null, null];
        $this->valores_desconto = array_key_exists("valores_desconto", $data) ? $data['valores_desconto'] : [null, null, null];
        $this->percentuais_desconto = array_key_exists("percentuais_desconto", $data) ? $data['percentuais_desconto'] : [null, null, null];
        $this->tipos_de_desconto = array_key_exists("tipos_de_desconto", $data) ? $data['tipos_de_desconto'] : [null, null, null];
        $this->valor_iof = array_key_exists("valor_iof", $data) ? $data['valor_iof'] : 0;
        $this->quant_mensagens_compensacao = array_key_exists("mensagens_compensacao", $data) ? (min(count($data["mensagens_compensacao"]), 2)) : 0;
        $this->mensagens_compensacao = array_key_exists("mensagens_compensacao", $data) ? $data["mensagens_compensacao"] : [null, null];
        $this->quant_mensagens_pagador = array_key_exists("mensagens_pagador", $data) ? (min(count($data["mensagens_pagador"]), 4)) : 0;
        $this->mensagens_pagador = array_key_exists("mensagens_pagador", $data) ? $data["mensagens_pagador"] : [null, null, null, null];
        $this->quant_pagamento_permitido =  array_key_exists("quant_pagamento_permitido", $data) ?  count($data["quant_pagamento_permitido"]) : 0;
        $this->tipos_de_pagamento = array_key_exists("tipos_de_pagamento", $data) ? $data["tipos_de_pagamento"] : '';
        $this->valor_minimo_pagamento = array_key_exists("valor_minimo_pagamento", $data) ? $data["valor_minimo_pagamento"] : 0;
        $this->valor_maximo_pagamento = array_key_exists("valor_maximo_pagamento", $data) ? $data["valor_maximo_pagamento"] : 0;
        $this->pencentual_minimo_pagamento = array_key_exists("pencentual_minimo_pagamento", $data) ? $data["pencentual_minimo_pagamento"] : 0;
        $this->pencentual_maximo_pagamento = array_key_exists("pencentual_maximo_pagamento", $data) ? $data["pencentual_maximo_pagamento"] : 0;
    }

    /**
     * Gera o arquivo de remessa.
     * @return string $cabeçalho
     */
    public function gerar_remessa(): string
    {
        $xml_array = array(
            'soapenv:Body' => array(
                'ext:SERVICO_ENTRADA' => array(
                    'sib:HEADER' => array(
                        'VERSAO' => $this->versao,
                        'AUTENTICACAO' => $this->gerar_autenticacao(),
                        'USUARIO_SERVICO' => $this->usuario_servico,
                        'OPERACAO' => $this->operacao,
                        'SISTEMA_ORIGEM' => $this->sistema_origem,
                        'DATA_HORA' => $this->data_hora,
                    ),
                    'DADOS' => array(
                        $this->operacao => array(
                            'CODIGO_BENEFICIARIO' => $this->codigo_beneficiario,
                            'TITULO' => array(
                                'NOSSO_NUMERO' => $this->nosso_numero,
                                'NUMERO_DOCUMENTO' => $this->numero_do_documento,
                                'DATA_VENCIMENTO' => $this->data_vencimento,
                                'VALOR' => $this->gerar_valor($this->valor, 2),
                                'TIPO_ESPECIE' => $this->tipo_especie,
                                'FLAG_ACEITE' => $this->flag_aceite,
                                'JUROS_MORA' => $this->gerar_juros_mora(),
                                'VALOR_ABATIMENTO' => $this->gerar_valor($this->valor_abatimento, 2),
                                'POS_VENCIMENTO' => array(
                                    'ACAO' => $this->acao_pos_vecimento,
                                    'NUMERO_DIAS' => $this->numero_dias_pos_vencimento,
                                ),
                                'CODIGO_MOEDA' => $this->codigo_moeda,
                                'PAGADOR' => array(
                                    $this->etiqueta_cpf_ou_cnpj() => $this->gerar_cpf_ou_cnpj(),
                                    $this->etiqueta_nome_ou_razao_social() => $this->gerar_nome_ou_razao_social(),
                                    'ENDERECO' => array(
                                        'LOGRADOURO' => $this->validar_formartar_tamanho($this->pagador->logradouro, 40),
                                        'BAIRRO' => $this->validar_formartar_tamanho($this->pagador->bairro, 15),
                                        'CIDADE' => $this->validar_formartar_tamanho($this->pagador->cidade, 15),
                                        'UF' => $this->validar_formartar_tamanho($this->pagador->uf, 2),
                                        'CEP' => $this->retirar_formatacao($this->pagador->cep),
                                    )
                                ),
                                'SACADOR_AVALISTA' => $this->gerar_sacador_avalista(),
                                'MULTA' => $this->gerar_multa(),
                                'DESCONTOS' => $this->gerar_descontos(),
                                'VALOR_IOF' => $this->gerar_valor($this->valor_iof, 2),
                                'IDENTIFICACAO_EMPRESA' => $this->id,
                                'FICHA_COMPENSACAO' => $this->gerar_mensagens(),
                                'RECIBO_PAGADOR' => $this->gerar_mensagens_pagador(),
                                'PAGAMENTO' => $this->gerar_tipos_de_pagamento(),
                            )
                        )
                    )
                )
            )
        );
        if ($this->descontos == 0)
            unset($xml_array['soapenv:Body']['ext:SERVICO_ENTRADA']['DADOS'][$this->operacao]['TITULO']['DESCONTOS']);
        if ($this->sacador_avalista == null)
            unset($xml_array['soapenv:Body']['ext:SERVICO_ENTRADA']['DADOS'][$this->operacao]['TITULO']['SACADOR_AVALISTA']);
        if ($this->quant_mensagens_compensacao == 0)
            unset($xml_array['soapenv:Body']['ext:SERVICO_ENTRADA']['DADOS'][$this->operacao]['TITULO']['FICHA_COMPENSACAO']);
        if ($this->quant_mensagens_pagador == 0)
            unset($xml_array['soapenv:Body']['ext:SERVICO_ENTRADA']['DADOS'][$this->operacao]['TITULO']['RECIBO_PAGADOR']);
        if ($this->quant_pagamento_permitido == 0)
            unset($xml_array['soapenv:Body']['ext:SERVICO_ENTRADA']['DADOS'][$this->operacao]['TITULO']['PAGAMENTO']);
        if (!$this->iof)
            unset($xml_array['soapenv:Body']['ext:SERVICO_ENTRADA']['DADOS'][$this->operacao]['TITULO']['VALOR_IOF']);
        if (!$this->abatimento)
            unset($xml_array['soapenv:Body']['ext:SERVICO_ENTRADA']['DADOS'][$this->operacao]['TITULO']['VALOR_ABATIMENTO']);
        if ($this->operacao != 'INCLUI_BOLETO')
            unset($xml_array['soapenv:Body']['ext:SERVICO_ENTRADA']['DADOS'][$this->operacao]['TITULO']['CODIGO_MOEDA']);
        if ($this->operacao != 'INCLUI_BOLETO')
            unset($xml_array['soapenv:Body']['ext:SERVICO_ENTRADA']['DADOS'][$this->operacao]['TITULO']['PAGADOR'][$this->etiqueta_cpf_ou_cnpj()]);
        $xml_root = 'soapenv:Envelope';
        $xml = new XmlDomConstruct('1.0', 'ISO8859-1');
        $xml->formatOutput = true;
        $xml->fromMixed(array($xml_root => $xml_array));
        $xml_root_item = $xml->getElementsByTagName($xml_root)->item(0);
        $xml_root_item->setAttribute('xmlns:sib', 'http://caixa.gov.br/sibar');
        $xml_root_item->setAttribute('xmlns:ext', 'http://caixa.gov.br/sibar/manutencao_cobranca_bancaria/boleto/externo');
        $xml_root_item->setAttribute('xmlns:soapenv', 'http://schemas.xmlsoap.org/soap/envelope/');
        return $xml->saveXML();
    }

    /**
     * Gera a hash de autenticação do cabeçalho do arquivo.
     * @return string $cabeçalho
     */
    protected function gerar_autenticacao(): string
    {
        $data_vencimento_formatada = (new Carbon($this->data_vencimento))->format("dmY");
        $autenticacao = $this->codigo_beneficiario . $this->nosso_numero . $data_vencimento_formatada . $this->gerar_valor_atutenticacao() . $this->retirar_formatacao($this->beneficiario->cnpj);
        $hash = hash("sha256", $autenticacao, true);
        return base64_encode($hash);
    }

    /**
     * Retorna a parte dos descontos do xml, se tiver.
     * @return array parte do xml dos descontos
     */
    protected function gerar_descontos(): array
    {
        if ($this->descontos > 0) {
            $descontos = array(
                'DESCONTO' => array()
            );
            for ($i = 0; $i < $this->descontos; $i++) {
                $tipo = $this->valores_desconto[$i] != null ? 'VALOR' : 'PERCENTUAL';
                $desconto = $this->valores_desconto[$i] != null ?
                    $this->gerar_valor($this->valores_desconto[$i], 2) :
                    $this->gerar_valor($this->percentuais_desconto[$i], 5);
                $descontos['DESCONTO'][] = array(
                    'DATA' => $this->formatar_data($this->datas_desconto[$i]),
                    $tipo => $desconto,
                );
            }
            return $descontos;
        }
        return [];
    }

    protected function gerar_mensagens(): array
    {
        if ($this->quant_mensagens_compensacao > 0) {
            $array = array(
                'MENSAGENS' => array(
                    'MENSAGEM' => array()
                ),
            );
            for ($i = 0; $i < $this->quant_mensagens_compensacao; $i++) {
                $array['MENSAGENS']['MENSAGEM'][$i] = $this->validar_formartar_tamanho($this->mensagens_compensacao[$i], 40);
            }
            return $array;
        }
        return [];
    }

    protected function gerar_mensagens_pagador(): array
    {
        if ($this->quant_mensagens_pagador > 0) {
            $msgs = array(
                'MENSAGENS' => array(
                    'MENSAGEM' => array()
                )
            );
            for ($i = 0; $i < $this->quant_mensagens_pagador; $i++) {
                $msgs['MENSAGENS']['MENSAGEM'][$i] = $this->validar_formartar_tamanho($this->mensagens_pagador[$i], 40);
            }
            return $msgs;
        }
        return [];
    }

    protected function gerar_tipos_de_pagamento(): array
    {
        if ($this->quant_pagamento_permitido > 0) {
            $pgmts = array(
                'QUANTIDADE_PERMITIDA' => $this->quant_pagamento_permitido,
                'TIPO' => $this->tipos_de_pagamento,
            );
            if ($this->valor_maximo_pagamento > 0) {
                $pgmts['VALOR_MINIMO'] = $this->gerar_valor($this->valor_minimo_pagamento, 2);
                $pgmts['VALOR_MAXIMO'] = $this->gerar_valor($this->valor_maximo_pagamento, 2);
            } else {
                $pgmts['PERCENTUAL_MINIMO'] = $this->gerar_valor($this->pencentual_minimo_pagamento, 5);
                $pgmts['PERCENTUAL_MAXIMO'] = $this->gerar_valor($this->pencentual_maximo_pagamento, 5);
            }
            return $pgmts;
        }
        return [];
    }

    protected function gerar_sacador_avalista(): array
    {
        if ($this->sacador_avalista != null) {
            if ($this->sacador_avalista->cpf) {
                return array(
                    'CPF' => $this->retirar_formatacao($this->sacador_avalista->cpf),
                    'NOME' => $this->validar_formartar_tamanho($this->sacador_avalista->nome, 40),
                );
            } else {
                return array(
                    'CNPJ' => $this->retirar_formatacao($this->sacador_avalista->cnpj),
                    'RAZAO_SOCIAL' => $this->validar_formartar_tamanho($this->sacador_avalista->razao_social, 40),
                );
            }
        }
        return [];
    }

    protected function gerar_juros_mora(): array
    {
        $array = array(
            'TIPO' => $this->tipo_juros_mora,
        );
        if ($this->tipo_juros_mora != 'ISENTO')
            $array['DATA'] = $this->data_juros_mora;
        if ($this->tipo_juros_mora == 'TAXA_MENSAL')
            $array['PERCENTUAL'] = $this->gerar_valor($this->percentual_juros_mora, 5);
        else
            $array['VALOR'] = $this->gerar_valor($this->valor_juros_mora, 2);
        return $array;
    }

    protected function gerar_nome_ou_razao_social(): string
    {
        if ($this->pagador->cpf)
            return $this->validar_formartar_tamanho($this->pagador->nome, 40);
        return $this->validar_formartar_tamanho($this->pagador->razao_social, 40);
    }

    protected function gerar_cpf_ou_cnpj(): string
    {
        if ($this->pagador->cpf)
            return $this->retirar_formatacao($this->pagador->cpf);
        return $this->retirar_formatacao($this->pagador->cnpj);
    }

    protected function etiqueta_nome_ou_razao_social(): string
    {
        if ($this->pagador->cpf)
            return 'NOME';
        return 'RAZAO_SOCIAL';
    }

    protected function etiqueta_cpf_ou_cnpj(): string
    {
        if ($this->pagador->cpf)
            return 'CPF';
        return 'CNPJ';
    }

    protected function gerar_multa(): array
    {
        $array = array(
            'DATA' => $this->formatar_data($this->data_multa)
        );
        if ($this->valor_multa)
            $array['VALOR'] = $this->gerar_valor($this->valor_multa, 2);
        else
            $array['PERCENTUAL'] = $this->gerar_valor($this->percentual_multa, 5);
        return $array;
    }
}
