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

    public function empresa()
    {
        return $this->hasOne(Empresa::class, 'user_id');
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

    public function visitasAnalista()
    {
        $visitas = collect();
        $requerimentos = $this->requerimentos;
        
        foreach ($requerimentos as $requerimento) {
            $visitas_requerimento = $requerimento->visitas;
            if ($visitas_requerimento->count() > 0) {
                foreach ($visitas_requerimento as $visita) {
                    $visitas->push($visita);
                }
            }
        }
        
        return $visitas;
    }
}
