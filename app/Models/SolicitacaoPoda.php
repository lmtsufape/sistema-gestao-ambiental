<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitacaoPoda extends Model
{
    use HasFactory;

    protected $table = 'solicitacoes_podas';

    protected $fillable = [
        'protocolo',
        'motivo_indeferimento',
        'status',
        'analista_id',
        'autorizacao_ambiental',
        'comentario',
        'area',
    ];

    public const STATUS_ENUM = [
        'registrada' => 1,
        'deferido' => 2,
        'indeferido' => 3,
        'encaminhada' => 4,
    ];

    public const AREA_ENUM = [
        'publica' => 1,
        'privada' => 2,
    ];

    public function visita()
    {
        return $this->hasOne(Visita::class, 'solicitacao_poda_id');
    }

    public function requerente()
    {
        return $this->belongsTo(Requerente::class);
    }

    public function fotos()
    {
        return $this->hasMany(FotoPoda::class, 'solicitacao_poda_id');
    }

    public function endereco()
    {
        return $this->belongsTo(Endereco::class);
    }

    public function analista()
    {
        return $this->belongsTo(User::class, 'analista_id');
    }

    public function ficha()
    {
        return $this->hasOne(FichaAnalise::class, 'solicitacao_poda_id');
    }

    public function laudo()
    {
        return $this->hasOne(LaudoTecnico::class, 'solicitacao_poda_id');
    }

    public function statusSolicitacao()
    {
        switch ($this->status) {
            case SolicitacaoPoda::STATUS_ENUM['registrada']:
                return 'registrada';
                break;
            case SolicitacaoPoda::STATUS_ENUM['deferido']:
                return 'deferida';
                break;
            case SolicitacaoPoda::STATUS_ENUM['indeferido']:
                return 'indeferida';
                break;
            case SolicitacaoPoda::STATUS_ENUM['encaminhada']:
                return 'encaminhada';
                break;
        }
    }

    public function getStatusStringAttribute()
    {
        return ucwords($this->statusSolicitacao());
    }
}
