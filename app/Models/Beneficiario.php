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



    public function telefone() {
        return $this->belongsTo(Telefone::class);
    }

    public function endereco() {
        return $this->belongsTo(Endereco::class);
    }


    public function setAtributes($input){
        $this->nome = $input['name'];
        $this->cpf = $input['cpf'];
        $this->rg = $input['rg'];
        $this->nis = $input['nis'];
        $this->orgao_emissor = $input['orgao_emissor'];
        $this->quantidade_pessoas = $input['quantidade_pessoas'];
        $this->observacao = $input['observacao'];
        $this->tipo_beneficiario =  $input['tipo_beneficiario'];
        $this->codigo = $input['codigo'];
    }

}