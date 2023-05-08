<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $this->aprovacao = Relatorio::APROVACAO_ENUM['realizado'];
    }

    public function salvarArquivo($file, $id, $relatorio)
    {   
        $path = 'relatorios/'. $id . '/arquivo/';
        Storage::deleteDirectory($path);
        $caminho = 'relatorios/'. $id . '/arquivo/';
        $documento_nome = $file->getClientOriginalName();
        Storage::putFileAs($caminho, $file, $documento_nome);
        $relatorio->arquivo  = $caminho . $documento_nome;
        $relatorio->update();
    }

}
