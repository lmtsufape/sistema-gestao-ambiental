<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MudaSolicitada extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'solicitacao_id',
        'especie_id',
        'qtd_mudas',
    ];

    public function especie()
    {
        return $this->belongsTo(EspecieMuda::class);
    }

    public function solicitacao()
    {
        return $this->belongsTo(SolicitacaoMuda::class);
    }
}
