<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoletoCobranca extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_vencimento',
        'caminho_boleto',
        'resposta_remessa',
    ];

    public function requerimento()
    {
        return $this->belongsTo(Requerimento::class, 'requerimento_id');
    }
}
