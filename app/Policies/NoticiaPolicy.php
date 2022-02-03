<?php

namespace App\Policies;

use App\Models\Noticia;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Policies\UserPolicy;

class NoticiaPolicy
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
     * @param  \App\Models\Noticia  $noticia
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Noticia $noticia)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $this->opercacoesBasicas($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Noticia  $noticia
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Noticia $noticia)
    {
        return $this->opercacoesBasicas($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Noticia  $noticia
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Noticia $noticia)
    {
        return $this->opercacoesBasicas($user);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Noticia  $noticia
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Noticia $noticia)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Noticia  $noticia
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Noticia $noticia)
    {
        //
    }

    /**
     * Determina se o usuário é secretario ou analista.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    private function opercacoesBasicas(User $user) 
    {
        $userPolicy = new UserPolicy();
        return $userPolicy->isSecretarioOrAnalista($user);
    }
}
