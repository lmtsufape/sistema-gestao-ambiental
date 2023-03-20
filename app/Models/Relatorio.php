<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Relatorio extends Model
{
    use HasFactory;

    public const APROVACAO_ENUM = [
        'realizado' => 1,
        'aprovado' => 2,
        'reprovado' => 3,
    ];

    protected $fillable = [
        'texto',
        'aprovacao',
        'motivo_edicao',
        'arquivoFile',
    ];

    public function visita()
    {
        return $this->belongsTo(Visita::class, 'visita_id');
    }

    public function setAtributes(Request $request)
    {
        $this->visita_id = $request->visita;
        $this->texto = $request->texto;
        $this->aprovacao = $this::APROVACAO_ENUM['realizado'];
        $request->hasFile('arquivoFile') ? $this->arquivo = $request->arquivoFile->store("relatorios/{$this->id}/arquivo") : null;
    }
}
