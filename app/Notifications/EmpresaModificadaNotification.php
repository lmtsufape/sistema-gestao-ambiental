<?php

namespace App\Notifications;

use App\Models\Historico;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmpresaModificadaNotification extends Notification
{
    use Queueable;

    public $historico;

    public $assunto;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Historico $historico, $assunto = '')
    {
        $this->historico = $historico;
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
            'mail.empresa_modificada',
            ['historico' => $this->historico]
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
