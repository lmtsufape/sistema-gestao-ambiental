<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    public $fillable = [
        'nome',
        'cnpj',
        'porte',
        'potencial_poluidor',
    ];

    public function endereco()
    {
        return $this->belongsTo(Endereco::class, 'endereco_id');
    }

    public function telefone()
    {
        return $this->belongsTo(Telefone::class, 'telefone_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function requerimentos()
    {
        return $this->hasMany(Requerimento::class, 'empresa_id');
    }

    public function cnaes()
    {
        return $this->belongsToMany(Cnae::class);
    }

    public function notificacoes()
    {
        return $this->hasMany(Notificacao::class, 'empresa_id');
    }

    public function represetanteLegal()
    {
        return $this->belongsTo(RepresetanteLegal::class, 'represetante_legal_id');
    }

    public function setAtributes($input)
    {
        $this->nome = $input['nome_da_empresa'];
        $this->cnpj = $input['cnpj'];
        $this->porte = array_key_exists('porte', $input) ? $input['porte'] : null;
    }
}
