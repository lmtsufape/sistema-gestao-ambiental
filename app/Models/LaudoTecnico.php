<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaudoTecnico extends Model
{
    use HasFactory;
    protected $table = 'laudos_tecnicos';
    protected $fillable = [
        'condicoes',
        'localizacao',
    ];

    public function fotos()
    {
        return $this->hasMany(FotoLaudoTecnico::class, 'laudo_tecnico_id');
    }

    public function solicitacaoPoda()
    {
        return $this->belongsTo(SolicitacaoPoda::class, 'solicitacao_poda_id');
    }
}
