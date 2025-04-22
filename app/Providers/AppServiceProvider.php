<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use App\Models\Prefeitura;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::aliasMiddleware('jwt.auth', JwtMiddleware::class);
        View::composer('*', function ($view) {
            // Certifique-se de que você tem uma lógica para obter as prefeituras, como no seu método anterior
            $empresa_id = session('empresa_id');  // Exemplo de como obter a empresa ID a partir de sessão
            if ($empresa_id) {
                $prefeituras = Prefeitura::where('empresa_id', $empresa_id)->get();
                $view->with('prefeituras', $prefeituras);
            }
        });
    }
}
