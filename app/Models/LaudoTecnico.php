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
        'pdf',
        'licenca',
        'atividade'
    ];

    public const ATIVIDADE_ENUM = [
        'Supressao' => 1,
        'Poda' => 2,
        'Sem intervenção' => 3,
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
