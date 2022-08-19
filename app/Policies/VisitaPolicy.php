<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Visita;
use Illuminate\Auth\Access\HandlesAuthorization;

class VisitaPolicy
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
     * @param  \App\Models\Visita  $visita
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Visita $visita)
    {
        return $user->can('isSecretarioOrAnalista', $user);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Visita  $visita
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Visita $visita)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Visita  $visita
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Visita $visita)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Visita  $visita
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Visita $visita)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Visita  $visita
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Visita $visita)
    {
        //
    }

    /**
     * Determina se um visita foi feita pelo analista logado.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Visita  $visita
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function analistaDaVisita(User $user, Visita $visita)
    {
        return $user->id == $visita->analista_id;
    }

    /**
     * Determina se um visita foi feita pelo analista logado.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Visita  $visita
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function analistaDaVisitaOrSecretario(User $user, Visita $visita)
    {
        $userPolicy = new UserPolicy();

        return $user->id == $visita->analista_id || $userPolicy->isSecretario($user);
    }
}
