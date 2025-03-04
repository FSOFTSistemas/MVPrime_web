<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Spatie\Permission\Models\Permission; // Importando o modelo de permissão do Spatie

class LoginController extends Controller
{
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
                ['name' => $data['usuario']['nome']]
            );

            // 🔹 Criar as permissões no banco de dados, se não existirem
            foreach ($data['usuario']['permissoes'] as $permission) {
                Permission::firstOrCreate(['name' => $permission]); // Cria a permissão se não existir
            }

            // 🔹 Verificar se o usuário já tem as permissões e atribuí-las apenas se necessário
            $userPermissions = $user->permissions->pluck('name')->toArray(); // Obtém as permissões atuais do usuário

            foreach ($data['usuario']['permissoes'] as $permission) {
                if (!in_array($permission, $userPermissions)) {
                    $user->givePermissionTo($permission); // Apenas adiciona se ainda não tiver
                }
            }

            // Armazenar o ID do usuário na sessão
            Session::put('user_id', $user->id);

            return redirect()->route('home');
        } else {
            return back()->withErrors(['email' => 'Credenciais inválidas.']);
        }
    }

    public function showLoginForm()
    {
        return view('vendor.adminlte.auth.login');
    }
}