<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Denuncia extends Model implements AuditableContract
{
    use HasFactory;
    use Auditable;

    protected $auditInclude = [
        'empresa_id',
        'empresa_nao_cadastrada',
        'endereco',
        'texto',
        'aprovacao',
        'arquivo',
    ];

    protected $auditExclude = [
        'denunciante',
    ];

    public const APROVACAO_ENUM = [
        'registrada' => 1,
        'aprovada' => 2,
        'arquivada' => 3,
    ];

    protected $fillable = [
        'empresa_id',
        'empresa_nao_cadastrada',
        'endereco',
        'texto',
        'denunciante',
        'aprovacao',
        'arquivo',
    ];

    public function visita()
    {
        return $this->hasOne(Visita::class, 'denuncia_id');
    }

    public function fotos()
    {
        return $this->hasMany(FotoDenuncia::class, 'denuncia_id');
    }

    public function videos()
    {
        return $this->hasMany(VideoDenuncia::class, 'denuncia_id');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function analista()
    {
        return $this->belongsTo(User::class, 'analista_id');
    }

    public const STATUS_ENUM = [
        'registrada' => 1,
        'deferida' => 2,
        'indeferida' => 3,
    ];

    public function getStatusStringAttribute()
    {
        return ucwords(str_replace('_', ' ', array_search($this->aprovacao, $this::STATUS_ENUM)));
    }
}
