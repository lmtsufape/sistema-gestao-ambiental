<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    protected $fillable = [
        'cep',
        'numero',
        'cidade',
        'estado',
        'bairro',
        'rua',
        'complemento',
    ];

    public function setAtributes($input) 
    {
        $this->cep          = $input['cep'];
        $this->numero       = $input['número'];
        $this->cidade       = $input['cidade'];
        $this->estado       = $input['estado'];
        $this->bairro       = $input['bairro'];
        $this->rua          = $input['rua'];
        $this->complemento  = array_key_exists('complemento', $input) ? $input['complemento'] : null;
    }

    public function setAtributesEmpresa($input) 
    {
        $this->cep          = $input['cep_da_empresa'];
        $this->numero       = $input['número_da_empresa'];
        $this->cidade       = $input['cidade_da_empresa'];
        $this->estado       = $input['estado_da_empresa'];
        $this->bairro       = $input['bairro_da_empresa'];
        $this->rua          = $input['rua_da_empresa'];
        $this->complemento  = array_key_exists('complemento_da_empresa', $input) ? $input['complemento_da_empresa'] : null;
    }
}
