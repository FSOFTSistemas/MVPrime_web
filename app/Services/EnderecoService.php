<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EnderecoService
{
    protected $apiUrl = 'https://gestao-api.dev.br:4000/api/enderecos';

    // Método para listar todos os endereços
    public function listarEnderecos()
    {
        try {
            // Realiza a requisição GET para a API
            $response = Http::get($this->apiUrl);

            // Verifica se a requisição foi bem-sucedida
            if ($response->successful()) {
                return $response->json(); // Retorna os endereços da API
            }

            // Caso a requisição falhe, loga o erro
            Log::error('Erro ao listar endereços: ' . $response->body());

            return null; // Retorna null em caso de falha
        } catch (\Exception $e) {
            // Caso ocorra uma exceção, loga a mensagem
            Log::error('Exceção ao listar endereços: ' . $e->getMessage());

            return null; // Retorna null para indicar falha
        }
    }

    // Método para criar um novo endereço
    public function createEndereco(array $dados)
    {
        try {
            // Realiza a requisição POST para a API
            $response = Http::post($this->apiUrl, $dados);

            // Verifica se a requisição foi bem-sucedida
            if ($response->successful()) {
                return $response->json(); // Retorna o endereço criado
            }

            // Caso a requisição falhe, loga o erro
            Log::error('Erro ao criar endereço: ' . $response->body());

            return null; // Retorna null em caso de falha
        } catch (\Exception $e) {
            // Caso ocorra uma exceção, loga a mensagem
            Log::error('Exceção ao criar endereço: ' . $e->getMessage());

            return null; // Retorna null para indicar falha
        }
    }
}