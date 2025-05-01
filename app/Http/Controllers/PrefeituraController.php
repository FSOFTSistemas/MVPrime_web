<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use App\Services\PrefeituraService;
use App\Services\EmpresaService;
use App\Services\EnderecoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use SweetAlert2\Laravel\Swal;



class PrefeituraController extends Controller
{
    protected $prefeituraService;
    protected $enderecoService;

    public function __construct(PrefeituraService $prefeituraService, EnderecoService $enderecoService)
    {
        $this->prefeituraService = $prefeituraService;
        $this->enderecoService = $enderecoService;
    }

    public function index()
    {
        try {
            $prefeituras = $this->prefeituraService->getPrefeituras();
            $enderecos = $this->enderecoService->listarEnderecos();
                return view('prefeitura.index', compact('prefeituras', 'enderecos'));
        } catch (\Exception $e) {
            Log::error('Erro ao listar prefeituras: ' . $e->getMessage());
            return back()->with('error', 'Erro ao carregar as prefeituras.');
        }
    }

    public function litarPrefeiturasPorEmpresa_id($empresa_id)
    {
        try {
            $prefeituras = $this->prefeituraService->prefeiturasPorEmpresa_id($empresa_id);
            View::share('prefeituras', $prefeituras);
            return $prefeituras;
        } catch (\Exception $e) {
            Log::error('Erro ao listar prefeituras por id: ' . $e->getMessage());
            return back()->with('error', 'Erro ao carregar as prefeituras.');
        }
    }

    public function create(EmpresaService $empresaService, EnderecoService $enderecoService)
    {
        try {
            $empresas = $empresaService->listarEmpresas();
            $enderecos = $enderecoService->listarEnderecos();

            return view('prefeitura._form', compact('empresas', 'enderecos'));
        } catch (\Exception $e) {
            Log::error('Erro ao carregar formulário de criação de prefeitura: ' . $e->getMessage());
            return back()->with('error', 'Erro ao carregar o formulário.');
        }
    }

    public function store(Request $request)
    {
        try {
            $dados = $request->validate([
                'cnpj' => 'required|string',
                'razao_social' => 'required|string',
                'responsavel' => 'required|string',
                'endereco_id' => 'required|integer',
            ]);


            $dados['empresa_id'] = Auth::user()->empresa_id;
            $resultado = $this->prefeituraService->cadastrarPrefeitura($dados);

            if ($resultado) {
                Swal::fire([
                    'title' => 'Sucesso !',
                    'text' => 'Prefeitura cadastrada com sucesso!',
                    'icon' => 'success',
                    'confirmButtonText' => 'OK'
                ]);
                return redirect()->route('prefeituras.index')->with('success', 'Prefeitura cadastrada com sucesso!');
            }

            return back()->with('error', 'Erro ao cadastrar prefeitura.');
        } catch (\Exception $e) {
            Log::error('Erro ao cadastrar prefeitura: ' . $e->getMessage());
            return back()->with('error', 'Erro inesperado ao cadastrar prefeitura.');
        }
    }

    public function edit($id, EmpresaService $empresaService, EnderecoService $enderecoService)
    {
        try {
            $prefeitura = $this->prefeituraService->buscarPrefeituraPorId($id);
            $empresas = $empresaService->listarEmpresas();
            $enderecos = $enderecoService->listarEnderecos();

            if (!$prefeitura) {
                return redirect()->route('prefeituras.index')->with('error', 'Prefeitura não encontrada.');
            }

            return view('prefeituras.edit', compact('prefeitura', 'empresas', 'enderecos'));
        } catch (\Exception $e) {
            Log::error("Erro ao carregar formulário de edição da prefeitura ID {$id}: " . $e->getMessage());
            return back()->with('error', 'Erro ao carregar o formulário de edição.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
        
            $dados = $request->validate([
                'cnpj' => 'required|string',
                'razao_social' => 'required|string',
                'responsavel' => 'required|string',
                'endereco_id' => 'required|integer',
            ]);
            
            $dados['empresa_id'] = Auth::user()->empresa_id;
            $resultado = $this->prefeituraService->atualizarPrefeitura($id, $dados);

            if ($resultado) {

                Swal::fire([
                    'title' => 'Sucesso !',
                    'text' => 'Prefeitura atualizada com sucesso!',
                    'icon' => 'success',
                    'confirmButtonText' => 'OK'
                ]);
                return redirect()->route('prefeituras.index')->with('success', 'Prefeitura atualizada com sucesso!');
            }

            return back()->with('error', 'Erro ao atualizar prefeitura.');
        } catch (\Exception $e) {
            Log::error("Erro ao atualizar prefeitura ID {$id}: " . $e->getMessage());
            return back()->with('error', 'Erro inesperado ao atualizar prefeitura.');
        }
    }

    public function filtroPrefeitura(Request $request)
    {
        // Recupera o ID da prefeitura selecionada
        $prefeituraId = $request->input('prefeitura_id');
        

        // Atualiza a sessão com a prefeitura selecionada
        if ($prefeituraId) {
            Session::put('prefeitura_id', $prefeituraId);
        }

        // Redireciona de volta para a página com os dados filtrados
        return redirect()->back();
    }

    public function destroy($id)
{
    try {
        $response = $this->prefeituraService->excluirPrefeitura($id);

        if ($response && $response->successful()) {
            Swal::fire([
                'title' => 'Sucesso !',
                'text' => 'Prefeitura excluída com sucesso!',
                'icon' => 'success',
                'confirmButtonText' => 'OK'
            ]);
            return redirect()->route('prefeituras.index')->with('success', 'Prefeitura excluída com sucesso!');
        }

        // Se houver erro conhecido na resposta:
        $erro = $response ? ($response->json()['error'] ?? 'Erro desconhecido ao excluir.') : 'Erro na requisição';

        Swal::fire([
            'title' => 'Erro !',
            'text' => $erro,
            'icon' => 'error',
            'confirmButtonText' => 'OK'
        ]);

        return redirect()->route('prefeituras.index')->with('error', $erro);
    } catch (\Exception $e) {
        Log::error("Erro ao excluir prefeitura ID {$id}: " . $e->getMessage());
        return redirect()->route('prefeituras.index')->with('error', 'Erro inesperado ao excluir prefeitura.');
    }
}

}
