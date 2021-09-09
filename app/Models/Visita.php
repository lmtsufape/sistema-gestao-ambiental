<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_marcada',
        'data_realizada',
    ];

    public function setAtributesRequerimento($input)
    {
        $this->data_marcada = $input['data_marcada'];
        $this->requerimento_id = $input['requerimento'];
    }

    public function denuncia()
    {
        return $this->belongsTo(Denuncia::class, 'denuncia_id');
    }

    public function requerimento()
    {
        return $this->belongsTo(Requerimento::class, 'requerimento_id');
    }

    public function fotos()
    {
        return $this->hasMany(FotoVisita::class,  'visita_id');
    }

    public function relatorio()
    {
        return $this->hasOne(Relatorio::class, 'visita_id');
    }
}
