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
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'tipo_analista_user', 'tipo_analista_id', 'user_id');
    }

    public function getTipo() 
    {
        switch ($this->tipo) {
            case $this::TIPO_ENUM['protocolista']:
                return "Protocolista";
                break;
            case $this::TIPO_ENUM['processo']:
                return "Analista de processos";
                break;
        }
    }
}
