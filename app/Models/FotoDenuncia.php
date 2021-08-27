<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoDenuncia extends Model
{
    use HasFactory;

    protected $fillable = [
        'caminho',
        'comentario',
    ];

    public function denuncia()
    {
        return $this->belongsTo(Denuncia::class, 'denuncia_id');
    }
}
