<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AbastecimentoService
{
    protected $apiUrl = 'https://gestao-api.dev.br:4000/api/abastecimentos';


    public function getAbastecimentos()
    {
        if( Auth::user()->id == 1)
        {
            return $this->listarAbastecimentos();
        }else{
            return $this->listarPorPrefeitura(session('prefeitura_id'));
        }
    }

    public function listarAbastecimentos()
    {
        try {
            $token = session('jwt_token');
            $response = Http::withToken($token)->get($this->apiUrl);

            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::error("Erro ao listar abastecimentos: " . $e->getMessage());
            return null;
        }
    }

    public function listarPorPrefeitura($prefeituraId)
{
    try {
        $token = session('jwt_token');
        $response = Http::withToken($token)->get("{$this->apiUrl}/prefeitura/{$prefeituraId}");

        return $response->successful() ? $response->json() : null;
    } catch (\Exception $e) {
        Log::error("Erro ao listar abastecimentos da prefeitura {$prefeituraId}: " . $e->getMessage());
        return null;
    }
}


    public function atualizarAbastecimento($id, array $dados)
    {
        try {
            
            $token = session('jwt_token');
            $response = Http::withToken($token)->put("{$this->apiUrl}/{$id}", $dados);
            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::error("Erro ao atualizar abastecimento {$id}: " . $e->getMessage());
            return null;
        }
    }

    public function excluirAbastecimento($id)
    {
        try {
            $token = session('jwt_token');
            $response = Http::withToken($token)->delete("{$this->apiUrl}/{$id}");

            return $response->successful();
        } catch (\Exception $e) {
            Log::error("Erro ao excluir abastecimento {$id}: " . $e->getMessage());
            return false;
        }
    }

}
