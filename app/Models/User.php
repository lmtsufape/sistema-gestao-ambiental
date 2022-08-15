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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

    public function requerimentosDocumentosAnexadosNotificacao()
    {
        $requerimentos_id = DB::table('requerimentos')->join('empresas', 'requerimentos.empresa_id', '=', 'empresas.id')
                ->where('empresas.user_id', '=', auth()->user()->id)
                ->where('requerimentos.cancelada', '=', false)
                ->where('requerimentos.status', '=', Requerimento::STATUS_ENUM['documentos_requeridos'])
                ->get('requerimentos.id');
                
        $requerimento = Requerimento::whereIn('id', $requerimentos_id->pluck('id'))->orderBy('created_at', 'DESC')->first();

        if($requerimento != null && $requerimento->documentos()->where('status', Checklist::STATUS_ENUM['enviado'])->first() == null){
            $requerimento = null;
        }
        return $requerimento;
    }

    public function setAtributes($input)
    {
        $this->name = $input['name'];
        $this->email = $input['email'];
        if($input['password'] != null){
            $this->password = Hash::make($input['password']);
        }
    }

    public function visitas()
    {
        return $this->hasMany(Visita::class, 'analista_id');
    }

    public function tipo_analista()
    {
        return $this->belongsToMany(TipoAnalista::class, 'tipo_analista_user', 'user_id', 'tipo_analista_id');
    }

    public function noticias() 
    {
        return $this->hasMany(Noticia::class, 'autor_id');
    }

    public function requerimentosRequerente()
    {
        $requerimentos_id = DB::table('requerimentos')->join('empresas', 'requerimentos.empresa_id', '=', 'empresas.id')
                ->where('empresas.user_id', '=', auth()->user()->id)
                ->get('requerimentos.id');
                
        $requerimentos = Requerimento::whereIn('id', $requerimentos_id->pluck('id'))->orderBy('created_at', 'DESC')->paginate(8);
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

    /**
     * Retorna os analistas de poda cadastrados.
     *
     * @return App\Models\User $analistasPoda
     */
    public static function analistasPoda()
    {
        $analistasPoda = collect();
        $analistas = User::where('role', User::ROLE_ENUM['analista'])->get();

        foreach ($analistas as $analista) {
            if ($analista->tipo_analista()->where('tipo', TipoAnalista::TIPO_ENUM['poda'])->get()->count() > 0) {
                $analistasPoda->push($analista);
            }
        }

        return $analistasPoda;
    }

    public function denuncias()
    {
        return $this->hasMany(Denuncia::class, 'analista_id');
    }

    public function ehAnalista()
    {
        if ($this->role == User::ROLE_ENUM['analista']) {
            return $this->tipo_analista()->where('tipo', TipoAnalista::TIPO_ENUM['processo'])->get()->count()  > 0;
        }

        return false;
    }

    /**
     * salva a foto do perfil do usuário.
     *
     * @param Request $request
     * @return boolean
     */
    public function salvarFoto(Request $request)
    {
        $file = $request->foto_de_perfil;

        if ($file != null) {
            if ($this->profile_photo_path != null) {
                if (Storage::disk()->exists('public/'. $this->profile_photo_path)) {
                    Storage::delete('public/'. $this->profile_photo_path);
                }
            }

            $caminho = 'users/' . $this->id . '/';
            $nome = $file->getClientOriginalName();
            Storage::putFileAs('public/' . $caminho, $file, $nome);
            $this->profile_photo_path = $caminho . $file->getClientOriginalName();
        }

        return $this->update();
    }
}
