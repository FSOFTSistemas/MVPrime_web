<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $token = $this->authService->login($validated['email'], $validated['password']);

        if ($token) {
            // Armazene o token no Laravel (pode ser em uma sessão, ou como quiser)
            session(['api_token' => $token]);

            return redirect()->route('home');  // Ou para a tela que preferir
        }

        return back()->withErrors(['error' => 'Falha ao fazer login']);
    }
}