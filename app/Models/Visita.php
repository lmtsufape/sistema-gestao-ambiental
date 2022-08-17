<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_marcada',
        'data_realizada',
    ];

    public function setAtributesRequerimento($input)
    {
        $this->data_marcada = $input['data_marcada'];
        $this->requerimento_id = $input['requerimento'];
        $this->analista_id = $input['analista'];
    }

    public function denuncia()
    {
        return $this->belongsTo(Denuncia::class, 'denuncia_id');
    }

    public function requerimento()
    {
        return $this->belongsTo(Requerimento::class, 'requerimento_id');
    }

    public function solicitacao_poda()
    {
        return $this->belongsTo(SolicitacaoPoda::class, 'solicitacao_poda_id');
    }

    public function fotos()
    {
        return $this->hasMany(FotoVisita::class, 'visita_id');
    }

    public function relatorio()
    {
        return $this->hasOne(Relatorio::class, 'visita_id');
    }

    public function analista()
    {
        return $this->belongsTo(User::class, 'analista_id');
    }

    public function relatorioAceito()
    {
        if ($this->relatorio != null) {
            return $this->relatorio->aprovacao == Relatorio::APROVACAO_ENUM['aprovado'];
        }

        return false;
    }

    /**
     * Retorna se a visita foi realizada ou está pendente.
     *
     * @return string $string
     */
    public function status()
    {
        if ($this->data_realizada != null) {
            return 'Realizada';
        }

        return 'Pendente';
    }
}
