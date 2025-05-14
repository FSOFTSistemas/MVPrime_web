<?php

namespace App\Http\Controllers;

use App\Services\PostoService;
use App\Services\PrefeituraService;
use App\Services\EnderecoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Services\AbastecimentoService;

class PostosController extends Controller
{
    protected $postoService;
    protected $enderecoService;

    public function __construct(PostoService $postoService, EnderecoService $enderecoService, AbastecimentoService $abastecimentoService)
    {
        $this->postoService = $postoService;
        $this->enderecoService = $enderecoService;
        $this->abastecimentoService = $abastecimentoService;
    }

    public function index()
    {
        try {

            $postos = $this->postoService->getPostos();
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
            $prefeituras = $prefeiturasService->prefeiturasPorEmpresa_id(Auth::user()->empresa_id);
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
            $prefeitura_id = session('prefeitura_id');
            $dados = $request->validate([
                'cnpj' => 'required|string',
                'nome' => ['required', 'regex:/^[A-Za-zÀ-ÿ\s]+$/u'],
                'responsavel' => 'required|string',
                'endereco_id' => 'required|integer',
            ], [
                'nome.required' => 'O campo Nome é obrigatório.',
                'nome.regex' => 'O Nome deve conter apenas letras e espaços.',
            ]);
            $dados['prefeitura_id'] = $prefeitura_id;



            $resultado = $this->postoService->cadastrarPosto($dados);

            if ($resultado) {
                return redirect()->route('postos.index')->with('success', 'Posto cadastrada com sucesso!');
            }

            return back()->with('error', 'Erro ao cadastrar posto.');

        } catch (ValidationException $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
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

            $dados['prefeituras_id'] = session('prefeitura_id');;
            $resultado = $this->postoService->atualizarPosto($id, $dados);

            if ($resultado && $resultado->successful()) {

                return redirect()->route('postos.index')->with('success', 'Posto atualizado com sucesso!');
            }

            return back()->with('error', $resultado ? $resultado->status() : 500);
        } catch (\Exception $e) {
            Log::error("Erro ao atualizar posto ID {$id}: " . $e->getMessage());
            return back()->with('error', 'Erro inesperado ao atualizar posto.');
        }
    }

    public function destroy($id)
    {
        try {
            $abastecimentos = $this->abastecimentoService->listarPorPosto($id);
            if($abastecimentos) {
                throw new \Exception('Não é possível excluir o posto: existem abastecimentos vinculados.');
            }

            $resultado = $this->postoService->excluirPosto($id);

            if ($resultado) {

                return redirect()->route('postos.index')->with('success', 'Posto excluída com sucesso!');
            }

            return redirect()->route('postos.index')->with('error', 'Erro ao excluir posto.');
        } catch (\Exception $e) {
            Log::error("Erro ao excluir posto ID {$id}: " . $e->getMessage());
            return redirect()->route('postos.index')->with('error', $e->getMessage());
        }
    }
}
