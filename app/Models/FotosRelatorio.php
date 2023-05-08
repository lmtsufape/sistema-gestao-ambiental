<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Relatorio;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

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
        $zip = new ZipArchive;
        $filename = "storage/app/relatorios/$id/imagens/imagens.zip";
        if (!file_exists("storage/app/relatorios/$id/imagens")) {
            mkdir("storage/app/relatorios/$id/imagens", 0777, true);
        }
        $zip->open($filename, ZipArchive::CREATE | ZipArchive::OVERWRITE);
            for ($i = 0; $i < $count; $i++) {
                $zip->addFile($request[$i]->getRealPath(), $request[$i]->getClientOriginalName());
            }
        $zip->close();
        $fotos_relatorio->relatorio_id = $id;
        $fotos_relatorio->caminho = $filename;
        $fotos_relatorio->save();
    }

}