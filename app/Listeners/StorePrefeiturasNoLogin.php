<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Session;
use App\Services\PrefeituraService; // Importando o serviço PrefeituraService

class StorePrefeiturasNoLogin
{
    protected $prefeituraService;

    // Injeção de dependência do serviço no construtor
    public function __construct(PrefeituraService $prefeituraService)
    {
        $this->prefeituraService = $prefeituraService; // Atribuindo o serviço à variável da classe
    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        try {
            // Obter o ID da empresa associada ao usuário
            $empresa_id = $event->user->empresa_id;  // Supondo que o campo "empresa_id" esteja no modelo User

            // Usando o serviço para buscar as prefeituras para a empresa
            $prefeituras = $this->prefeituraService->prefeiturasPorEmpresa_id($empresa_id);

            // Armazenar as prefeituras na sessão
            Session::put('prefeituras', $prefeituras);
        } catch (\Exception $e) {
            \Log::error('Erro ao buscar prefeituras: ' . $e->getMessage());
        }
    }
}
