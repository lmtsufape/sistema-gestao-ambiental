<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoticiaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'título'            => 'required|string|max:255',
            'publicar'          => 'nullable',
            'destaque'          => 'nullable',
            'texto'             => 'required|string|min:50',
            'link'              => 'nullable',
            'imagem_principal'  => 'required|file|mimes:png,jpg|max:2048',
        ];
    }
}
