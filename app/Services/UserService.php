<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UserService
{
    protected $apiUrl = 'https://gestao-api.dev.br:4000/api/usuarios';

    // Método para buscar todos os usuários
    public function getAllUsers()
    {
        try {
            $token = session('jwt_token');
            $response = Http::withToken($token)->get($this->apiUrl);


            // Verifica se a requisição foi bem-sucedida
            if ($response->successful()) {
                return $response->json(); // Retorna os dados JSON da API
            }

            // Se a requisição falhar, loga o erro
            Log::error("Erro ao buscar usuários: " . $response->status());

            return null; // Retorna null em caso de falha
        } catch (\Exception $e) {
            // Loga a exceção caso ocorra um erro
            Log::error("Exceção ao buscar usuários: " . $e->getMessage());

            return null; // Retorna null em caso de erro
        }
    }

    public function getUsersByPrefeitura($prefeituraId)
{
    try {
        // Obtém o token JWT da sessão
        $token = session('jwt_token');
        
        // Define a URL da API com o parâmetro de prefeitura
        $url = "$this->apiUrl/prefeitura/$prefeituraId";  // URL para listar usuários da prefeitura
        
        // Faz a requisição para a API
        $response = Http::withToken($token)->get($url);

        // Verifica se a resposta foi bem-sucedida
        if ($response->successful()) {
            return $response->json(); // Retorna os usuários em formato JSON
        }

        // Se a requisição falhar, loga o erro
        Log::error("Erro ao buscar usuários pela prefeitura: " . $response->status());

        return null; // Retorna null em caso de falha
    } catch (\Exception $e) {
        // Loga a exceção caso ocorra um erro
        Log::error("Exceção ao buscar usuários pela prefeitura: " . $e->getMessage());

        return null; // Retorna null em caso de erro
    }
}

    // Método para buscar um usuário específico por ID
    public function getUserById($id)
    {
        try {
            $response = Http::get("{$this->apiUrl}/{$id}");

            // Verifica se a requisição foi bem-sucedida
            if ($response->successful()) {
                return $response->json(); // Retorna o usuário encontrado
            }

            // Se a requisição falhar, loga o erro
            Log::error("Erro ao buscar usuário com ID {$id}: " . $response->status());

            return null;
        } catch (\Exception $e) {
            // Loga a exceção caso ocorra um erro
            Log::error("Exceção ao buscar usuário com ID {$id}: " . $e->getMessage());

            return null;
        }
    }

    public function createUser(array $data)
    {
        try {
            $token = session('jwt_token');

            $response = Http::withToken($token)->post("https://gestao-api.dev.br:4000/api/usuarios", $data);

            if ($response->successful()) {
                return $response->json();
            }

            // Loga o erro caso não tenha sucesso
            Log::error("Erro ao criar usuário: " . $response->body());

            return null; // Retorna null em caso de falha
        } catch (\Exception $e) {
            // Loga a exceção em caso de erro
            Log::error("Exceção ao criar usuário: " . $e->getMessage());

            return null; // Retorna null para indicar falha
        }
    }

    public function deleteUser($id)
    {
        try {
            // Obtém o token do usuário autenticado
            $token = session('jwt_token');

            // Faz a requisição DELETE para a API
            $response = Http::withToken($token)->delete("https://gestao-api.dev.br:4000/api/usuarios/{$id}");

            // Verifica se a requisição foi bem-sucedida (código 204 - No Content)
            if ($response->successful()) {
                return true; // Retorna true se a exclusão for bem-sucedida
            }

            Log::error("Erro ao deletar usuário ID {$id}: " . $response->body());

            return false; // Retorna false em caso de erro
        } catch (\Exception $e) {

            Log::error("Exceção ao deletar usuário ID {$id}: " . $e->getMessage());

            return false; // Retorna false para indicar falha
        }
    }

    public function updateUser($id, array $dados)
    {
        try {
            // Obtém o token do usuário autenticado
            $token = session('jwt_token');

            // Faz a requisição PUT para a API
            $response = Http::withToken($token)
                ->put("https://gestao-api.dev.br:4000/api/usuarios/{$id}", $dados);

            // Verifica se a requisição foi bem-sucedida
            if ($response->successful()) {
                return $response->json(); // Retorna os dados atualizados
            }

            // Loga o erro caso a API retorne falha
            Log::error("Erro ao atualizar usuário ID {$id}: " . $response->body());

            return null; // Retorna null em caso de erro
        } catch (\Exception $e) {
            // Loga a exceção caso ocorra um erro
            Log::error("Exceção ao atualizar usuário ID {$id}: " . $e->getMessage());

            return null; // Retorna null para indicar falha
        }
    }
}
