<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aracao extends Model
{
    use HasFactory;

    protected $table = 'aracaos';

    protected $fillable = [
        'beneficiario_id',
        'cultura',
        'ponto_localizacao',
        'quantidade_ha',
        'quantidade_horas',
    ];

    public function beneficiario()
    {
        return $this->belongsTo(Beneficiario::class);
    }

    public function setAtributes($request)
    {
        $this->beneficiario_id = $request['beneficiario_id'];
        $this->cultura = $request['cultura'];
        $this->ponto_localizacao = $request['ponto_localizacao'];
        $this->quantidade_ha = $request['quantidade_ha'];
        $this->quantidade_horas = $request['quantidade_horas'];
    }
    
}
