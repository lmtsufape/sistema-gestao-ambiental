<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotosAbastecimento extends Model
{
    use HasFactory;

    protected $fillable = [
        'solicitacao_servico_id',
        'assinatura_solicitante',
        'abastecimento'
    ];

    public function solicitacao_servico(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(SolicitacaoServico::class, 'solicitacao_servico_id');
    }
}
