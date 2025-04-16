<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LogService
{
    protected $apiUrl = 'https://gestao-api.dev.br:4000/api/Logs';

    public function listarLogs()
    {
        try {
            $token = session('jwt_token');
            $response = Http::withToken($token)->get($this->apiUrl);

            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::error("Erro ao listar Logs: " . $e->getMessage());
            return null;
        }
    }

}
