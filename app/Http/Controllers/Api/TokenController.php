<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class TokenController extends Controller
{
    /**
     * Autenticação
     *
     * Cria um token de autenticação para o usuário.
     *
     * @unauthenticated
     *
     * @response 422 scenario="Unprocessable Content" {"message":"The given data was invalid.","errors":{"email":["The provided credentials are incorrect."]}}
     *
     * @response 200 scenario="success" {"id": 2, "name": "Analista", "email": "analista@analista.com", "profile_photo_url": "http://localhost/sistema-gestao-ambiental/storage/users/2/fotoperfil.jpeg", "token": "6|EOhmEVnaTK2vqFvL2q2oTFSCi1UmtSLG0mel1alc"}
     *
     * @bodyParam email string required Email do usuário
     *
     * @bodyParam password string required Senha do usuário
     *
     * @bodyParam device_name string required Nome para identificação do token
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->where('role', User::ROLE_ENUM['analista'])->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        $dados = $user->only(['id', 'name', 'email', 'profile_photo_url']);
        $dados['token'] = $user->createToken($request->device_name)->plainTextToken;

        return $dados;
    }
}
