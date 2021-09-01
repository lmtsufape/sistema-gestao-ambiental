<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cnae extends Model
{
    use HasFactory;

    public const POTENCIAL_POLUIDOR_ENUM = [
        'baixo'     => 1,
        'medio'     => 2,
        'alto'      => 3,
    ];

    protected $fillable = [
        'nome',
        'codigo',
        'potencial_poluidor',
        'setor_id',
    ];

    public function setor()
    {
        return $this->belongsTo(Setor::class, 'setor_id');
    }

    public function empresas()
    {
        return $this->belongsToMany(Empresa::class);
    }

    public function setAtributes($input)
    {
        $this->nome = $input['nome'];
        $this->codigo = $input['codigo'];
    }
}
