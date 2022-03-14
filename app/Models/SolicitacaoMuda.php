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
        'qtd_mudas',
        'status',
        'especie_id'
    ];

    public const STATUS_ENUM = [
        'registrada' => 1,
        'deferido'   => 2,
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

    public function especie()
    {
        return $this->belongsTo(EspecieMuda::class);
    }
}
