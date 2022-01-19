<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SolicitacaoMudaAvaliarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return$this->user()->can('avaliar', SolicitacaoMuda::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => ['required'],
            'motivo_indeferimento' => ['required_if:status,3'], // 3 = indeferido
            'arquivo' => ['required_if:status,2', 'mimes:pdf', 'max:2048', 'file'], // 2 = deferido
        ];
    }

    public function messages()
    {
        return [
            'motivo_indeferimento.*' => 'O motivo do indeferimento é obrigatório',
        ];
    }
}
