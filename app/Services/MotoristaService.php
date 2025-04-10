<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
class MotoristaService
{
    protected $apiUrl = 'https://gestao-api.dev.br:4000/api/motoristas';

    

public function listarMotoristas()
{
    try {
        $token = session('jwt_token');
        $response = Http::withToken($token)->get($this->apiUrl);

        if ($response->successful()) {
            $motoristas = $response->json();

            // Itera sobre os motoristas e formata a data de vencimento_cnh
            foreach ($motoristas as &$motorista) {
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


    public function cadastrarMotorista(array $dados)
    {
        try {
            $token = session('jwt_token');
            $response = Http::withToken($token)->post($this->apiUrl, $dados);

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
