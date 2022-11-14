<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DenunciaRequest extends FormRequest
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

    public function attributes()
    {
        return [
            'texto' => 'denúncia',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'empresa_id' => request()->has('empresa_id') && strcmp($this->empresa_id, 'none') == 0 ? 'nullable' : 'nullable|integer',
            'empresa_nao_cadastrada' => 'nullable|string|min:5|max:255|required_if:empresa_id,none',
            'endereco' => 'nullable|string|min:5|max:255|required_if:empresa_id,none',
            'denunciante' => 'nullable|string|min:5|max:255',
            'texto' => 'required|string|min:10|max:2000',
            'imagem.*' => 'nullable|file|mimes:jpg,bmp,png|max:2048',
            'video.*' => 'nullable|file|mimes:mp4,mkv,3gp,avi,m4v,ogg|max:51200',
            'comentario.*' => 'nullable|string|min:5|max:255',
            'arquivoFile' => 'nullable|file|max:2048|mimes:pdf',
        ];
    }

    public function messages()
    {
        return [
            'empresa_id.integer' => 'Selecione uma empresa',
            'imagem.*.max' => 'A imagem não pode ter mais de 2MB',
            'imagem.*.mimes' => 'A imagem deve estar no formato jpg, bmp ou png',
            'video.*.max' => 'O vídeo não pode ter mais de 50MB',
            'video.*.mimes' => 'O vídeo deve estar no formato mp4, mkv, 3gp, avi, ogg ou m4v',
            'comentario.*.min' => 'O comentário deve ter no mínimo 5 caracteres',
            'comentario.*.max' => 'O comentário deve ter no máximo 255 caracteres',
            'empresa_nao_cadastrada.min' => 'O campo nome da empresa é deve ter no mínimo 5 caracteres',
            'empresa_nao_cadastrada.max' => 'O campo nome da empresa é deve ter no máximo 255 caracteres',
            'empresa_nao_cadastrada.required_if' => 'O campo empresa não cadastrada é obrigatório quando nenhuma empresa é selecionada',
            'denunciante.min' => 'O nome do denunciante deve ter no mínimo 5 caracteres',
            'denunciante.max' => 'O nome do denunciante deve ter no máximo 255 caracteres',
            'endereco.required_if' => 'O campo endereco é obrigatório quando nenhuma empresa é selecionada',
        ];
    }
}
