<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class DocumentoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->role == User::ROLE_ENUM['secretario'];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome'              => 'required|string|min:10|max:290',
            'documento_modelo'  => 'required|file|mimes:pdf|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'documento_modelo.required'     => "O modelo do documento é obrigatório",
            'documento_modelo.max'          => "O modelo do documento deve ter no máximo 2MB",
            'documento_modelo.mimes'        => "O modelo do documento deve ser um PDF",
        ];
    }
}
