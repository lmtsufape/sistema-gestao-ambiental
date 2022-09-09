<?php

namespace App\Models;

use App\Policies\UserPolicy;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

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
        $requerimento = Requerimento::where('status', '=', Requerimento::STATUS_ENUM['documentos_requeridos'])
            ->where('cancelada', false)
            ->whereRelation('empresa', 'user_id', auth()->user()->id)
            ->orderBy('created_at', 'DESC')
            ->first();

        return $requerimento;
    }

    public function setAtributes($input)
    {
        $this->name = $input['name'];
        $this->email = $input['email'];
        if ($input['password'] != null) {
            $this->password = Hash::make($input['password']);
        }
    }

    public function visitas()
    {
        return $this->hasMany(Visita::class, 'analista_id');
    }

    public function tipoAnalista()
    {
        return $this->belongsToMany(TipoAnalista::class, 'tipo_analista_user', 'user_id', 'tipo_analista_id');
    }

    public function noticias()
    {
        return $this->hasMany(Noticia::class, 'autor_id');
    }

    public function requerimentosRequerente()
    {
        return $this->hasManyThrough(Requerimento::class, Empresa::class);
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
            if ($analista->tipoAnalista()->where('tipo', TipoAnalista::TIPO_ENUM['processo'])->get()->count() > 0) {
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
            if ($analista->tipoAnalista()->where('tipo', TipoAnalista::TIPO_ENUM['protocolista'])->get()->count() > 0) {
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
            if ($analista->tipoAnalista()->where('tipo', TipoAnalista::TIPO_ENUM['poda'])->get()->count() > 0) {
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
            return $this->tipoAnalista()->where('tipo', TipoAnalista::TIPO_ENUM['processo'])->get()->count() > 0;
        }

        return false;
    }

    /**
     * salva a foto do perfil do usuário.
     *
     * @param Request $request
     * @return bool
     */
    public function salvarFoto(Request $request)
    {
        $file = $request->foto_de_perfil;

        if ($file != null) {
            delete_file($this->profile_photo_path, 'public');
            $caminho = 'users/' . $this->id . '/';
            $nome = $file->getClientOriginalName();
            Storage::putFileAs('public/' . $caminho, $file, $nome);
            $this->profile_photo_path = $caminho . $file->getClientOriginalName();
        }

        return $this->update();
    }

    /**
     * Retorna  notificacoes nao vistas.
     *
     * @return App\Models\Notificacao $notificacoes
     */
    public function notificacoesEmpresas()
    {
        $notificacoes = Notificacao::whereHas('empresa', function (Builder $query) {
            $query->where('user_id', auth()->user()->id);
        })->orderBy('created_at', 'DESC')->take(4)->get();

        return $notificacoes;
    }

    /**
     * Retorna se ha notificacoes nao vistas.
     *
     * @return bool
     */
    public function notificacoesNaoVistas()
    {
        $notificacoes = Notificacao::whereHas('empresa', function (Builder $query) {
            $query->where('user_id', auth()->user()->id);
        })->where('visto', false)->first();

        return $notificacoes != null;
    }

    /**
     * Get if user analista type poda or requerimento.
     *
     * @return string $filtro
     */
    public function getUserType()
    {
        $userPolicy = new UserPolicy();
        if ($userPolicy->isAnalistaPoda($this)) {
            $filtro = 'poda';
        } else {
            $filtro = 'requerimento';
        }

        return $filtro;
    }
}
