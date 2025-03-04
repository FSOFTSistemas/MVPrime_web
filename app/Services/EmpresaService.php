<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class EmpresaService
{
    private $client;
    private $url = 'https://gestao-api.dev.br:4000/api/login';

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}