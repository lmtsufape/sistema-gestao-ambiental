<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Empresa extends Model implements AuditableContract
{
    use HasFactory;
    use Auditable;

    protected $auditInclude = [
        'nome',
        'cpf_cnpj',
        'eh_cnpj',
        'porte',
        'endereco_id',
        'telefone_id',
        'user_id',
        'represetante_legal_id',
    ];

    public const PORTE_ENUM = [
        'micro' => 1,
        'pequeno' => 2,
        'medio' => 3,
        'grande' => 4,
        'especial' => 5,
    ];

    public $fillable = [
        'nome',
        'cpf_cnpj',
        'eh_cnpj',
        'porte',
    ];

    public function documentosRequeridos()
    {
        return $this->belongsToMany(RequerimentoDocumento::class, 'empresa_id');
    }

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
        return $this->belongsToMany(Cnae::class, 'cnae_empresa', 'empresa_id', 'cnae_id');
    }

    public function notificacoes()
    {
        return $this->hasMany(Notificacao::class, 'empresa_id');
    }

    public function represetanteLegal()
    {
        return $this->belongsTo(RepresetanteLegal::class, 'represetante_legal_id');
    }

    public function denuncias()
    {
        return $this->hasMany(Denuncia::class, 'empresa_id');
    }

    public function setAtributes($input)
    {
        $this->nome = $input['nome_da_empresa'];
        $this->cpf_cnpj = $input['cnpj'] != null ? $input['cnpj'] : $input['cpf'];
        $this->eh_cnpj = $input['cnpj'] != null;
        $this->porte = array_key_exists('porte', $input) ? $input['porte'] : null;
    }

    /**
     * Retorna o maior pontecial poluidor da empresa.
     *
     * @return string $string
     */
    public function potencialPoluidor()
    {
        $canes = $this->cnaes;
        $maior = Cnae::maiorPontencial($canes);

        switch ($maior) {
            case Cnae::POTENCIAL_POLUIDOR_ENUM['baixo']:
                return 'Baixo';
                break;
            case Cnae::POTENCIAL_POLUIDOR_ENUM['medio']:
                return 'Médio';
                break;
            case Cnae::POTENCIAL_POLUIDOR_ENUM['alto']:
                return 'Alto';
                break;
            case Cnae::POTENCIAL_POLUIDOR_ENUM['a_definir']:
                return 'A definir';
                break;
        }
    }

    /**
     * Retorna o maior pontecial poluidor da empresa.
     *
     * @return string $string
     */
    public function porte()
    {
        switch ($this->porte) {
            case Empresa::PORTE_ENUM['micro']:
                return 'Micro';
                break;
            case Empresa::PORTE_ENUM['pequeno']:
                return 'Pequeno';
                break;
            case Empresa::PORTE_ENUM['medio']:
                return 'Médio';
                break;
            case Empresa::PORTE_ENUM['grande']:
                return 'Grande';
                break;
            case Empresa::PORTE_ENUM['especial']:
                return 'Especial';
                break;
        }
    }
}
