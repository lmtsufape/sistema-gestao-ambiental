<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Visita;

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
    

}