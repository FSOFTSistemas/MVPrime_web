<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use App\Listeners\StorePrefeiturasNoLogin;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * O mapeamento de eventos para ouvintes.
     *
     * @var array
     */
    protected $listen = [
        Login::class => [
            StorePrefeiturasNoLogin::class,
        ],
    ];

    /**
     * Registre os ouvintes de eventos no aplicativo.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // Outros eventos ou listeners podem ser configurados aqui, se necessário
    }
}
