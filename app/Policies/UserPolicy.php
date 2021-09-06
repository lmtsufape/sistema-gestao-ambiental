<?php

namespace App\Policies;

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
}
