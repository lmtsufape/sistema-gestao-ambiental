<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requerimento extends Model
{
    use HasFactory;

    public const STATUS_ENUM = [
        'requerida'     => 1,
        'em_andamento'  => 2,
        'documentos_requeridos' => 3,
        'documentos_enviados' => 4,
        'documentos_aceitos' => 5,
        'visita_marcada' => 6,
        'visita_realizada' => 7,
        'finalizada'    => 8,
        'cancelada'     => 9,
    ];

    public const TIPO_ENUM = [
        'primeira_licenca' => 1,
        'renovacao'        => 2,
        'autorizacao'      => 3,
    ];

    protected $fillable = [
        'status',
        'tipo',
        'valor',
    ];

    public function analista()
    {
        return $this->belongsTo(User::class, 'analista_id');
    }

    public function represetanteLegalEmpresa()
    {
        return $this->belongsTo(RepresetanteLegal::class, 'represetante_id');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function licenca()
    {
        return $this->hasOne(Licenca::class, 'requerimento_id');
    }

    public function documentos()
    {
        return $this->belongsToMany(Documento::class, 'checklists', 'requerimento_id', 'documento_id')->withPivot('caminho', 'comentario', 'status');
    }

    public function visita()
    {
        return $this->hasOne(Visita::class, 'requerimento_id');
    }
}
