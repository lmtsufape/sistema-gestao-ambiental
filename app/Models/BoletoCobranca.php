<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class BoletoCobranca extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_vencimento',
        'caminho_arquivo_remessa',
        'caminho_arquivo_resposta',
        'codigo_de_barras',
        'linha_digitavel',
        'nosso_numero',
        'URL',
        'status_pagamento',
        'requerimento_id',
    ];

    public const STATUS_PAGAMENTO_ENUM = [
        'pago' => 1,
        'nao_pago' => 2,
        'vencido' => 3,
    ];

    public function requerimento(): BelongsTo
    {
        return $this->belongsTo(Requerimento::class, 'requerimento_id');
    }

    public function salvarArquivo($string)
    {
        delete_file($this->caminho_arquivo_remessa);
        $caminho_arquivo = 'remessas/';
        $documento_nome = 'incluir_boleto_remessa_' . $this->id . '.xml';
        $this->gerarArquivo($string, $caminho_arquivo . $documento_nome);
        $this->caminho_arquivo_remessa = $caminho_arquivo . $documento_nome;
    }

    private function gerarArquivo($string, $caminho)
    {
        $file = fopen(storage_path('') . '/app/' . $caminho, 'w+');

        fwrite($file, $string);

        fclose($file);
    }

    public function salvarArquivoResposta($string)
    {
        delete_file($this->resposta_incluir_boleto);
        $caminho_arquivo = 'remessas/';
        $documento_nome = 'resposta_incluir_boleto_remessa_' . $this->id . '.xml';
        $this->gerarArquivo($string, $caminho_arquivo . $documento_nome);
        $this->resposta_incluir_boleto = $caminho_arquivo . $documento_nome;
    }

    public function salvarArquivoRespostaAlterarBoleto($string)
    {
        delete_file($this->resposta_alterar_boleto);
        $caminho_arquivo = 'remessas/';
        $documento_nome = 'resposta_alterar_boleto_remessa_' . $this->id . '.xml';
        $this->gerarArquivo($string, $caminho_arquivo . $documento_nome);
        $this->resposta_alterar_boleto = $caminho_arquivo . $documento_nome;
    }
}
