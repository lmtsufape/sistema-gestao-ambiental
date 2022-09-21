<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitacaoMuda extends Model
{
    use HasFactory;

    protected $table = 'solicitacoes_mudas';

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
}
