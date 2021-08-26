<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;
    
    public $fillable = [
        'nome',
        'cnpj',
        'porte',
        'potencial_poluidor',
    ];

    public function setAtributes($input)
    {
        $this->nome = $input['nome_da_empresa'];
        $this->cnpj = $input['cnpj'];
        $this->porte = array_key_exists('porte', $input) ? $input['porte'] : null;
        $this->potencial_poluidor = array_key_exists('potencial_poluidor', $input) ? $input['potencial_poluidor'] : null;
    }
}
