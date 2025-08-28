<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Str;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        activity('security')
            ->event('login_success')
            ->causedBy($event->user)
            ->withProperties([
                'guard'      => $event->guard ?? 'web',
                'ip'         => request()->ip(),
                'user_agent' => Str::limit(request()->userAgent(), 255),
            ])->log('Usuário autenticado com sucesso');
    }
}
