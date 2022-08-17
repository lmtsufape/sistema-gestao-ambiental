<?php

namespace App\Notifications;

use App\Models\Empresa;
use App\Models\Notificacao;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificacaoCriadaNotification extends Notification
{
    use Queueable;

    private $notificacao;

    private $empresa;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Notificacao $notificacao, Empresa $empresa)
    {
        $this->notificacao = $notificacao;
        $this->empresa = $empresa;
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
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        $comentarios = [];
        foreach ($this->notificacao->fotos as $index => $foto) {
            if ($foto->comentario != '') {
                $comentarios[$index] = 'Comentário da foto' . ($index + 1) . ': ' . $foto->comentario;
            }
        }

        $message = (new MailMessage)
            ->markdown(
                'mail.notificacao_criada',
                [
                    'empresa' => $this->empresa->nome,
                    'imagens' => ! $this->notificacao->fotos->isEmpty(),
                    'texto' => $this->notificacao->texto,
                    'comentarios' => $comentarios,
                ]
            )->subject('Notificação da Secretária de Meio Ambiente');
        foreach ($this->notificacao->fotos as $index => $foto) {
            $message->attach(storage_path('app' . DIRECTORY_SEPARATOR . $foto->caminho), ['as' => 'foto' . ($index + 1), 'mime' => 'image/png']);
        }

        return $message;
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
