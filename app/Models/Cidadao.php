<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cidadao extends Model
{
    use HasFactory;
    
    public $fillable = [
        'cpf',
        'rg',
        'orgao_emissor',
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

    public function setAtributes($input)
    {
        $this->cpf              = $input['cpf'];
        $this->rg               = $input['rg'];
        $this->orgao_emissor    = $input['orgão_emissor'];
    }
}
