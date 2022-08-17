<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoLaudoTecnico extends Model
{
    use HasFactory;

    protected $table = 'fotos_laudos_tecnicos';

    protected $fillable = [
        'camimho',
    ];

    public function laudoTecnico()
    {
        return $this->belongsTo(LaudoTecnico::class, 'laudo_tecnico_id');
    }
}
