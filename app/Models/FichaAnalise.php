<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FichaAnalise extends Model
{
    use HasFactory;

    protected $table = 'fichas_analises';

    protected $fillable = [
        'condicoes',
        'localizacao',
    ];

    public function fotos()
    {
        return $this->hasMany(FotoFichaAnalise::class, 'ficha_analise_id');
    }

    public function solicitacaoPoda()
    {
        return $this->belongsTo(SolicitacaoPoda::class, 'solicitacao_poda_id');
    }
}
