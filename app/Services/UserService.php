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
}