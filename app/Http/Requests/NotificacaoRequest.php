<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class NotificacaoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $role = auth()->user()->role;
        return $role == User::ROLE_ENUM['analista'] || $role == User::ROLE_ENUM['secretario'];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'texto'    => ['required', 'min:20', 'string'],
            "imagem.*" => ['nullable', 'file', 'mimes:jpg,bmp,png', 'max:2048'],
            "comentario.*" => ['nullable', 'string'],
        ];
    }
}
