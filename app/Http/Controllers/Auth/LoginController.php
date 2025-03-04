<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $response = Http::post('https://gestao-api.dev.br:4000/api/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            $data = $response->json();

            // Armazena o token na sessão
            session(['jwt_token' => $data['token']]);

            // Cria ou busca o usuário localmente para gerenciar sessão no Laravel
            $user = \App\Models\User::firstOrCreate(
                ['email' => $request->email],
                ['name' => 'Usuário Externo']
            );

            Auth::login($user);

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['email' => 'Credenciais inválidas']);
    }

    public function logout()
    {
        $token = session('jwt_token');

        if ($token) {
            Http::withToken($token)->post('https://gestao-api.dev.br:4000/api/auth/logout');
        }

        Auth::logout();
        session()->forget('jwt_token');

        return redirect('/login');
    }
}