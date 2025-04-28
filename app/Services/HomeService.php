<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HomeService
{
  protected $apiUrl = 'https://gestao-api.dev.br:4000/api/';

  public function listarAbastecimentos()
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

}
