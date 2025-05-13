<?php

namespace App\Http\Controllers;

use App\Services\SecretariaService;
use App\Services\PrefeituraService;
use App\Services\EnderecoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class SecretariasController extends Controller
{
    protected $secretariaService;


    public function __construct(SecretariaService $secretariaService, )
    {
        $this->secretariaService = $secretariaService;
    }

    public function index()
    {
        try {

            $secretarias = $this->secretariaService->getSecretarias();

            return view('secretaria.index', compact('secretarias'));
        } catch (\Exception $e) {
            Log::error('Erro ao listar secretarias: ' . $e->getMessage());
            return back()->with('error', 'Erro ao carregar as secretarias.');
        }
    }


    public function create()
    {
        try {
            return view('secretaria._form');
        } catch (\Exception $e) {
            Log::error('Erro ao carregar formulário de criação de secretaria: ' . $e->getMessage());
            return back()->with('error', 'Erro ao carregar o formulário.');
        }
    }


    public function store(Request $request)
{
    try {
        $dados = $request->validate([
            'nome' => [
                'required',
                'string',
                'regex:/^[a-zA-Z\s\p{L}]+$/u',  // Permite apenas letras e espaços, sem números
            ],
            'responsavel' => [
                'required',
                'string',
                'regex:/^[a-zA-Z\s\p{L}]+$/u',  // Permite apenas letras e espaços, sem números
            ],
        ],[
            'nome.regex' => 'O Nome deve conter apenas letras e espaços.',
            'responsavel.regex' => 'O Responsavel deve conter apenas letras e espaços.'
        ]
    );

        $dados['prefeitura_id'] = session('prefeitura_id');

        if ($dados['prefeitura_id'] == '99' || $dados['prefeitura_id'] == null) {
            return back()->with('error', 'Prefeitura não selecionada.');
        }
        
        $resultado = $this->secretariaService->cadastrarSecretaria($dados);

        if ($resultado) {
            return redirect()->route('secretarias.index')->with('success', 'Secretaria cadastrada com sucesso!');
        }

        return back()->with('error', 'Erro ao cadastrar secretaria.');

    } catch (ValidationException $e) {
        return redirect()->back()
        ->with('error', $e->getMessage())
        ->withInput();
    } catch (\Exception $e) {
        // Log de erro para erro inesperado
        Log::error('Erro ao cadastrar secretaria: ' . $e->getMessage());

        // Erro personalizado para erro genérico
        return back()->with('error', 'Erro inesperado ao cadastrar secretaria. Por favor, tente novamente mais tarde.');
    }
}




    public function edit($id, PrefeituraService $prefeituraService, EnderecoService $enderecoService)
    {
        try {
            $secretaria = $this->secretariaService->buscarSecretariaPorId($id);

            if (!$secretaria) {
                return redirect()->route('secretarias.index')->with('error', 'Secretaria não encontrada.');
            }

            return view('secretarias.edit', compact('secretaria', 'prefeituras', 'enderecos'));
        } catch (\Exception $e) {
            Log::error("Erro ao carregar formulário de edição da secretaria ID {$id}: " . $e->getMessage());
            return back()->with('error', 'Erro ao carregar o formulário de edição.');
        }
    }

    public function update(Request $request, $id)
    {
        try {

            $dados = $request->validate([
                'nome' => 'required|string',
                'responsavel' => 'required|string',
            ]);

            $dados['prefeitura_id'] = session('prefeitura_id');
            $resultado = $this->secretariaService->atualizarSecretaria($id, $dados);

            if ($resultado) {

                return redirect()->route('secretarias.index')->with('success', 'Secretaria atualizada com sucesso!');
            }

            return back()->with('error', 'Erro ao atualizar secretaria.');
        } catch (\Exception $e) {
            Log::error("Erro ao atualizar secretaria ID {$id}: " . $e->getMessage());
            return back()->with('error', 'Erro inesperado ao atualizar secretaria.');
        }
    }

    public function destroy($id)
    {
        try {
            $resultado = $this->secretariaService->excluirSecretaria($id);

            if ($resultado) {

                return redirect()->route('secretarias.index')->with('success', 'Secretaria excluída com sucesso!');
            }

            return redirect()->route('secretarias.index')->with('error', 'Erro ao excluir secretaria.');
        } catch (\Exception $e) {
            Log::error("Erro ao excluir secretaria ID {$id}: " . $e->getMessage());
            return redirect()->route('secretarias.index')->with('error', 'Erro inesperado ao excluir secretaria.');
        }
    }
}
