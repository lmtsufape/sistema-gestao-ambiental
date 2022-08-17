<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoVisita extends Model
{
    use HasFactory;

    protected $fillable = [
        'caminho',
        'comentario',
    ];

    public function visita()
    {
        return $this->belongsTo(Visita::class, 'visita_id');
    }
}
