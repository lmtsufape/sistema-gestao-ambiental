<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PrazoExigenciasExpirado extends Mailable
{
    use Queueable, SerializesModels;

    public $requerimento_documento;

    /**
     * Create a new message instance.
     *
     * @param  $subject
     * @param  $data
     * @return void
     */
    public function __construct($subject, $data)
    {
        $this->subject($subject);
        $this->requerimento_documento = $data['requerimento_documento'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Prazo de exigências expirado')
            ->markdown('mail.prazo_exigencias_expirado')
            ->with('requerimento_documento', $this->requerimento_documento);
    }
}