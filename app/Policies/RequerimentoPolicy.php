<?php

namespace App\Policies;

use App\Models\Empresa;
use App\Models\Requerimento;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RequerimentoPolicy
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
     * @param  \App\Models\Requerimento  $requerimento
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Requerimento $requerimento)
    {
        $userPolicy = new UserPolicy();

        return $userPolicy->isSecretario($user) || $userPolicy->isAnalista($user) || $this->analises($user, $requerimento);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, Empresa $empresa)
    {
        $userPolicy = new UserPolicy();

        return ($user->empresas->contains('id', $empresa->id)
            || $userPolicy->isSecretario($user) ||
            $userPolicy->isProtocolista($user));

    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Requerimento  $requerimento
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Requerimento $requerimento)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Requerimento  $requerimento
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Requerimento $requerimento)
    {
        $userPolicy = new UserPolicy();

        return $user->empresas->contains('id', $requerimento->empresa->id) || $userPolicy->isSecretario($user);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Requerimento  $requerimento
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Requerimento $requerimento)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Requerimento  $requerimento
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Requerimento $requerimento)
    {
        //
    }

    /**
     * Retorna se um requerimento está sendo analisado pelo analista.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Requerimento  $requerimento
     * @return bool
     */
    private function analises(User $user, Requerimento $requerimento)
    {
        $userPolicy = new UserPolicy();
        if ($userPolicy->isAnalista($user)) {
            return $user->requerimentos->contains($requerimento);
        }

        return false;
    }

    public function requerimentoDocumentacao(User $user, Requerimento $requerimento)
    {
        $userPolicy = new UserPolicy();
        if (! $requerimento->cancelado()) {
            if ($userPolicy->isRequerente($user)) {
                return $requerimento->empresa->user_id == $user->id;
            } elseif ($userPolicy->isSecretario($user)) {
                return true;
            }
        }

        return false;
    }

    public function verDocumentacao(User $user, Requerimento $requerimento)
    {
        $userPolicy = new UserPolicy();
        if ($userPolicy->isRequerente($user)) {
            return $requerimento->empresa->user_id == $user->id;
        }

        return $userPolicy->isSecretario($user) || $userPolicy->isAnalista($user) || $this->analises($user, $requerimento);
    }

    public function verProtocolo(User $user, Requerimento $requerimento)
    {
        return $this->verDocumentacao($user, $requerimento) && $requerimento->visitas()->exists();
    }
}
