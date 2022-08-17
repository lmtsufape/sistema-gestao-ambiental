<?php

namespace App\Notifications;

use App\Models\Requerimento;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DocumentosEnviadosNotification extends Notification
{
    use Queueable;

    public $requerimento;

    public $assunto;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Requerimento $requerimento, $assunto = '')
    {
        $this->requerimento = $requerimento;
        $this->assunto = $assunto;
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
        return (new MailMessage)->markdown(
            'mail.documentos_enviados',
            ['requerimento' => $this->requerimento]
        )->subject($this->assunto);
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
