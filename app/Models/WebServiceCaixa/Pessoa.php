<?php

namespace App\Models\WebServiceCaixa;

use App\Models\Empresa;

class Pessoa 
{
    // CPF : long[11] 
    public $cpf;

    // NOME : char[40]
    public $nome;

    // CNPJ : long[14]
    public $cnpj;

    // RAZAO_SOCIAL : char[40]
    public $razao_social;

    // LOGRADOURO : char[40]
    public $logradouro;

    // BAIRRO : char[15]
    public $bairro;

    // CIDADE : char[15]
    public $cidade;

    // UF : char[2]
    public $uf;

    // CEP : integer
    public $cep;

    // CÓDIGO BENEFICIARIO : char[7]
    public $cod_beneficiario;

    /** Função que seta os dados do pagador através de uma empresa passada.
     *
     * @param  Empresa $emrepsa
     * @return void
    */
    public function gerar_pagador(Empresa $empresa) 
    {
        if ($empresa->eh_cnpj) {
            $this->cnpj = $empresa->cpf_cnpj;
            $this->razao_social = $empresa->nome;
        } else {
            $this->cpf = $empresa->cpf_cnpj;
            $this->nome = $empresa->user;
        }
        
        $this->logradouro = $empresa->endereco->rua;
        $this->cidade = $empresa->endereco->cidade;
        $this->bairro = $empresa->endereco->bairro;
        $this->uf = $empresa->endereco->uf;
        $this->cep = $empresa->endereco->cep;
    }

    /** Função que seta os dados do beneficiario através dos dados configurados no .env.
     *
     * @param  Empresa $emrepsa
     * @return void
    */
    public function gerar_beneficiario() 
    {
        $this->cnpj = env('CNPJ_EMPRESA_BENEFICIADA');
        $this->razao_social = env('NOME_EMPRESA_BENEFICIADA');
        $this->cod_beneficiario = env('CODIGO_BENEFICIARIO');

        $this->logradouro = env('ENDERECO_EMPRESA_BENEFICIADA') . ', ' . env('NUMERO_EMPRESA_BENEFICIADA');
        $this->cidade = env('CIDADE_EMPRESA_BENEFICIADA');
        $this->bairro = env('BAIRRO_EMPRESA_BENEFICIADA');
        $this->uf = env('UF_EMPRESA_BENEFICIADA');
        $this->cep = env('CEP_EMPRESA_BENEFICIADA');
    }
}
