<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PostoService
{
    protected $apiUrl = 'https://gestao-api.dev.br:4000/api/postos';

    public function getPostos()
    {
        if(Auth::user()->id == 1)
        {
            return $this->listarPostos();
        }else{
            return $this->listarPostosPorPrefeitura(session('prefeitura_id'));
        }
    }

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

    public function listarPostosPorPrefeitura($prefeituraId)
{
    try {
        // Obtém o token JWT da sessão
        $token = session('jwt_token');
        
        // Define a URL da API com o parâmetro de prefeitura
        $url = "$this->apiUrl/prefeitura/$prefeituraId";  // URL para listar postos da prefeitura
        
        // Faz a requisição para a API
        $response = Http::withToken($token)->get($url);

        // Verifica se a resposta foi bem-sucedida
        if ($response->successful()) {
            return $response->json();  // Retorna os postos encontrados
        }

        // Se a resposta não foi bem-sucedida, retorna null
        return null;
    } catch (\Exception $e) {
        // Em caso de erro, loga a mensagem de erro
        Log::error("Erro ao listar postos da prefeitura: " . $e->getMessage());
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
