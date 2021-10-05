<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModificacaoPorte extends Model
{
    use HasFactory;

    public $fillable = [
        'porte_antigo',
        'porte_atual',
    ];

    public function historico()
    {
        return $this->belongsTo(Historico::class, 'historico_id');
    }
}
