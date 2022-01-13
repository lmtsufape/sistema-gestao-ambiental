<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SolicitacaoPodaRequest extends FormRequest
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
            'cep' => ['required', 'string'],
            'bairro' => ['required', 'string'],
            'rua' => ['required', 'string'],
            'numero' => ['required'],
            'cidade' => ['required', 'in:Garanhuns'],
            'estado' => ['required', 'in:PE'],
            'complemento' => ['nullable'],
            'imagem.*' => ['nullable', 'file', 'mimes:jpg,bmp,png', 'max:2048'],
            'comentarios' => ['nullable', 'array'],
            'comentario' => ['nullable', 'string'],
        ];
    }
}
