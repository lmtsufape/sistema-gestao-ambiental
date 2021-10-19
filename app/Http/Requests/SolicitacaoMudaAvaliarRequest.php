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
        $user = Auth::user();
        return $user->role == User::ROLE_ENUM['secretario'] || $user->role == User::ROLE_ENUM['analista'];
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
        ];
    }

    public function messages()
    {
        return [
            'motivo_indeferimento.*' => 'O motivo do indeferimento é obrigatório',
        ];
    }
}
