<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cnae extends Model
{
    use HasFactory;

    public const POTENCIAL_POLUIDOR_ENUM = [
        'baixo' => 1,
        'medio' => 2,
        'alto' => 3,
        'a_definir' => 4,
    ];

    protected $fillable = [
        'nome',
        'codigo',
        'potencial_poluidor',
    ];

    public function setor()
    {
        return $this->belongsTo(Setor::class, 'setor_id');
    }

    public function empresas()
    {
        return $this->belongsToMany(Empresa::class, 'cnae_empresa', 'cnae_id', 'empresa_id');
    }

    public function setAtributes($input)
    {
        $this->nome = $input['nome'];
        $this->codigo = $input['codigo'];
    }

    public function existemEmpresas()
    {
        return $this->empresas()->exists();
    }

    /**
     * Retorna o maior potencial poluidor entre um conjunto de cnaes.
     *
     * @param collect $canes
     * @return int
     */
    public static function maiorPontencial($cnaes)
    {
        if ($cnaes != null && ! $cnaes->isEmpty()) {
            return $cnaes->max('potencial_poluidor');
        }

        return 0;
    }
}
