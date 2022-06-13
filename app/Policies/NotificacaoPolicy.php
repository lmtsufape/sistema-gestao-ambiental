<?php

namespace App\Policies;

use App\Models\Notificacao;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotificacaoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Notificacao  $notificacao
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Notificacao $notificacao)
    {
        return $user->can('isSecretarioOrAnalista', $user) || ($notificacao->empresa && $notificacao->empresa->user && $notificacao->empresa->user->id == $user->id);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        $userPolicy = new UserPolicy();
        return $userPolicy->isSecretario($user) || $userPolicy->isAnalista($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Notificacao  $notificacao
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Notificacao $notificacao)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Notificacao  $notificacao
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Notificacao $notificacao)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Notificacao  $notificacao
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Notificacao $notificacao)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Notificacao  $notificacao
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Notificacao $notificacao)
    {
        //
    }
}
