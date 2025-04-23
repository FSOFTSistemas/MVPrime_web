<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Prefeitura; // Importando o modelo Prefeitura
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission; // Importando o modelo de permissão do Spatie
use App\Services\PrefeituraService;

class LoginController extends Controller
{
    protected $prefeituraService;

    // Injeção de dependência do PrefeituraService no construtor
    public function __construct(PrefeituraService $prefeituraService)
    {
        $this->prefeituraService = $prefeituraService; // Atribui o serviço à variável da classe
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $response = Http::post('https://gestao-api.dev.br:4000/api/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            $data = $response->json();

            // Armazenar o token JWT na sessão
            Session::put('jwt_token', $data['token']);

            // Criar ou atualizar o usuário no banco de dados
            $user = User::updateOrCreate(
                ['email' => $data['usuario']['email']],
                [
                    'name' => $data['usuario']['nome'],
                    'empresa_id' => $data['usuario']['empresa_id']
                ]
            );

            // Criar as permissões no banco de dados, se não existirem
            foreach ($data['usuario']['permissoes'] as $permission) {
                Permission::firstOrCreate(['name' => $permission]); // Cria a permissão se não existir
            }

            // Verificar se o usuário já tem as permissões e atribuí-las apenas se necessário
            $userPermissions = $user->permissions->pluck('name')->toArray(); // Obtém as permissões atuais do usuário

            foreach ($data['usuario']['permissoes'] as $permission) {
                if (!in_array($permission, $userPermissions)) {
                    $user->givePermissionTo($permission); // Apenas adiciona se ainda não tiver
                }
            }

            // Armazenar o ID do usuário na sessão
            Session::put('user_id', $user->id);

            // 🔹 Buscar as prefeituras relacionadas ao 'empresa_id' do usuário
            $prefeituras = $this->prefeituraService->prefeiturasPorEmpresa_id($user->empresa_id);
            
            // Armazenar as prefeituras na sessão
            Session::put('prefeituras', $prefeituras);

            // Faz login do usuário no Laravel
            Auth::login($user);

            return redirect()->route('home');
        } else {
            return back()->withErrors(['email' => 'Credenciais inválidas.']);
        }
    }

    public function showLoginForm()
    {
        return view('vendor.adminlte.auth.login');
    }

    public function logout(Request $request)
    {
        // Chamar a API para invalidar o token
        $token = session('jwt_token'); // Pega o token da sessão

        if ($token) {
            Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post('https://gestao-api.dev.br:4000/api/auth/logout');
        }

        // Limpar sessão e deslogar usuário
        Auth::logout();
        session()->forget(['jwt_token', 'user_id']);
        session()->flush(); // Remove toda a sessão

        return redirect()->route('start');
    }
}
