<?php

namespace App\Http\Controllers\Api;


use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    /**
     *
     * Autenticação
     * 
     * Cria um token de autenticação para o usuário.
     *
     * @unauthenticated
     *
     * @response 422 scenario="Unprocessable Content" {"message":"The given data was invalid.","errors":{"email":["The provided credentials are incorrect."]}}
     *
     * @response 200 scenario="success" 4|ECTth7OLLJCAtH4HQDhhd1y6fiTmogoGvqGr9c6f
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

        return $user->createToken($request->device_name)->plainTextToken;
    }
}
