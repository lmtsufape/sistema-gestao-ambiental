<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class SolicitacaoMuda extends Model implements AuditableContract
{
    use HasFactory;
    use Auditable;

    protected $table = 'solicitacoes_mudas';

    protected $auditInclude = [
        'protocolo',
        'comentario',
        'motivo_indeferimento',
        'status',
        'local',
    ];

    protected $fillable = [
        'protocolo',
        'comentario',
        'motivo_indeferimento',
        'status',
        'local'
    ];

    public const STATUS_ENUM = [
        'registrada' => 1,
        'deferido' => 2,
        'indeferido' => 3,
    ];

    public function requerente()
    {
        return $this->belongsTo(Requerente::class);
    }

    public function endereco()
    {
        return $this->belongsTo(Endereco::class);
    }

    public function mudasSolicitadas()
    {
        return $this->hasMany(MudaSolicitada::class, 'solicitacao_id');
    }

    public function statusSolicitacao()
    {
        switch ($this->status) {
            case SolicitacaoMuda::STATUS_ENUM['registrada']:
                return 'registrada';
                break;
            case SolicitacaoMuda::STATUS_ENUM['deferido']:
                return 'deferida';
                break;
            case SolicitacaoMuda::STATUS_ENUM['indeferido']:
                return 'indeferida';
                break;
        }
    }

    public function getStatusStringAttribute()
    {
        return ucwords($this->statusSolicitacao());
    }
}
