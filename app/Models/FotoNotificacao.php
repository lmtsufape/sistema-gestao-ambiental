<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoNotificacao extends Model
{
    use HasFactory;

    protected $fillable = [
        'caminho',
        'comentario',
    ];

    public function notificacao()
    {
        return $this->belongsTo(Notificacao::class, 'notificacao_id');
    }
}
