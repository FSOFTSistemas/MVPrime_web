<?php

namespace App\Http\Controllers;

use App\Services\PrefeituraService;
use App\Services\UserService;
use App\Services\PostoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

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
                'prefeitura_id' => [
                    'required_unless:tipo_usuario,1',
                    'integer',
                    function ($attribute, $value, $fail) use ($request) {
                        if (($request->input('tipo_usuario') == 3 ||$request->input('tipo_usuario') == 2) && $value == 99) {
                            $fail('Nenhuma prefeitura selecionada no seletor de prefeitura.');
                        }
                    },
                ],
                'posto_id' => 'required_if:tipo_usuario,2|integer',
                'id_cartao' => 'string|max:30|nullable',
                'permissoes' => 'required|array',
                
            ],
            [
                'nome.required' => 'O campo nome é obrigatório.',
                'nome.string' => 'O campo nome deve ser uma string.',
                'nome.max' => 'O campo nome não pode ter mais que 255 caracteres.',

                'email.required' => 'O campo e-mail é obrigatório.',
                'email.email' => 'O campo e-mail deve conter um endereço de e-mail válido.',
                'email.max' => 'O campo e-mail não pode ter mais que 255 caracteres.',

                'password.required' => 'O campo senha é obrigatório.',
                'password.string' => 'O campo senha deve ser uma string.',
                'password.confirmed' => 'O campo senha e sua confirmação não coincidem.',
                'password.min' => 'O campo senha deve ter no mínimo 4 caracteres.',

                'tipo_usuario.required' => 'O campo tipo de usuário é obrigatório.',
                'tipo_usuario.integer' => 'O campo tipo de usuário deve ser um número inteiro.',

                'prefeitura_id.required_unless' => 'O campo prefeitura é obrigatório para este tipo de usuário.',
                'prefeitura_id.integer' => 'O campo prefeitura deve ser um número inteiro.',

                'posto_id.required_if' => 'O campo posto é obrigatório para este tipo de usuário.',
                'posto_id.integer' => 'O campo posto deve ser um número inteiro.',

                'id_cartao.string' => 'O campo ID do cartão deve ser uma string.',
                'id_cartao.max' => 'O campo ID do cartão não pode ter mais que 30 caracteres.',

                'permissoes.required' => 'O campo permissões é obrigatório.',
                'permissoes.array' => 'O campo permissões deve ser um array.',
            ]);
            
            if($validatedData['tipo_usuario'] == 1) { //se usuario master => prefeitura_id é null
                $validatedData['prefeitura_id'] = null;
            }
            
            $validatedData['empresa_id'] = Auth::user()->empresa_id;
            $user = $this->userService->createUser($validatedData);

            if ($user) {
                
                return redirect()->route('usuarios.index')->with('success', 'Usuário criado com sucesso.');
            }

            return redirect()->back()->withInput()->withErrors('Erro ao criar usuário.');
        } catch (ValidationException $e) {
            Log::error('Erro de validação ao cadastrar veiculo: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Erro de validação: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors('Erro ao criar usuário: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {

            $dados = $request->validate([
                'nome' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'id_cartao' => 'string|max:30',
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
