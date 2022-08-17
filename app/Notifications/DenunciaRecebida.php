<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DenunciaRecebida extends Notification
{
    use Queueable;

    public $protocolo;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($protocolo)
    {
        $this->protocolo = $protocolo;
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
                    ->line('Sua denúncia foi recebida com sucesso! Ela se encontra sob análise da Secretária de Desenvolvimento Rural e Meio Ambiente. Acompanhe a tramitação dela por meio do seguinte protocolo:')
                    ->line($this->protocolo);
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
