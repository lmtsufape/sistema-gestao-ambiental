<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogLockout
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
            ->event('login_lockout')
            ->causedByAnonymous()
            ->withProperties([
                'ip'         => $event->request->ip(),
                'throttleKey'=> app('auth')->createUserProvider('users') ? $event->request->input('email') : null,
            ])->log('Usuário temporariamente bloqueado por excesso de tentativas');
    }
}
