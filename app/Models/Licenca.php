<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\LicencaRequest;
use Illuminate\Support\Facades\Storage;

class Licenca extends Model
{
    use HasFactory;

    public const STATUS_ENUM = [
        'gerada'    => 1,
        'aprovada'   => 2,
        'revisar'     => 3,
    ];

    public const TIPO_ENUM = [
        'previa'                => 1,
        'instalacao'            => 2,
        'operacao'              => 3,
        'simplificada'          => 4,
        'autorizacao_ambiental' => 5,
        'regularizacao'         => 6,
    ];

    protected $fillable = [
        'protocolo',
        'status',
        'tipo',
        'validade',
        'caminho'
    ];

    public function requerimento()
    {
        return $this->belongsTo(Requerimento::class, 'requerimento_id');
    }

    public function setAtributes(LicencaRequest $request, Requerimento $requerimento)
    {
        $this->status = Licenca::STATUS_ENUM['gerada'];
        $this->tipo = $request->input('tipo_de_licença');
        $this->validade = $request->data_de_validade;
        $this->requerimento_id = $requerimento->id;
        $this->protocolo = $this->gerarProtocolo();
        $this->save();
        $this->caminho = $this->salvarLicenca($request->file('licença'), $requerimento);
        $this->update();
    }

    public function salvarLicenca($file, Requerimento $requerimento)
    {
        if ($this->caminho != null) {
            if (Storage::exists($this->caminho)) {
                Storage::delete($this->caminho);
            }
        }
        return $file->store("requerimentos/{$requerimento->id}/licenca/{$this->id}");
    }

    public function gerarProtocolo()
    {
        $max = 9999999999;
        $min = 1000000000;

        $protocolo = null;
        do {
            $protocolo = rand($min, $max);
            $checagem = Licenca::where('protocolo',$protocolo)->first();
        } while ($checagem != null);

        return $protocolo;
    }

}
