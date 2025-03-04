<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class AuthService
{
    protected $client;
    protected $apiUrl = 'https://gestao-api.dev.br:4000/api/login';

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function login($email, $password)
    {
        try {
            $response = $this->client->post($this->apiUrl, [
                'json' => [
                    'email' => $email,
                    'password' => $password
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            
            // Retorne o token JWT
            return $data['token'];
        } catch (RequestException $e) {
            // Tratar exceções de erro na requisição
            return null;
        }
    }
}