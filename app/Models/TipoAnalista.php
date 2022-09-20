<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAnalista extends Model
{
    use HasFactory;

    public const TIPO_ENUM = [
        'protocolista' => 1,
        'processo' => 2,
        'poda' => 3,
        'orcamento' => 4,
        'definir_mudas' => 5,
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'tipo_analista_user', 'tipo_analista_id', 'user_id');
    }

    public function getTipo()
    {
        switch ($this->tipo) {
            case $this::TIPO_ENUM['protocolista']:
                return 'Protocolista';
                break;
            case $this::TIPO_ENUM['processo']:
                return 'Analista de processos';
                break;
            case $this::TIPO_ENUM['poda']:
                return 'Analista de podas e mudas';
                break;
            case $this::TIPO_ENUM['orcamento']:
                return 'Analista de orçamentos';
                break;
            case $this::TIPO_ENUM['definir_mudas']:
                return 'Analista para definição de mudas';
                break;
        }
    }
}
