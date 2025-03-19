<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiario extends Model {

    use HasFactory;

    protected $table = 'beneficiario';

    public const ROLE_ENUM = [
        'aracao' => 0,
        'carro_pipa' => 1,
        'ambos' => 2
    ];

    protected $fillable = [
        'nome',
        'cpf',
        'rg',
        'orgao_emissor',
        'nis',
        'quantidade_pessoas',
        'observacao',
        'telefone_id',
        'endereco_id',
        'tipo_beneficiario',
        'codigo'
    ];



    public function telefone(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Telefone::class, 'telefone_id');
    }

    public function Endereco(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(EnderecoBeneficiario::class, 'endereco_id');
    }


    public function setAtributes($input){
        // 55299899
        $this->nome = $input['name'];
        $this->cpf = isset($input['cpf']) ? $input['cpf'] : null;
        $this->rg = isset($input['rg']) ? $input['rg'] : null;
        $this->nis = isset($input['nis']) ? $input['nis'] : null;
        $this->orgao_emissor = isset($input['orgao_emissor']) ? $input['orgao_emissor'] : null;
        $this->quantidade_pessoas = $input['quantidade_pessoas'] ? $input['orgao_emissor'] : null;
        $this->observacao = $input['observacao'] ? $input['orgao_emissor'] : null;;
        $this->tipo_beneficiario = $input['tipo_beneficiario'];
        $this->codigo = $input['codigo'] ?: null;;
}

}
