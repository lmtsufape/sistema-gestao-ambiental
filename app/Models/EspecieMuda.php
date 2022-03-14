<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EspecieMuda extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
    ];

    public function setAtributes($input)
    {
        $this->nome = $input['nome'];
    }

    public function solicitacoes()
    {
        return $this->hasMany(SolicitacaoMuda::class, 'especie_id');
    }

}
