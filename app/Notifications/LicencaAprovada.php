<?php

namespace App\Notifications;

use App\Models\Licenca;
use App\Models\Requerimento;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class LicencaAprovada extends Notification
{
    use Queueable;

    public Requerimento $requerimento;
    public Licenca $licenca;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Requerimento $requerimento, Licenca $licenca)
    {
        $this->requerimento = $requerimento;
        $this->licenca = $licenca;
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
        return (new MailMessage)
                    ->line("A licença do requerimento de {$this->requerimento->tipoString()} da empresa {$this->requerimento->empresa->nome} foi aprovada.")
                    ->line("A licença segue em anexo e também está disponível no site.")
                    ->attach(storage_path('app/'.$this->licenca->caminho), ['as' => 'licenca.pdf', 'mime' => 'application/pdf'])
                    ->subject('Licença aprovada!');
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
