<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\User' => 'App\Policies\UserPolicy',
        'App\Models\Requerimento' => 'App\Policies\RequerimentoPolicy',
        'App\Models\Empresa' => 'App\Policies\EmpresaPolicy',
        'App\Models\Notificacao' => 'App\Policies\NotificacaoPolicy',
        'App\Models\Visita' => 'App\Policies\VisitaPolicy',
        'App\Models\Noticia' => 'App\Policies\NoticiaPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
        $this->app->auth->provider('custom', function ($app, array $config) {
            return new UserProvider($app['hash'], $config['model']);
        });
    }
}
