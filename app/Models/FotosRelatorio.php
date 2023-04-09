<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Relatorio;
use Illuminate\Support\Facades\Storage;

class FotosRelatorio extends Model
{
    use HasFactory;

    protected $table = 'fotos_relatorios';

    protected $fillable = [
        'relatorio_id',
        'caminho',
    ];
    
    public function relatorio()
    {
        return $this->belongsTo(Relatorio::class, 'relatorio_id');
    }

    public function salvarImagem($request, $id, $fotos_relatorio)
    {
        $count = count($request);
        for ($i = 0; $i < $count; $i++) {
            delete_file($this->imagem, 'storage/storage/relatorios/' . $id . '/imagens/');
            $fotos_relatorio = new FotosRelatorio();
            $fotos_relatorio->relatorio_id = $id;
            $caminho = 'relatorios/'. $id . '/imagens/';
            $imagem_nome = $request[$i]->getClientOriginalName();
            Storage::putFileAs('storage/' . $caminho, $request[$i], $imagem_nome);
            $fotos_relatorio->caminho = $caminho . $imagem_nome;
            $fotos_relatorio->update();
            }
    }

    public function deletar($id)
    {
        delete_file($this->imagem, 'storage/storage/relatorios/' . $id . '/imagens/');

        return $this->delete();
    }

}