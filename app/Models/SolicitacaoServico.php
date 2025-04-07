<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SolicitacaoServico extends Model
{   
    use HasFactory;

    protected $table = 'solicitacao_servicos';

    protected $fillable = [
        'data_solicitacao',
        'data_saida',
        'data_entrega',
        'motorista',
        'capacidade_tanque',
        'nome_apelido',
        'status',
        'observacao',
        'beneficiario_id',
        'codigo_solicitante',
    ];

    public const STATUS_ENUM = [
        'solicitacao_em_aberto' => 1,
        'rota_de_entrega' => 2,
        'entregue' => 3,
        'nao_encontrada' => 4,
        'outros' => 5,
        'cancelada' => 6,
    ];

    public function beneficiario() {
        return $this->belongsTo(Beneficiario::class, 'beneficiario_id');
    }

    public function motorista() {
        return $this->belongsTo(Pipeiro::class, 'motorista_id');
    }

    public function setAtributes($request){
        $this->data_solicitacao = $request['data_solicitacao'];
        $this->data_saida = $request['data_saida'];
        $this->data_entrega = $request['data_entrega'];
        $this->beneficiario_id = $request['beneficiario_id'];
        $this->observacao = $request['observacao'];
        $this->codigo_solicitante = $request['codigo_solicitante'];
    }

    public function fotos_abastecimento() {
        return $this->hasOne(FotosAbastecimento::class);
    }

}
