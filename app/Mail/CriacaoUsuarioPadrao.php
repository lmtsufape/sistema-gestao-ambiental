<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CriacaoUsuarioPadrao extends Mailable
{
    use Queueable;
    use SerializesModels;

    private $novo_user;
    private $senha_random;
    

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($novo_user, $senha_random)
    {
        $this->novo_user = $novo_user;
        $this->senha_random = $senha_random;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Usuário Padrão SGA')
            ->markdown('mail.criacao_usuario_padrao')
            ->with(['user' => $this->novo_user,
                    'senha' => $this->senha_random]);
    }
}
