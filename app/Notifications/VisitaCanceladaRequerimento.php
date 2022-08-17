<?php

namespace App\Notifications;

use App\Models\Requerimento;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VisitaCanceladaRequerimento extends Notification
{
    use Queueable;

    public Requerimento $requerimento;

    public $data_marcada;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Requerimento $requerimento, $data_marcada)
    {
        $this->requerimento = $requerimento;
        $this->data_marcada = $data_marcada;
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
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.UTF-8', 'portuguese');

        return (new MailMessage())
            ->markdown(
                'mail.visita-cancelada-requerimento',
                [
                    'requerimento' => $this->requerimento,
                    'data_marcada' => strftime('%A, %d de %B de %Y', strtotime($this->data_marcada)),
                ]
            )->subject('Visita cancelada');
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
