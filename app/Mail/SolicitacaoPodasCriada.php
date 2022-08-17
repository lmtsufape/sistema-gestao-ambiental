<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SolicitacaoPodasCriada extends Mailable
{
    use Queueable, SerializesModels;

    private $solicitacao;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($solicitacao)
    {
        $this->solicitacao = $solicitacao;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Solicitação de poda/supressão')
            ->markdown('mail.solicitacao_podas_criada')
            ->with('solicitacao', $this->solicitacao);
    }
}
