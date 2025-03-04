<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = session('jwt_token');

        if (!$token) {
            return redirect('/login');
        }

        $response = Http::withToken($token)->get('https://gestao-api.dev.br:4000/api/validate');

        if (!$response->successful()) {
            session()->forget('jwt_token');
            return redirect('/login');
        }

        return $next($request);
    }
}