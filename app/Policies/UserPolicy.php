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
    public function isSecretario($user) 
    {
        return $user->role == User::ROLE_ENUM['secretario'];
    }

    /**
     * Checa se o usuário logado é um secretario.
     *
     * @return boolean
     */
    public function isAnalista($user) 
    {
        return $user->role == User::ROLE_ENUM['analista'];
    }

    /**
     * Checa se o usuário logado é um secretario.
     *
     * @return boolean
     */
    public function isRequerente($user) 
    {
        return $user->role == User::ROLE_ENUM['requerente'];
    }
}
