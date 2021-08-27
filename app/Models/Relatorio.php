<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relatorio extends Model
{
    use HasFactory;

    protected $fillable = [
        'texto',
        'aprovacao',
    ];

    public function visita()
    {
        return $this->belongsTo(Visita::class, 'visita_id');
    }
}
