<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denuncia extends Model
{
    use HasFactory;

    public const APROVACAO_ENUM = [
        'registrada' => 1,
        'aprovada'   => 2,
        'arquivada'  => 3,
    ];

    protected $fillable = [
        'empresa',
        'endereco',
        'texto',
        'aprovacao',
    ];

    public function visita()
    {
        return $this->hasOne(Visita::class, 'denuncia_id');
    }

    public function fotos()
    {
        return $this->hasMany(FotoDenuncia::class, 'denuncia_id');
    }

}
