<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RequerimentoDocumento extends Pivot
{
    use HasFactory;
    
    protected $table = 'requerimentos_documentos';
   
    protected $fillable = [
        'requerimento_id',
        'documento_id',
        'empresa_id',
        'arquivo_outro_documento',
        'nome_outro_documento',
        'prazo_exigencia',
        'anexo_arquivo',
        'status',
    ];

    public const STATUS_ENUM = [
        'nao_enviado' => 1,
        'enviado' => 2,
        'aceito' => 3,
        'analisado' => 4,
        'recusado' => 5,
    ];

    public function requerimento()
    {
        return $this->belongsTo(Requerimento::class, 'requerimento_id');
    }

    public function documentos()
    {
        return $this->hasMany(Documento::class, 'documento_id')->withPivot('status');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }




}