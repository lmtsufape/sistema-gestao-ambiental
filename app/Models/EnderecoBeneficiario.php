<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnderecoBeneficiario extends Model
{
    use HasFactory;

    protected $fillable = [
        'distrito',
        'comunidade',
        'cidade',
        'estado',
        'numero'
    ];


    public function beneficiario(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Beneficiario::class, 'endereco_id');
    }

    public function setAtributes($input)
    {
        $this->distrito = $input['distrito'];
        $this->comunidade = $input['comunidade'];
        $this->cidade = $input['cidade'];
        $this->estado = $input['uf'];
        $this->numero = $input['numero'];
    }


}
