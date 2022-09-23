<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SolicitacaoMudaRequest extends FormRequest
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
            'comentario' => ['nullable', 'string'],
            'qtd_mudas.*' => ['required', 'numeric', 'min:1'],
            'especie.*' => ['required'],
            'local' => ['required', 'string', 'min:3'],
        ];
    }

    public function messages()
    {
        return [
            'qtd_mudas.*.required' => 'O campo quantidade é obrigatório',
            'qtd_mudas.*.numeric' => 'O campo quantidade deve ser um numérico',
            'especie.*.numeric' => 'O campo espécie é obrigatório',
        ];
    }
}
