<?php

namespace App\Notifications;

use App\Models\Requerimento;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DocumentosNotification extends Notification
{
    use Queueable;

    public $assunto;

    public $documentos;

    public $requerimento;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Requerimento $requerimento, $documentos, $assunto = '')
    {
        $this->documentos = $documentos;
        $this->assunto = $assunto;
        $this->requerimento = $requerimento;
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
            'mail.documentos',
            ['documentos' => $this->documentos, 'requerimento' => $this->requerimento]
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
