<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoAracao extends Model
{
    use HasFactory;

    protected $fillable = [
        'aracao_id',
        'caminho',
        'comentario'
    ];

    public function aracao(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Aracao::class, 'aracao_id');
    }
}
