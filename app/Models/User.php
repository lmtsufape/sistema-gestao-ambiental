<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    public const ROLE_ENUM = [
        'requerente' => 1,
        'represetante_legal' => 2,
        'analista' => 3,
        'secretario' => 4,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function requerente()
    {
        return $this->hasOne(Requerente::class, 'user_id');
    }

    public function empresas()
    {
        return $this->hasMany(Empresa::class, 'user_id');
    }

    public function represetanteLegal()
    {
        return $this->hasOne(RepresetanteLegal::class, 'user_id');
    }

    public function requerimentos()
    {
        return $this->hasMany(Requerimento::class, 'analista_id');
    }

    public function setAtributes($input)
    {
        $this->name = $input['name'];
        $this->email = $input['email'];
        $this->password = Hash::make($input['password']);
    }

    public function visitas()
    {
        return $this->hasMany(Visita::class, 'analista_id');
    }

    public function tipo_analista()
    {
        return $this->belongsToMany(TipoAnalista::class, 'tipo_analista_user', 'user_id', 'tipo_analista_id');
    }

    public function requerimentosRequerente()
    {
        $empresas = $this->empresas;
        $requerimentos = collect();

        foreach ($empresas as $empresa) {
            $requerimentos = $requerimentos->concat($empresa->requerimentos()->where('status', '!=', Requerimento::STATUS_ENUM['cancelada'])->get());
        }
        
        return $requerimentos;
    }

    /**
     * Retorna todos os analistas do sistema.
     *
     * @return collect \App\Models\User $analistas
     */
    public static function analistas() 
    {
        $analistas = collect();
        $users = User::where('role', User::ROLE_ENUM['analista'])->get();
        
        foreach ($users as $analista) {
            if ($analista->tipo_analista()->where('tipo', TipoAnalista::TIPO_ENUM['processo'])->get()->count() > 0) {
                $analistas->push($analista);
            }
        }

        return $analistas;
    }

    /**
     * Retorna os protocolistas cadastrados.
     *
     * @return App\Models\User $protocolistas
     */
    public static function protocolistas()
    {
        $protocolistas = collect();
        $analistas = User::where('role', User::ROLE_ENUM['analista'])->get();

        foreach ($analistas as $analista) {
            if ($analista->tipo_analista()->where('tipo', TipoAnalista::TIPO_ENUM['protocolista'])->get()->count() > 0) {
                $protocolistas->push($analista);
            }
        }

        return $protocolistas;
    }
}
