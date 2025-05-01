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
use App\Http\Controllers\SecretariasController;
use SweetAlert2\Laravel\Swal;


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

            $veiculos = $this->veiculoService->getVeiculos();
            $secretarias = $this->secretariaService->getSecretarias();
            return view('veiculo.index', compact('veiculos', 'secretarias'));
        } catch (\Exception $e) {
            Log::error('Erro ao listar veículos: ' . $e->getMessage());
            return back()->with('error', 'Erro ao carregar as veículos.');
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
            Swal::fire([
                'title' => 'Sucesso !',
                'text' => 'Veículo cadastrado com sucesso!',
                'icon' => 'success',
                'confirmButtonText' => 'OK'
            ]);
            return redirect()->route('veiculos.index')->with('success', 'Veículo cadastrado com sucesso!');
        }

        return back()->with('error', 'Erro ao cadastrar veiculo.');
    } catch (\Exception $e) {
        Log::error('Erro ao cadastrar veiculo: ' . $e->getMessage());
        return back()->with('error', 'Erro inesperado ao cadastrar veiculo.');
    }
}

    public function create(SecretariaService $secretariaService)
    {
        try {
            $secretarias = $secretariaService->getSecretarias();
            return view('veiculo._form', compact('secretarias'));
        } catch (\Exception $e) {
            Log::error('Erro ao carregar formulário de criação de veículo: ' . $e->getMessage());
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
                Swal::fire([
                    'title' => 'Sucesso !',
                    'text' => 'Veículo atualizado com sucesso!',
                    'icon' => 'success',
                    'confirmButtonText' => 'OK'
                ]);
                return redirect()->route('veiculos.index')->with('success', 'Veículo atualizada com sucesso!');
            }
            
            return back()->with('error', 'Erro ao atualizar veículo.');
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

                Swal::fire([
                    'title' => 'Sucesso !',
                    'text' => 'Veículo excluído com sucesso!',
                    'icon' => 'success',
                    'confirmButtonText' => 'OK'
                ]);

                return redirect()->route('veiculos.index')->with('success', 'Veiculo excluída com sucesso!');
            }

            return redirect()->route('veiculos.index')->with('error', 'Erro ao excluir veiculo.');
        } catch (\Exception $e) {
            Log::error("Erro ao excluir veiculo ID {$id}: " . $e->getMessage());
            return redirect()->route('veiculos.index')->with('error', 'Erro inesperado ao excluir veiculo.');
        }
    }
}
