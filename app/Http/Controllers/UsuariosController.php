<?php

namespace App\Http\Controllers;

use App\Services\PrefeituraService;
use App\Services\UserService;
use App\Services\PostoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class UsuariosController extends Controller
{
    protected $userService;
    protected $prefeituraService;
    protected $postoService;

    public function __construct(UserService $userService, PrefeituraService $prefeituraService, PostoService $postoService)
    {
        $this->userService = $userService;
        $this->prefeituraService = $prefeituraService;
        $this->postoService = $postoService;
    }

    public function index()
    {
        try {
            $permissoes = Permission::all();
            $usuarios = $this->userService->getuser();

            return view('usuario.index', compact('usuarios', 'permissoes'));
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

    public function create()
    {
        $permissoes = Permission::all();
        $prefeituras = $this->prefeituraService->listarPrefeituras();
        $postos = $this->postoService->getPostos();
        return view('usuario.create', compact('permissoes', 'prefeituras', 'postos'));
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nome' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'password' => 'required|string|confirmed|min:4',
                'tipo_usuario' => 'required|integer',
                'prefeitura_id' => 'required|integer',
                'posto_id' => 'required_if:tipo_usuario,2|integer',
                'permissoes' => 'required|array',
                'permissoes.*' => 'string'
            ]);

            $validatedData['empresa_id'] = Auth::user()->empresa_id;
            $user = $this->userService->createUser($validatedData);

            if ($user) {
                
                return redirect()->route('usuarios.index')->with('success', 'Usuário criado com sucesso.');
            }

            return redirect()->back()->withInput()->withErrors('Erro ao criar usuário.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->withInput()->withErrors('Erro ao criar usuário: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {

            $dados = $request->validate([
                'nome' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'permissoes' => 'required|array',
                'permissoes.*' => 'string'
            ]);

            $dados['empresa_id'] = Auth::user()->empresa_id;
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
