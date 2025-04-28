<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Services\VeiculosService;
use App\Services\PrefeituraService;
use App\Services\EnderecoService;
use App\Services\SecretariaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\SecretariaController;


class VeiculosController extends Controller
{
    protected $veiculoService;
    protected $secretariaService;

    public function __construct(VeiculosService $veiculoService, SecretariaService $secretariaService)
    {
        $this->veiculoService = $veiculoService;
        $this->secretariaService = $secretariaService;
    }

    public function index()
    {
        try {
            $prefeituraId = session('prefeitura_id');
            $veiculos = $this->veiculoService->getVeiculos();
            $secretarias = $this->secretariaService->getSecretarias();
            return view('veiculo.index', compact('veiculos', 'secretarias'));
        } catch (\Exception $e) {
            Log::error('Erro ao listar veiculos: ' . $e->getMessage());
            return back()->with('error', 'Erro ao carregar as veiculos.');
        }
    } 

public function store(Request $request)
{
    try {
        $dados = $request->validate([
            'placa' => 'required|string',
            'modelo' => 'required|string',
            'ano' => 'required|string', 
            'quantidade_litros' => 'required|string', 
            'quantidade_abastecimentos' => 'required|string', 
            'limite_abastecimento_periodo' => 'required|string',
            'secretaria_id' => 'required|string',
        ]);
        $dados['quantidade_litros'] = (int) $dados['quantidade_litros'];
        $dados['quantidade_abastecimentos'] = (int) $dados['quantidade_abastecimentos'];
        $dados['secretaria_id'] = (int) $dados['secretaria_id'];
        $dados['limite_abastecimento_periodo'] = (int) $dados['limite_abastecimento_periodo'];
        $resultado = $this->veiculoService->cadastrarVeiculo($dados);

        if ($resultado) {
            return redirect()->route('veiculos.index')->with('success', 'Veiculo cadastrada com sucesso!');
        }

        return back()->with('error', 'Erro ao cadastrar veiculo.');
    } catch (\Exception $e) {
        Log::error('Erro ao cadastrar veiculo: ' . $e->getMessage());
        return back()->with('error', 'Erro inesperado ao cadastrar veiculo.');
    }
}

public function create(SecretariasController $secretariaController)
    {
        try {
            $secretarias = $secretariaController->listarSecretariasPorPrefeitura_id(session('prefeitura_id'));

            return view('veiculo._form', compact('secretarias'));
        } catch (\Exception $e) {
            Log::error('Erro ao carregar formulário de criação de veiculo: ' . $e->getMessage());
            return back()->with('error', 'Erro ao carregar o formulário.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            
            $dados = $request->validate([
                'modelo' => 'required|string',
                'ano' => 'required|string', 
                'quantidade_litros' => 'required|string', 
                'quantidade_abastecimentos' => 'required|string', 
                'limite_abastecimento_periodo' => 'required|string',
                'secretaria_id' => 'required|string',
            ]);
            
            $resultado = $this->veiculoService->atualizarVeiculo($id, $dados);

            if ($resultado) {
                return redirect()->route('veiculos.index')->with('success', 'Veiculo atualizada com sucesso!');
            }
            
            return back()->with('error', 'Erro ao atualizar veiculo.');
        } catch (\Exception $e) {
            Log::error("Erro ao atualizar veiculo ID {$id}: " . $e->getMessage());
            return back()->with('error', 'Erro inesperado ao atualizar veiculo.');
        }
    }

    public function destroy($id)
    {
        try {
            $resultado = $this->veiculoService->excluirVeiculo($id);

            if ($resultado) {
                return redirect()->route('veiculos.index')->with('success', 'Veiculo excluída com sucesso!');
            }

            return redirect()->route('veiculos.index')->with('error', 'Erro ao excluir veiculo.');
        } catch (\Exception $e) {
            Log::error("Erro ao excluir veiculo ID {$id}: " . $e->getMessage());
            return redirect()->route('veiculos.index')->with('error', 'Erro inesperado ao excluir veiculo.');
        }
    }
}
