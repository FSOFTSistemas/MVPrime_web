<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PrefeituraService
{
    protected $apiUrl = 'https://gestao-api.dev.br:4000/api/prefeituras';

    public function listarPrefeituras()
    {
        try {
            $token = session('jwt_token');
            $response = Http::withToken($token)->get($this->apiUrl);

            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::error("Erro ao listar prefeituras: " . $e->getMessage());
            return null;
        }
    }

    public function cadastrarPrefeitura(array $dados)
    {
        try {
            $token = session('jwt_token');
            $response = Http::withToken($token)->post($this->apiUrl, $dados);

            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::error("Erro ao cadastrar prefeitura: " . $e->getMessage());
            return null;
        }
    }

    public function atualizarPrefeitura($id, array $dados)
    {
        try {
            
            $token = session('jwt_token');
            $response = Http::withToken($token)->put("{$this->apiUrl}/{$id}", $dados);
            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::error("Erro ao atualizar prefeitura {$id}: " . $e->getMessage());
            return null;
        }
    }

    public function prefeiturasPorEmpresa_id($empresa_id)
    {
        try {
            
            $token = session('jwt_token');
            $response = Http::withToken($token)->get("https://gestao-api.dev.br:4000/api/empresa/{$empresa_id}/prefeituras");
            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::error("Erro ao buscar prefeituras da empresa {$empresa_id}: " . $e->getMessage());
            return null;
        }
    }

    public function excluirPrefeitura($id)
    {
        try {
            $token = session('jwt_token');
            $response = Http::withToken($token)->delete("{$this->apiUrl}/{$id}");

            return $response->successful();
        } catch (\Exception $e) {
            Log::error("Erro ao excluir prefeitura {$id}: " . $e->getMessage());
            return false;
        }
    }

    public function buscarPrefeituraPorId($id)
    {
        try {
            $token = session('jwt_token');
            $response = Http::withToken($token)->get("{$this->apiUrl}/{$id}");

            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::error("Erro ao buscar prefeitura {$id}: " . $e->getMessage());
            return null;
        }
    }


}
