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
use Illuminate\Validation\ValidationException;

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

    public function edit($id)
    {
        $veiculo = $this->veiculoService->buscarVeiculoPorId($id);
        $secretarias = $this->secretariaService->getSecretarias();
        return view('veiculo.edit', compact('veiculo', 'secretarias'));
    }

    public function store(Request $request)
    {
        try {
            $anoAtual = now()->year;
            $anoMinimo = $anoAtual - 60;
            $anoMaximo = $anoAtual + 1;

            $dados = $request->validate(
                [
                    'placa' => ['required', 'regex:/^[A-Z]{3}[0-9][A-Z0-9][0-9]{2}$/i'], // formato Mercosul ou ABC1234
                    'modelo' => ['required', 'regex:/^[a-zA-Z0-9\s\p{L}]+$/u'] ,
                    'ano' => ['required', 'digits:4', "integer", "between:$anoMinimo,$anoMaximo"],
                    'quantidade_litros' => 'required|string',
                    'quantidade_abastecimentos' => 'required|string',
                    'limite_abastecimento_periodo' => 'required|string',
                    'secretarias_ids' => 'required|array',
                ],
                [
                    'placa.regex' => 'O campo Placa deve seguir o formato Mercosul (ABC1A23) ou antigo (ABC1234).',
                    'modelo.required' => 'O campo Modelo é obrigatório.',
                    'ano.required' => 'O campo Ano é obrigatório.',
                    'ano.digits' => 'O campo Ano deve conter 4 dígitos.',
                    'ano.between' => 'O Ano deve estar entre '.$anoMinimo. ' e '. $anoMaximo,
                    'quantidade_litros.required' => 'O campo Quantidade de Litros é obrigatório.',
                    'quantidade_abastecimentos.required' => 'O campo Quantidade de Abastecimentos é obrigatório.',
                    'limite_abastecimento_periodo.required' => 'O campo Limite de Abastecimento por Período é obrigatório.',
                    'secretarias_ids.required' => 'O campo Secretaria é obrigatório.',
                    'placa.required' => 'O campo Placa é obrigatório.',
                    'modelo.string' => 'O campo Modelo deve ser uma string.',
                    'modelo.regex' => 'O campo Modelo não pode ser apenas caracteres.'
                ]
            );
            $dados['quantidade_litros'] = (int) $dados['quantidade_litros'];
            $dados['quantidade_abastecimentos'] = (int) $dados['quantidade_abastecimentos'];
            $dados['limite_abastecimento_periodo'] = (int) $dados['limite_abastecimento_periodo'];
            $resultado = $this->veiculoService->cadastrarVeiculo($dados);

            if ($resultado) {

                return redirect()->route('veiculos.index')->with('success', 'Veículo cadastrado com sucesso!');
            }

            return back()->with('error', 'Erro ao cadastrar veiculo.');
        } catch (ValidationException $e) {
            return redirect()->back()
            ->with('error', $e->getMessage())
            ->withInput();
        } catch (\Exception $e) {
            Log::error('Erro ao cadastrar veiculo: ' . $e->getMessage());
            return back()->with('error', $e->getMessage());
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
                'ano' => 'required',
                'quantidade_litros' => 'required|string',
                'quantidade_abastecimentos' => 'required|string',
                'limite_abastecimento_periodo' => 'required|string',
                'secretarias_ids' => 'required|array',
            ]);

            $resultado = $this->veiculoService->atualizarVeiculo($id, $dados);

            if ($resultado) {

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

                return redirect()->route('veiculos.index')->with('success', 'Veiculo excluída com sucesso!');
            }

            return redirect()->route('veiculos.index')->with('error', 'Erro ao excluir veiculo.');
        } catch (\Exception $e) {
            Log::error("Erro ao excluir veiculo ID {$id}: " . $e->getMessage());
            return redirect()->route('veiculos.index')->with('error', 'Erro inesperado ao excluir veiculo.');
        }
    }
}
