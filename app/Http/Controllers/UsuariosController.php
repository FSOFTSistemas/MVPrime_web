<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class UsuariosController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        try {
            $permissoes = Permission::all();
            $usuarios = $this->userService->getUsersByPrefeitura(1);


            if ($usuarios) {
                return view('usuario.index', compact('usuarios','permissoes'));
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->withErrors('Não foi possível carregar os usuários.');
        }
    }

    public function show($id)
    {
        $user = $this->userService->getUserById($id);

        if ($user) {
            return view('usuario.show', compact('user'));
        }

        return redirect()->back()->withErrors('Usuário não encontrado.');
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nome' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'password' => 'required|string',
                'empresa_id' => 'nullable|integer',
                'prefeitura_id' => 'nullable|integer',
                'posto_id' => 'nullable|integer',
                'permissoes' => 'required|array',
                'permissoes.*' => 'integer'
            ]);
            

            $user = $this->userService->createUser($validatedData);
  
            if ($user) {
                return redirect()->route('usuarios.index')->with('success', 'Usuário criado com sucesso.');
            }

            return redirect()->back()->withErrors('Erro ao criar usuário.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->withErrors('Erro ao criar usuário: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            dd($request->all());
            $dados = $request->validate([
                'nome' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'empresa_id' => 'nullable|integer',
                'prefeitura_id' => 'nullable|integer',
                'posto_id' => 'nullable|integer',
                'permissoes' => 'required|array',
                'permissoes.*' => 'integer'
            ]);

            $usuarioAtualizado = $this->userService->updateUser($id, $dados);

            if ($usuarioAtualizado) {
                return redirect()->route('usuarios.index')->with('success', 'Usuário atualizado com sucesso.');
            }

            return redirect()->back()->withErrors('Erro ao atualizar usuário.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->withErrors('Erro ao atualizar usuário: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $deleted = $this->userService->deleteUser($id);

            if ($deleted) {
                return redirect()->route('usuarios.index')->with('success', 'Usuário excluído com sucesso.');
            }

            return redirect()->back()->withErrors('Erro ao excluir usuário.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Erro ao excluir usuário: ' . $e->getMessage());
        }
    }
}
