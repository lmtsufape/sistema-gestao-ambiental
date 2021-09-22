<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;

class ContatoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $nome_completo;
    public $email;
    public $mensagem;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->nome_completo = $request->nome_completo;
        $this->email = $request->email;
        $this->mensagem = $request->mensagem;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.contato')->with(['dados' => $this]);
    }
}
