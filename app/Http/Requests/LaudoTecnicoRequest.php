<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LaudoTecnicoRequest extends FormRequest
{
    public function authorize()
    {
        $user = Auth::user();
        return $user->role == User::ROLE_ENUM['secretario'] || $user->role == User::ROLE_ENUM['analista'];
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'condicoes' => ['required', 'string'],
            'localizacao' => ['required', 'string'],
            'imagem' => ['required', 'array', 'min:1'],
            'comentario' => ['nullable', 'array'],
            'imagem.*' => ['required', 'file', 'mimes:jpg,bmp,png', 'max:2048'],
        ];
    }

    public function messages()
    {
        return [
            'imagem.min' => 'É necessário 1 (uma) imagem',
            'imagem.required' => 'É necessário uma imagem',
        ];
    }

    public function attributes()
    {
        return [
            'condicoes' => 'condições fitosanitárias da árvore',
            'localizacao' => 'localização',
        ];
    }
}
