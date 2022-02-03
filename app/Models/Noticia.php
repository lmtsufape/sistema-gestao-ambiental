<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Http\Requests\NoticiaRequest;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use DateInterval;

class Noticia extends Model
{
    use HasFactory;

    public $fillable = [
        'imagem_principal',
        'titulo',
        'texto',
        'link',
        'publicada',
    ];

    public function autor() 
    {
        return $this->belongsTo(User::class, 'autor_id');
    }

    /**
     * Seta os atributos do objeto
     *
     * @param App\Http\Requests\NoticiaRequest
     * @return void
     */
    public function setAtributes(NoticiaRequest $request)
    {
        $this->titulo = $request->input('título');
        $this->texto = $request->texto;
        $this->publicada = $request->publicar == "on";
        $this->destaque = $request->destaque == "on";
        $this->link = $this->gerarLinkDivulgacao($request->input('título'));
        $this->autor_id = auth()->user()->id;
    }

    /**
     * Salva a imagem principal da noticia em seu respectivo diretório
     *
     * @param $file
     * @return void
     */
    public function salvarImagem($file) 
    {
        if ($this->imagem_principal != null) {
            if (Storage::disk()->exists('public/'. $this->imagem_principal)) {
                Storage::delete('public/'. $this->imagem_principal);
            }
        }
        
        $caminho_noticias = "noticias/" . $this->id . "/";
        $documento_nome = $file->getClientOriginalName();
        Storage::putFileAs('public/' . $caminho_noticias, $file, $documento_nome);
        $this->imagem_principal = $caminho_noticias . $file->getClientOriginalName();
    }

    /**
     * Retorna a ultima atualização da notícia
     *
     * @return string $ultimaAtualizacao
     */
    public function ultimaAtualizacao() 
    {
        $ultima = now()->diff(new Carbon($this->updated_at));
        if ($ultima->d >= 1 && $ultima->d) {
            return 'Atualizado em ' . (new Carbon($this->updated_at))->format('d/m/Y às H:m');
        } else if ($ultima->h >= 1 && $ultima->h < 2) {
            return 'Última atualização à ' . $ultima->h . ' hora atrás.';
        } else if ($ultima->h >= 2) {
            return 'Última atualização à ' . $ultima->h . ' horas atrás.';
        } else if ($ultima->m <= 1) {
            return 'Publicado agora.';
        } else if ($ultima->m > 1) {
            return 'Última atualização à ' . $ultima->m . ' minutos atrás.';
        }
    }

    /**
     * Gera o link de divulgação da notícia
     *
     * @param string $string
     * @return string $string
     */
    private function gerarLinkDivulgacao($string) 
    {
        $complemento = "";
        for ($i = 0; $i < strlen($string); $i++) {
            if ($string[$i] == " ") {
                $complemento .= "-";
            } else {
                $complemento .= $string[$i];
            }
        }
        return route('welcome') . '/noticias/' . $complemento;
    }
}
