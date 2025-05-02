<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HomeService
{
  protected $apiUrl = 'https://gestao-api.dev.br:4000/api/';

  protected $prefeituraService;

    public function __construct(PrefeituraService $prefeituraService)
    {
        $this->prefeituraService = $prefeituraService;
    }

    public function prefeiturasPorEmpresa($empresa_id)
    {
        return $this->prefeituraService->prefeiturasPorEmpresa_id($empresa_id);
    }


  public function listarAbastecimentosMes()
  {
      try {
          $token = session('jwt_token');
          $response = Http::withToken($token)->get("{$this->apiUrl}/abastecimentos_mes");

          return $response->successful() ? $response->json() : null;
      } catch (\Exception $e) {
          Log::error("Erro ao listar abastecimentos: " . $e->getMessage());
          return null;
      }
  }
  public function listarAbastecimentosDia()
  {
      try {
          $token = session('jwt_token');
          $response = Http::withToken($token)->get("{$this->apiUrl}/abastecimentos_dia");

          return $response->successful() ? $response->json() : null;
      } catch (\Exception $e) {
          Log::error("Erro ao listar abastecimentos: " . $e->getMessage());
          return null;
      }
  }
  public function listarAbastecimentosPrefeitura()
  {
      try {
          $token = session('jwt_token');
          $response = Http::withToken($token)->get("{$this->apiUrl}/abastecimentos_prefeitura_mes");

          return $response->successful() ? $response->json() : null;
      } catch (\Exception $e) {
          Log::error("Erro ao listar abastecimentos: " . $e->getMessage());
          return null;
      }
  }
  public function listarAbastecimentosPrefeituraMes()
  {
      try {
          $token = session('jwt_token');
          $response = Http::withToken($token)->get("{$this->apiUrl}/abastecimentos_pref_mes");

          return $response->successful() ? $response->json() : null;
      } catch (\Exception $e) {
          Log::error("Erro ao listar abastecimentos: " . $e->getMessage());
          return null;
      }
  }
  public function listarAbastecimentosPrefeituraDia()
  {
      try {
          $token = session('jwt_token');
          $response = Http::withToken($token)->get("{$this->apiUrl}/abastecimentos_pref_dia");

          return $response->successful() ? $response->json() : null;
      } catch (\Exception $e) {
          Log::error("Erro ao listar abastecimentos: " . $e->getMessage());
          return null;
      }
  }
  public function listarAbastecimentosPostoDia()
  {
      try {
          $token = session('jwt_token');
          $response = Http::withToken($token)->get("{$this->apiUrl}/abastecimentos_posto_dia");

          return $response->successful() ? $response->json() : null;
      } catch (\Exception $e) {
          Log::error("Erro ao listar abastecimentos: " . $e->getMessage());
          return null;
      }
  }
  public function listarAbastecimentosPostoMes()
  {
      try {
          $token = session('jwt_token');
          $response = Http::withToken($token)->get("{$this->apiUrl}/abastecimentos_posto_mes");

          return $response->successful() ? $response->json() : null;
      } catch (\Exception $e) {
          Log::error("Erro ao listar abastecimentos: " . $e->getMessage());
          return null;
      }
  }

  public function listarMaster($empresa_id)
  {
    try {
        $token = session('jwt_token');
        $response = Http::withToken($token)->get("{$this->apiUrl}/cads_empresa/{$empresa_id}");

        return $response->successful() ? $response->json() : null;
    } catch (\Exception $e) {
        Log::error("Erro ao listar abastecimentos do Master: " . $e->getMessage());
        return null;
    }
  }

}
