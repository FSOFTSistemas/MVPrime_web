<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AbastecimentoService
{
    protected $apiUrl = 'https://gestao-api.dev.br:4000/api/abastecimentos';


    public function getAbastecimentos($page, $limit, $listAll = null)
    {
        if(session('prefeitura_id') == 99 || !session('prefeitura_id'))
        {       
            return $this->listarAbastecimentos($page, $limit);
        }else{
            return $this->listarPorPrefeitura(session('prefeitura_id'), $page, $limit, $listAll);
        }
    }

    public function listarAbastecimentos($page, $limit)
    {
        try {
            $token = session('jwt_token');
            $response = Http::withToken($token)->get($this->apiUrl, [ 'page' => $page, 'limit' => $limit ]);

            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::error("Erro ao listar abastecimentos: " . $e->getMessage());
            return null;
        }
    }

    public function listarPorPrefeitura($prefeituraId, $page, $limit, $listAll)
{
    try {
        $token = session('jwt_token');
        $response = Http::withToken($token)->get("{$this->apiUrl}/prefeitura/{$prefeituraId}", [ 'page' => $page, 'limit' => $limit, 'listAll' => $listAll ]);

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

    public function listarPorPosto($postoId)
    {
        try {
            $token = session('jwt_token');
            $response = Http::withToken($token)->get("{$this->apiUrl}/posto/{$postoId}");

            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::error("Erro ao listar abastecimentos do posto {$postoId}: " . $e->getMessage());
            return null;
        }
    }

}
