<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoPoda extends Model
{
    use HasFactory;

    protected $table = 'fotos_podas';

    protected $fillable = [
        'camimho',
    ];

    public function solicitacaoPoda()
    {
        return $this->belongsTo(SolicitacaoPoda::class, 'solicitacao_poda_id');
    }
}
