<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PostoService
{
    protected $apiUrl = 'https://gestao-api.dev.br:4000/api/postos';

    public function listarPostos()
    {
        try {
            $token = session('jwt_token');
            $response = Http::withToken($token)->get($this->apiUrl);

            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::error("Erro ao listar postos: " . $e->getMessage());
            return null;
        }
    }

    public function cadastrarPosto(array $dados)
    {
        try {
            $token = session('jwt_token');
            $response = Http::withToken($token)->post($this->apiUrl, $dados);

            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::error("Erro ao cadastrar posto: " . $e->getMessage());
            return null;
        }
    }

    public function atualizarPosto($id, array $dados)
    {
        try {
            
            $token = session('jwt_token');
            $response = Http::withToken($token)->put("{$this->apiUrl}/{$id}", $dados);
            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::error("Erro ao atualizar posto {$id}: " . $e->getMessage());
            return null;
        }
    }

    public function excluirPosto($id)
    {
        try {
            $token = session('jwt_token');
            $response = Http::withToken($token)->delete("{$this->apiUrl}/{$id}");

            return $response->successful();
        } catch (\Exception $e) {
            Log::error("Erro ao excluir posto {$id}: " . $e->getMessage());
            return false;
        }
    }

    public function buscarPostoPorId($id)
    {
        try {
            $token = session('jwt_token');
            $response = Http::withToken($token)->get("{$this->apiUrl}/{$id}");

            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::error("Erro ao buscar posto {$id}: " . $e->getMessage());
            return null;
        }
    }


}
