<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pipeiro extends Model
{
    use HasFactory;

    protected $table = 'motorista';

    protected $fillable = [
        'motorista',
        'capacidade_tanque',
        'nome_apelido',
    ];

    public function setAtributes($request){
        $this->motorista = $request['motorista'];
        $this->capacidade_tanque = $request['capacidade_tanque'];
        $this->nome_apelido = $request['nome_apelido'];
    }
}
