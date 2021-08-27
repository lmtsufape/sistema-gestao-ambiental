<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Licenca extends Model
{
    use HasFactory;

    public const STATUS_ENUM = [
        'aprovada'   => 1,
        'negada'     => 2,
    ];

    public const TIPO_ENUM = [
        'previa'                => 1,
        'instalacao'            => 2,
        'operacao'              => 3,
        'simplificada'          => 4,
        'autorizacao_ambiental' => 5,
        'regularizacao'         => 6,
    ];

    protected $fillable = [
        'protocolo',
        'status',
        'tipo',
        'validade',
    ];

    public function requerimento()
    {
        return $this->belongsTo(Requerimento::class, 'requerimento_id');
    }
}
