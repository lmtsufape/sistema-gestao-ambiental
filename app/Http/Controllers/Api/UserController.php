<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Usuário
     *
     * Consulta o usuário autenticado.
     *
     * @response status=200 scenario="success" {"id": 1,"name": "Margarita Block II","email": "klein.turner@example.net"}
     *
     * @responseField id Identificador do usuário
     * @responseField name Nome do usuário
     * @responseField email E-mail do usuário
     */
    public function show(Request $request)
    {
        return $request->user()->toArray();
    }
}
