<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RelatorioService
{
    protected string $baseUrl = 'https://gestao-api.dev.br:4000/api'; // ajuste conforme sua API
    protected ?string $token = null; // ou use config/env

    public function __construct()
    {
        $this->token = config('services.abastecimento_api.token'); // ou .env('ABASTECIMENTO_API_TOKEN')
    }

    public function buscarAbastecimentos(array $filtros = []): array
    {
        $token = session('jwt_token');
        $response = Http::withToken($token)
            ->post("{$this->baseUrl}/relatorio/abastecimentos", $filtros);
            
        if (!$response->successful()) {
            throw new \Exception('Erro ao buscar dados da API de abastecimentos.');
        }

        return $response->json();
    }
}
