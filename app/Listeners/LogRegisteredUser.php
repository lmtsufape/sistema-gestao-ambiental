<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogRegisteredUser
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
            ->event('user_registered')
            ->causedBy($event->user)
            ->withProperties([
                'ip' => request()->ip(),
            ])->log('Novo usuário registrado');
    }
}
