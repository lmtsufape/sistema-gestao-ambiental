<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ParecerSolicitacao extends Notification
{
    use Queueable;

    public $solicitacao;

    public $parecer;

    public $tipo;

    public $motivo;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($solicitacao, $tipo, $parecer, $motivo = null)
    {
        $this->solicitacao = $solicitacao;
        $this->parecer = $parecer;
        $this->tipo = $tipo;
        $this->motivo = $motivo;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
                    ->line("Sua solicitação de {$this->tipo} com protocolo {$this->solicitacao->protocolo} foi {$this->parecer}")
                    ->line($this->motivo != null ? "Justificativa: {$this->motivo}" : '')
                    ->subject("Solicitacão {$this->parecer}");
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
