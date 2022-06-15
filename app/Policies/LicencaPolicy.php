<?php

namespace App\Policies;

use App\Models\Licenca;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LicencaPolicy
{
    use HandlesAuthorization;

    public function baixarLicenca(User $user, Licenca $licenca)
    {
        return $licenca->requerimento->empresa->user->id == $user->id || ($licenca->requerimento->represetanteLegalEmpresa && $licenca->requerimento->represetanteLegalEmpresa->user->id == $user->id) || $user->can('isSecretario', $user) || $user->can('isAnalista', $user);
    }
}
