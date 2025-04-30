<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SecretariaService
{
    protected $apiUrl = 'https://gestao-api.dev.br:4000/api/secretarias';

    public function getSecretarias()
    {
        if(session('prefeitura_id') == 99)
        {
            return $this->listarSecretaria();
        }else{
            return $this->secretariasPorPrefeitura_id(session('prefeitura_id'));
        }
    }

    public function listarSecretaria()
    {
        try {
            $token = session('jwt_token');
            $response = Http::withToken($token)->get($this->apiUrl);

            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::error("Erro ao listar secretarias: " . $e->getMessage());
            return null;
        }
    }

    public function cadastrarSecretaria(array $dados)
    {
        try {
            $token = session('jwt_token');
            $response = Http::withToken($token)->post($this->apiUrl, $dados);

            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::error("Erro ao cadastrar secretaria: " . $e->getMessage());
            return null;
        }
    }

    public function atualizarSecretaria($id, array $dados)
    {
        try {
            
            $token = session('jwt_token');
            $response = Http::withToken($token)->put("{$this->apiUrl}/{$id}", $dados);
            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::error("Erro ao atualizar secretaria {$id}: " . $e->getMessage());
            return null;
        }
    }

    public function secretariasPorPrefeitura_id($prefeitura_id)
    {
        try {
            $token = session('jwt_token');
            $response = Http::withToken($token)->get("{$this->apiUrl}/prefeitura/{$prefeitura_id}");
            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::error("Erro ao buscar secretarias da Prefeitura {$prefeitura_id}: " . $e->getMessage());
            return null;
        }
    }

    public function excluirSecretaria($id)
    {
        try {
            $token = session('jwt_token');
            $response = Http::withToken($token)->delete("{$this->apiUrl}/{$id}");

            return $response->successful();
        } catch (\Exception $e) {
            Log::error("Erro ao excluir secretaria {$id}: " . $e->getMessage());
            return false;
        }
    }

    public function buscarSecretariaPorId($id)
    {
        try {
            $token = session('jwt_token');
            $response = Http::withToken($token)->get("{$this->apiUrl}/{$id}");

            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::error("Erro ao buscar secretaria {$id}: " . $e->getMessage());
            return null;
        }
    }


}
