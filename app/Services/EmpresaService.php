<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EmpresaService
{
    protected $apiUrl = 'https://gestao-api.dev.br:4000/api/empresas';

    public function getEmpresa()
    {

        if(Auth::user()->tipo_usuario == 0)
        {
            return $this->listarEmpresas();
        }else{
            return $this->listarEmpresasId(Auth::user()->empresa_id);
        }
    }

    // Método para listar todas as empresas
    public function listarEmpresas()
    {
        try {
            $token = session('jwt_token');
            $response = Http::withToken($token)->get($this->apiUrl);

            // Verifica se a requisição foi bem-sucedida
            if ($response->successful()) {
                return $response->json(); // Retorna as empresas
            }

            // Se a requisição falhar, loga o erro
            Log::error("Erro ao buscar empresas: " . $response->status());

            return null; // Retorna null em caso de falha
        } catch (\Exception $e) {
            // Loga a exceção caso ocorra um erro
            Log::error("Exceção ao buscar empresas: " . $e->getMessage());

            return null; // Retorna null em caso de erro
        }
    }

    // Método para listar todas as empresas
    public function listarEmpresasId($id)
    {
        try {
            $token = session('jwt_token');
            $response = Http::withToken($token)->get("{$this->apiUrl}/{$id}");

            // Verifica se a requisição foi bem-sucedida
            if ($response->successful()) {
                return $response->json(); // Retorna as empresas
            }

            // Se a requisição falhar, loga o erro
            Log::error("Erro ao buscar empresas: " . $response->status());

            return null; // Retorna null em caso de falha
        } catch (\Exception $e) {
            // Loga a exceção caso ocorra um erro
            Log::error("Exceção ao buscar empresas: " . $e->getMessage());

            return null; // Retorna null em caso de erro
        }
    }

    // Método para cadastrar uma nova empresa
    public function cadastrarEmpresa(array $dados)
    {
        try {
            $token = session('jwt_token');

            $response = Http::withToken($token)->post($this->apiUrl, $dados);

            // Verifica se a requisição foi bem-sucedida
            if ($response->successful()) {
                return $response->json(); // Retorna os dados da empresa criada
            }

            // Loga o erro caso não tenha sucesso
            Log::error("Erro ao cadastrar empresa: " . $response->body());

            return null; // Retorna null em caso de falha
        } catch (\Exception $e) {
            // Loga a exceção em caso de erro
            Log::error("Exceção ao cadastrar empresa: " . $e->getMessage());

            return null; // Retorna null para indicar falha
        }
    }

    // Método para atualizar os dados de uma empresa
    public function atualizarEmpresa($id, array $dados)
    {
        try {
            $token = session('jwt_token');

            $response = Http::withToken($token)
                ->put("{$this->apiUrl}/{$id}", $dados);

            // Verifica se a requisição foi bem-sucedida
            if ($response->successful()) {
                return $response->json(); // Retorna os dados da empresa atualizada
            }
            dd($response->body());

            // Loga o erro caso a API retorne falha
            Log::error("Erro ao atualizar empresa ID {$id}: " . $response->body());

            return null; // Retorna null em caso de erro
        } catch (\Exception $e) {
            // Loga a exceção caso ocorra um erro
            Log::error("Exceção ao atualizar empresa ID {$id}: " . $e->getMessage());

            return null; // Retorna null para indicar falha
        }
    }

    // Método para excluir uma empresa
    public function excluirEmpresa($id)
    {
        try {
            $token = session('jwt_token');

            // Faz a requisição DELETE para a API
            $response = Http::withToken($token)->delete("{$this->apiUrl}/{$id}");

            // Verifica se a requisição foi bem-sucedida (código 204 - No Content)
            if ($response->successful()) {
                return true; // Retorna true se a exclusão for bem-sucedida
            }

            // Loga o erro caso não tenha sucesso
            Log::error("Erro ao excluir empresa ID {$id}: " . $response->body());

            return false; // Retorna false em caso de erro
        } catch (\Exception $e) {
            // Loga a exceção caso ocorra um erro
            Log::error("Exceção ao excluir empresa ID {$id}: " . $e->getMessage());

            return false; // Retorna false para indicar falha
        }
    }
}
