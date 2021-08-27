<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cnae extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'codigo',
        'potencial_poluidor',
    ];

    public function setor()
    {
        return $this->belongsTo(Setor::class, 'setor_id');
    }

    public function empresas() 
    {
        return $this->hasMany(Empresa::class, 'cnae_id');
    }
}
