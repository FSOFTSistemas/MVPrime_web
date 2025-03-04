<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    protected $userService;

    // Injeção de dependência
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // Método para mostrar todos os usuários
    public function index()
    {
        try {
            $usuarios = $this->userService->getAllUsers();

    
            if ($usuarios) {
                return view('usuario.index', compact('usuarios'));
            }

        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->withErrors('Não foi possível carregar os usuários.');
        }

    }

    // Método para mostrar um usuário específico
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
        //code
    }

    public function update(Request $request, $id)
    {
        //code
    }

    public function destroy($id)
    {
        //code
    }
}