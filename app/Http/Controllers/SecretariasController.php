<?php

namespace App\Http\Controllers;

use App\Services\SecretariaService;
use App\Services\PrefeituraService;
use App\Services\EnderecoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
                'nome' => 'required|string',
                'responsavel' => 'required|string',
            ]);
            
            
            $dados['prefeitura_id'] = session('prefeitura_id');
            $resultado = $this->secretariaService->cadastrarSecretaria($dados);
            
            if ($resultado) {
                return redirect()->route('secretarias.index')->with('success', 'Secretaria cadastrada com sucesso!');
            }

            return back()->with('error', 'Erro ao cadastrar secretaria.');
        } catch (\Exception $e) {
            Log::error('Erro ao cadastrar secretaria: ' . $e->getMessage());
            return back()->with('error', 'Erro inesperado ao cadastrar secretaria.');
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
            
            $dados['prefeitura_id'] = 1;
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
