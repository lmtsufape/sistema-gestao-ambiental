<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModificacaoCnae extends Model
{
    use HasFactory;

    public $fillable = [
        'novo',
    ];

    public function historico()
    {
        return $this->belongsTo(Historico::class, 'historico_id');
    }
}
