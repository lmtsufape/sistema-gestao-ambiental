<?php

namespace App\Models;

use App\Http\Requests\DocumentoRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Documento extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'documento_modelo',
        'padrao_previa',
        'padrao_instalacao',
        'padrao_operacao',
        'padrao_simplificada',
        'padrao_autorizacao_ambiental',
        'padrao_regularizacao',
    ];

    public function requerimentos()
    {
        return $this->belongsToMany(Requerimento::class, 'checklists', 'documento_id', 'requerimento_id')->withPivot('caminho', 'comentario', 'status');
    }

    public function setAtributes(DocumentoRequest $request)
    {
        $this->nome = $request->nome;
        $this->padrao_previa = $request->input('prêvia') != null;
        $this->padrao_instalacao = $request->input('instalação') != null;
        $this->padrao_operacao = $request->input('operação') != null;
        $this->padrao_simplificada = $request->simplificada != null;
        $this->padrao_autorizacao_ambiental = $request->input('autorização_ambiental') != null;
        $this->padrao_regularizacao = $request->input('regularização') != null;
    }

    public function existemRequerimentos()
    {
        return $this->requerimentos()->exists();
    }

    public function salvarDocumento($file)
    {
        delete_file($this->documento_modelo, 'public');
        $caminho_licencas = 'documentos/licencas/';
        $documento_nome = $file->getClientOriginalName();
        Storage::putFileAs('public/' . $caminho_licencas, $file, $documento_nome);
        $this->documento_modelo = $caminho_licencas . $file->getClientOriginalName();
    }

    public function deletar()
    {
        delete_file($this->documento_modelo, 'public');

        return $this->delete();
    }
}
