<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ImplicitRule;
use Illuminate\Support\Facades\Log;

class EmpresaNaoCadastradaRule implements ImplicitRule
{
    private $empresa_id, $crime_ambiental;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($empresa_id, $crime_ambiental)
    {
        $this->empresa_id = $empresa_id;
        $this->crime_ambiental = $crime_ambiental;
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
        if (is_numeric($this->empresa_id))
            return true;
        else if ($this->empresa_id == "none" && $this->crime_ambiental == "true")
            return true;
        else
            return $this->empresa_id == "none" && $this->crime_ambiental == "false" && (!empty($value) || !is_null(($value)));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "O campo nome da empresa é obrigatório quando nenhuma empresa é selecionada";
    }
}
