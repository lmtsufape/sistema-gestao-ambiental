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
     * Checa se o usuário logado é um analista.
     *
     * @return boolean
     */
    public function isAnalista(User $user)
    {
        return $user->role == User::ROLE_ENUM['analista'];
    }

    /**
     * Checa se o usuário logado é um protocolista.
     *
     * @return boolean
     */
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
     * Checa se o usuário logado é um analista de processo.
     *
     * @return boolean
     */
    public function isAnalistaProcesso(User $user)
    {
        if($this->isAnalista($user)){
            $processo = TipoAnalista::where('tipo', TipoAnalista::TIPO_ENUM['processo'])->first();
            if($user->tipo_analista()->where('tipo_analista_id', $processo->id)->first() != null){
                return True;
            }else{
                return False;
            }
        }
    }

    /**
     * Checa se o usuário logado é um analista de poda.
     *
     * @return boolean
     */
    public function isAnalistaPoda(User $user)
    {
        if($this->isAnalista($user)){
            $analistaPoda = TipoAnalista::where('tipo', TipoAnalista::TIPO_ENUM['poda'])->first();
            if($analistaPoda != null && $user->tipo_analista()->where('tipo_analista_id', $analistaPoda->id)->first() != null){
                return True;
            }else{
                return False;
            }
        }
    }

    /**
     * Checa se o usuário logado é um analista de poda ou secretario.
     *
     * @return boolean
     */
    public function isAnalistaPodaOrSecretario(User $user)
    {
        return $this->isSecretario($user) || $this->isAnalistaPoda($user);
    }

    /**
     * Checa se o usuário logado é um analista de poda ou secretario.
     *
     * @return boolean
     */
    public function isProcessoOrProtocolista(User $user)
    {
        return $this->isAnalistaProcesso($user) || $this->isProtocolista($user);
    }

    /**
     * Checa se o usuário logado é um requerente.
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
