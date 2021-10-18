<?php

namespace App\Policies;

use App\Models\SolicitacaoMuda;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SolicitacaoMudaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function index(User $user)
    {
        return $user->role == User::ROLE_ENUM['secretario'] || $user->role == User::ROLE_ENUM['analista'];
    }

    public function viewAny(User $user)
    {
        return $this->index($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SolicitacaoMuda  $solicitacaoMuda
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, SolicitacaoMuda $solicitacaoMuda)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SolicitacaoMuda  $solicitacaoMuda
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, SolicitacaoMuda $solicitacaoMuda)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SolicitacaoMuda  $solicitacaoMuda
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, SolicitacaoMuda $solicitacaoMuda)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SolicitacaoMuda  $solicitacaoMuda
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, SolicitacaoMuda $solicitacaoMuda)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SolicitacaoMuda  $solicitacaoMuda
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, SolicitacaoMuda $solicitacaoMuda)
    {
        return false;
    }
}
