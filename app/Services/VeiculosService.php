<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
class VeiculosService
{
    protected $apiUrl = 'https://gestao-api.dev.br:4000/api/veiculos';

    

public function listarVeiculos()
{
    try {
        $token = session('jwt_token');
        $response = Http::withToken($token)->get($this->apiUrl);

        if ($response->successful()) {
            $veiculos = $response->json();

            // Itera sobre os veiculos e formata a data de vencimento_cnh
            foreach ($veiculos as &$veiculo) {
                if (isset($veiculo['vencimento_cnh'])) {
                    // Converte a data de vencimento_cnh para o formato Y-m-d
                    $veiculo['vencimento_cnh'] = Carbon::parse($veiculo['vencimento_cnh'])->format('Y-m-d');
                }
            }

            return $veiculos;
        }

        return null;
    } catch (\Exception $e) {
        Log::error("Erro ao listar veiculos: " . $e->getMessage());
        return null;
    }
}


    public function cadastrarVeiculo(array $dados)
    {
        try {
            $token = session('jwt_token');
            $response = Http::withToken($token)->post($this->apiUrl, $dados);

            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::error("Erro ao cadastrar veiculo: " . $e->getMessage());
            return null;
        }
    }

    public function atualizarVeiculo($id, array $dados)
    {
        try {
            //dd($dados);
            $token = session('jwt_token');
            $response = Http::withToken($token)->put("{$this->apiUrl}/{$id}", $dados);
            //dd($response);
            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::error("Erro ao atualizar veiculo {$id}: " . $e->getMessage());
            return null;
        }
    }

    public function excluirVeiculo($id)
    {
        try {
            $token = session('jwt_token');
            $response = Http::withToken($token)->delete("{$this->apiUrl}/{$id}");

            return $response->successful();
        } catch (\Exception $e) {
            Log::error("Erro ao excluir veiculo {$id}: " . $e->getMessage());
            return false;
        }
    }

    public function buscarVeiculoPorId($id)
    {
        try {
            $token = session('jwt_token');
            $response = Http::withToken($token)->get("{$this->apiUrl}/{$id}");

            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::error("Erro ao buscar veiculo {$id}: " . $e->getMessage());
            return null;
        }
    }


}
