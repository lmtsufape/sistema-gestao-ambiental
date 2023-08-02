<?php

namespace App\Notifications;

use App\Models\Requerimento;
use App\Models\RequerimentoDocumento;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DocumentosExigenciasAnalisadosNotification extends Notification
{
    use Queueable;

    public $assunto;

    public $requerimento_documentos;

    public $documentos;

    public $requerimento;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Requerimento $requerimento, $requerimento_documentos, $documentos, $assunto = '')
    {
        $this->requerimento_documentos = $requerimento_documentos;
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
        return (new MailMessage())->markdown(
            'mail.documentos-exigencias-analisados',
            ['documentos' => $this->documentos, 'requerimento' => $this->requerimento, 'requerimento_documentos' => $this->requerimento_documentos]
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
