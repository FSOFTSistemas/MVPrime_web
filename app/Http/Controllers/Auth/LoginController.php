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
use App\Services\UserService;

class LoginController extends Controller
{
    protected $prefeituraService;
    protected $userService;

    // Injeção de dependência do PrefeituraService no construtor
    public function __construct(PrefeituraService $prefeituraService, UserService $userService)
    {
        $this->prefeituraService = $prefeituraService; // Atribui o serviço à variável da classe
        $this->userService = $userService;
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
                    'empresa_id' => $data['usuario']['empresa_id'],
                    'tipo_usuario' => $data['usuario']['tipo_usuario']
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

            $userData = $this->userService->getUserById($data['usuario']['id']);

            $prefeituraUser = $userData['prefeitura_id'];

            if(isset($prefeituraUser)){
                Session::put('prefeitura_id', $prefeituraUser);
            }

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
    // Pega o token JWT da sessão
    $token = session('jwt_token');

    // Verifica se o token existe antes de chamar a API para invalidar
    if ($token) {
        try {
            // Chama a API para invalidar o token de autenticação
            Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post('https://gestao-api.dev.br:4000/api/auth/logout');
        } catch (\Exception $e) {
            // Caso ocorra um erro ao tentar invalidar o token na API, registra o erro
            \Log::error('Erro ao invalidar o token na API de logout: ' . $e->getMessage());
        }
    }

    // Faz o logout no Laravel
    Auth::logout();

    // Limpar os dados da sessão
    session()->forget(['jwt_token', 'user_id', 'prefeituras', 'prefeitura_id']); // Remove tokens e outras variáveis da sessão
    session()->flush(); // Limpa toda a sessão

    // Redireciona para a página de login ou outra página inicial
    return redirect()->route('login');
}

}
