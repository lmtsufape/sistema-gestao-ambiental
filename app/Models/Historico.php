<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historico extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function porte()
    {
        return $this->hasOne(ModificacaoPorte::class, 'historico_id');
    }

    public function cnaes()
    {
        return $this->hasMany(ModificacaoCnae::class, 'historico_id');
    }
}
