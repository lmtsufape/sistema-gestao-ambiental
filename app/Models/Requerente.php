<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requerente extends Model
{
    use HasFactory;

    public $fillable = [
        'cpf',
        'rg',
        'orgao_emissor',
    ];

    public function setAtributes($input)
    {
        $this->cpf              = $input['cpf'];
        $this->rg               = $input['rg'];
        $this->orgao_emissor    = $input['orgão_emissor'];
    }
}
