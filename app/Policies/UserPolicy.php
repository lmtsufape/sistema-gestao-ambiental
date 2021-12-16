<?php

namespace App\Policies;

use App\Models\TipoAnalista;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Checa se o usuário logado é um secretario.
     *
     * @return boolean
     */
    public function isSecretario(User $user)
    {
        return $user->role == User::ROLE_ENUM['secretario'];
    }

    /**
     * Checa se o usuário logado é um secretario.
     *
     * @return boolean
     */
    public function isAnalista(User $user)
    {
        return $user->role == User::ROLE_ENUM['analista'];
    }

    public function isProtocolista(User $user)
    {
        if($this->isAnalista($user)){
            $protocolista = TipoAnalista::where('tipo', TipoAnalista::TIPO_ENUM['protocolista'])->first();
            if($user->tipo_analista()->where('tipo_analista_id', $protocolista->id)->first() != null){
                return True;
            }else{
                return False;
            }
        }
    }

    /**
     * Checa se o usuário logado é um secretario.
     *
     * @return boolean
     */
    public function isRequerente(User $user)
    {
        return $user->role == User::ROLE_ENUM['requerente'];
    }

    /**
     * Checa se o usuário logado é um secretario ou requerente.
     *
     * @return boolean
     */
    public function isRequerenteOrSecretario(User $user)
    {
        return $this->isSecretario($user) || $this->isRequerente($user);
    }

    /**
     * Checa se o usuário logado é um secretario ou analista.
     *
     * @return boolean
     */
    public function isSecretarioOrAnalista(User $user)
    {
        return $this->isSecretario($user) || $this->isAnalista($user);
    }

    public function isSecretarioOrProtocolista(User $user)
    {
        return $this->isSecretario($user) || $this->isProtocolista($user);
    }

    public function usuarioInterno(User $user)
    {
        return $user->role != User::ROLE_ENUM['requerente'] && $user->role != User::ROLE_ENUM['represetante_legal'];
    }
}
