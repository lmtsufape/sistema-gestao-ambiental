<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telefone extends Model
{
    use HasFactory;

    public $fillable = [
        'numero',
    ];

    public function empresa()
    {
        return $this->hasOne(Empresa::class, 'telefone_id');
    }

    public function requerente()
    {
        return $this->hasOne(Requerente::class, 'telefone_id');
    }

    public function beneficiario()
    {
        return $this->hasOne(Beneficiario::class, 'telefone_id');
    }

    public function representanteLegal()
    {
        return $this->hasOne(RepresetanteLegal::class, 'telefone_id');
    }

    public function setNumero($numero)
    {
        $this->numero = $numero;
    }
}
