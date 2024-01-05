<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feirante extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'data_nascimento',
        'rg',
        'orgao_emissor',
        'cpf',
        'atividade_comercial',
        'residuos_gerados',
        'protocolo_vigilancia_sanitaria',
        'telefone_id',
        'endereco_residencia_id',
        'endereco_comercio_id'
    ];



    public function telefone()
    {
        return $this->belongsTo(Telefone::class, 'telefone_id');
    }

    public function endereco()
    {
        return $this->belongsTo(Endereco::class, 'endereco_id');
    }


    public function setAtributes($input)
    {
        $this->nome = $input['name'];
        $this->data_nascimento = $input['data_nascimento'];
        $this->rg = $input['rg'];
        $this->orgao_emissor = $input['orgao_emissor'];
        $this->cpf = $input['cpf'];
        $this->atividade_comercial = $input['atividade_comercial'];
        $this->residuos_gerados = $input['residuos_gerados'];
        $this->protocolo_vigilancia_sanitaria = $input['protocolo_vigilancia_sanitaria'];
    }
}
