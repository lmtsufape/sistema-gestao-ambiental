<?php

namespace App\Models;

use App\Http\Requests\ValorRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValorRequerimento extends Model
{
    use HasFactory;

    public const TIPO_LICENCA_ENUM = Licenca::TIPO_ENUM;

    public const POTENCIAL_POLUIDOR_ENUM = Cnae::POTENCIAL_POLUIDOR_ENUM;

    public const PORTE_ENUM = Empresa::PORTE_ENUM;

    protected $fillable = [
        'porte',
        'potencial_poluidor',
        'tipo_de_licenca',
        'valor',
    ];

    public function setAtributes(ValorRequest $request)
    {
        $this->porte = $request->porte;
        $this->potencial_poluidor = $request->potencial_poluidor;
        $this->tipo_de_licenca = $request->input('tipo_de_licença');
        $this->valor = $request->valor;
    }
}
