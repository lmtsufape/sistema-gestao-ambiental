<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoFichaAnalise extends Model
{
    use HasFactory;

    protected $table = 'fotos_fichas_analises';

    protected $fillable = [
        'camimho',
    ];

    public function fichaAnalise()
    {
        return $this->belongsTo(FotoFichaAnalise::class, 'ficha_analise_id');
    }
}
