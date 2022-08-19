<?php

namespace App\Rules;

use App\Models\Checklist;
use App\Models\Requerimento;
use Illuminate\Contracts\Validation\ImplicitRule;

class ArquivoEnviado implements ImplicitRule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Requerimento $requerimento, $id)
    {
        $this->requerimento = $requerimento;
        $this->documento = $this->requerimento->documentos()->withPivot('status')->where('documento_id', $id)->first();
        $this->status = Checklist::STATUS_ENUM;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return in_array($this->documento->pivot->status, [$this->status['enviado'], $this->status['aceito']]);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if ($this->documento->status == $this->status['recusado']) {
            return 'Faça o reenvio do arquivo ' . $this->documento->nome;
        }

        return 'O campo ' . $this->documento->nome . ' é obrigatório';
    }
}
