<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MotoristaService
{
    protected $apiUrl = 'https://gestao-api.dev.br:4000/api/motoristas';

    
    public function getMotoristas()
    {
        if(session('prefeitura_id') == 99)
        {

            return $this->listarMotoristas();
        }else{
            return $this->listarMotoristasPorPrefeitura(session('prefeitura_id'));
        }
    }

public function listarMotoristas()
{
    try {

        $token = session('jwt_token');
        $response = Http::withToken($token)->get($this->apiUrl);


        if ($response->successful()) {

            $motoristas = $response->json();

            // Itera sobre os motoristas e formata a data de vencimento_cnh
            foreach ($motoristas as $motorista) {
                if (isset($motorista['vencimento_cnh'])) {
                    // Converte a data de vencimento_cnh para o formato Y-m-d
                    $motorista['vencimento_cnh'] = Carbon::parse($motorista['vencimento_cnh'])->format('Y-m-d');
                }
            }

            return $motoristas;
        }

        return null;
    } catch (\Exception $e) {
        Log::error("Erro ao listar motoristas: " . $e->getMessage());
        return null;
    }
}

public function listarMotoristasPorPrefeitura($prefeituraId)
{
    try {
        // Obtém o token JWT da sessão
        $token = session('jwt_token');
        
        // Define a URL da API com o parâmetro de prefeitura
        $url = "$this->apiUrl/prefeitura/$prefeituraId"; // URL para listar motoristas da prefeitura
        
        // Faz a requisição para a API
        $response = Http::withToken($token)->get($url);

        // Verifica se a resposta foi bem-sucedida
        if ($response->successful()) {
            $motoristas = $response->json();

            // Itera sobre os motoristas e formata a data de vencimento_cnh
            foreach ($motoristas as &$motorista) {
                if (isset($motorista['vencimento_cnh'])) {
                    // Converte a data de vencimento_cnh para o formato Y-m-d
                    $motorista['vencimento_cnh'] = Carbon::parse($motorista['vencimento_cnh'])->format('Y-m-d');
                }
            }

            return $motoristas;  // Retorna os motoristas filtrados por prefeitura
        }

        // Se a resposta não foi bem-sucedida, retorna null
        return null;
    } catch (\Exception $e) {
        // Em caso de erro, loga a mensagem de erro
        Log::error("Erro ao listar motoristas por prefeitura: " . $e->getMessage());
        return null;
    }
}


    public function cadastrarMotorista(array $dados)
    {
        try {
            $token = session('jwt_token');
            $response = Http::withToken($token)->post($this->apiUrl, $dados);
            // dd($response);
            
            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::error("Erro ao cadastrar motorista: " . $e->getMessage());
            return null;
        }
    }

    public function atualizarMotorista($id, array $dados)
    {
        try {
            
            $token = session('jwt_token');
            $response = Http::withToken($token)->put("{$this->apiUrl}/{$id}", $dados);
            // dd($response);
            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::error("Erro ao atualizar motorista {$id}: " . $e->getMessage());
            return null;
        }
    }

    public function excluirMotorista($id)
    {
        try {
            $token = session('jwt_token');
            $response = Http::withToken($token)->delete("{$this->apiUrl}/{$id}");

            return $response->successful();
        } catch (\Exception $e) {
            Log::error("Erro ao excluir motorista {$id}: " . $e->getMessage());
            return false;
        }
    }

    public function buscarMotoristaPorId($id)
    {
        try {
            $token = session('jwt_token');
            $response = Http::withToken($token)->get("{$this->apiUrl}/{$id}");

            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::error("Erro ao buscar motorista {$id}: " . $e->getMessage());
            return null;
        }
    }


}
