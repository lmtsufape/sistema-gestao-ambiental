<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepresetanteLegal extends Model
{
    use HasFactory;

    protected $fillable = [
        'cargo',
        'cpf',
        'rg',
        'orgao_emissor',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function telefone()
    {
        return $this->belongsTo(Telefone::class, 'telefone_id');
    }

    public function requerimentos()
    {
        return $this->hasMany(Requerimento::class, 'represetante_id');
    }

    public function empresas()
    {
        return $this->hasMany(Empresa::class, 'represetante_legal_id');
    }
}
