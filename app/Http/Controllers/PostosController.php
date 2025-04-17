<?php

namespace App\Http\Controllers;

use App\Services\PostoService;
use App\Services\PrefeituraService;
use App\Services\EnderecoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PostosController extends Controller
{
    protected $postoService;
    protected $enderecoService;

    public function __construct(PostoService $postoService, EnderecoService $enderecoService)
    {
        $this->postoService = $postoService;
        $this->enderecoService = $enderecoService;
    }

    public function index()
    {
        try {
            $postos = $this->postoService->listarPostosPorPrefeitura(1);
            $enderecos = $this->enderecoService->listarEnderecos();
            return view('posto.index', compact('postos', 'enderecos'));
        } catch (\Exception $e) {
            Log::error('Erro ao listar postos: ' . $e->getMessage());
            return back()->with('error', 'Erro ao carregar as postos.');
        }
    }

    public function create(PrefeituraService $prefeiturasService, EnderecoService $enderecoService)
    {
        try {
            $prefeituras = $prefeiturasService->listarPrefeituras();
            $enderecos = $enderecoService->listarEnderecos();

            return view('posto._form', compact('prefeituras', 'enderecos'));
        } catch (\Exception $e) {
            Log::error('Erro ao carregar formulário de criação de posto: ' . $e->getMessage());
            return back()->with('error', 'Erro ao carregar o formulário.');
        }
    }

    public function store(Request $request)
    {
        try {
            $dados = $request->validate([
                'cnpj' => 'required|string',
                'nome' => 'required|string',
                'responsavel' => 'required|string',
                'endereco_id' => 'required|integer',
                'prefeitura_id' => 'required|integer'
            ]);

            $resultado = $this->postoService->cadastrarPosto($dados);

            if ($resultado) {
                return redirect()->route('postos.index')->with('success', 'Posto cadastrada com sucesso!');
            }

            return back()->with('error', 'Erro ao cadastrar posto.');
        } catch (\Exception $e) {
            Log::error('Erro ao cadastrar posto: ' . $e->getMessage());
            return back()->with('error', 'Erro inesperado ao cadastrar posto.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
        
            $dados = $request->validate([
                'cnpj' => 'required|string',
                'nome' => 'required|string',
                'responsavel' => 'required|string',
                'endereco_id' => 'required|integer',
            ]);
            
            $dados['prefeituras_id'] = Auth::user()->prefeituras_id;
            $resultado = $this->postoService->atualizarPosto($id, $dados);

            if ($resultado) {
                return redirect()->route('postos.index')->with('success', 'Posto atualizada com sucesso!');
            }

            return back()->with('error', 'Erro ao atualizar posto.');
        } catch (\Exception $e) {
            Log::error("Erro ao atualizar posto ID {$id}: " . $e->getMessage());
            return back()->with('error', 'Erro inesperado ao atualizar posto.');
        }
    }

    public function destroy($id)
    {
        try {
            $resultado = $this->postoService->excluirPosto($id);

            if ($resultado) {
                return redirect()->route('postos.index')->with('success', 'Posto excluída com sucesso!');
            }

            return redirect()->route('postos.index')->with('error', 'Erro ao excluir posto.');
        } catch (\Exception $e) {
            Log::error("Erro ao excluir posto ID {$id}: " . $e->getMessage());
            return redirect()->route('postos.index')->with('error', 'Erro inesperado ao excluir posto.');
        }
    }
}
