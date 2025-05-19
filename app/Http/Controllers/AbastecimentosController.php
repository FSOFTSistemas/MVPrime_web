<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
namespace App\Http\Controllers;
use App\Services\AbastecimentoService;
use App\Services\MotoristaService;
use App\Services\VeiculosService;
use App\Services\PostoService;
use App\Services\SecretariaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class AbastecimentosController extends Controller
{
    protected $abastecimentoService;
    protected $veiculosService;

    protected $motoristasService;

    protected $postoService;

    public function __construct(AbastecimentoService $abastecimentoService, VeiculosService $veiculosService, MotoristaService $motoristasService, PostoService $postoService, SecretariaService $secretariaService)
    {
        $this->abastecimentoService = $abastecimentoService;
        $this->veiculosService = $veiculosService;
        $this->motoristasService = $motoristasService;
        $this->postoService = $postoService;
        $this->secretariaService = $secretariaService;
    }

    public function index(Request $request)
    {
        try {

            $page = $request->input('page', 1); // página atual, default = 1
            $limit = $request->get('limit', 10);
            $response = $this->abastecimentoService->getAbastecimentos($page, $limit);
    
            if (!$response || !isset($response['data'])) {
                return back()->with('error', 'Erro ao carregar os abastecimentos.');
            }
    
            $abastecimentos = $response['data'];
            $total = $response['totalPages'] ?? count($abastecimentos); // caso API não mande total, pega o count
            $perPage = $response['perPage'] ?? 20; // define um padrão
            $lastPage = $response['totalPages'] ?? ceil($total / $perPage);
            $currentPage = $response['currentPage'] ?? $page;
    
            $veiculos = $this->veiculosService->listarVeiculosPorPrefeitura(session('prefeitura_id'));
            $motoristas = $this->motoristasService->listarMotoristasPorPrefeitura(session('prefeitura_id'));
            $postos = $this->postoService->listarPostosPorPrefeitura(session('prefeitura_id'));
            $secretarias = $this->secretariaService->secretariasPorPrefeitura_id(session('prefeitura_id'));
    
            return view('abastecimento.index', compact(
                'abastecimentos',
                'veiculos',
                'motoristas',
                'secretarias',
                'postos',
                'total',
                'perPage',
                'lastPage',
                'currentPage',
                'limit'
            ));
        } catch (\Exception $e) {
            Log::error('Erro ao listar abastecimentos: ' . $e->getMessage());
            return back()->with('error', 'Erro ao carregar as abastecimentos.');
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $dados = $request->validate([
                'data_abastecimento' => 'required|date',
                'veiculo_id' => 'required|string',
                'motorista_id' => 'required|string',
                'posto_id' => 'required|string',
                'secretaria_id' => 'required|string',
                'tipo_combustivel' => 'required|string',
                'km_atual' => 'required|string',
                'media_km_litro' => 'required|string',
                'preco_combustivel' => 'required|string',
                'valor' => 'required|string',
            ]);

            $dados['empresa_id'] = 1;
            $dados['valor'] = (double) $dados['valor'];
            $dados['preco_combustivel'] = (double) $dados['preco_combustivel'];
            $dados['veiculo_id'] = (int) $dados['veiculo_id'];
            $dados['motorista_id'] = (int) $dados['motorista_id'];
            $dados['secretaria_id'] = (int) $dados['secretaria_id'];
            $dados['posto_id'] = (int) $dados['posto_id'];
            $dados['km_atual'] = (int) $dados['km_atual'];
            $dados['media_km_litro'] = (double) $dados['media_km_litro'];

            $resultado = $this->abastecimentoService->atualizarAbastecimento($id, $dados);

            if ($resultado) {
                return redirect()->route('abastecimentos.index')->with('success', 'Abastecimento atualizada com sucesso!');
            }

            return back()->with('error', 'Erro ao atualizar abastecimento.');
        } catch (\Exception $e) {
            Log::error("Erro ao atualizar abastecimento ID {$id}: " . $e->getMessage());
            return back()->with('error', 'Erro inesperado ao atualizar abastecimento.');
        }
    }

    public function destroy($id)
    {
        try {
            $resultado = $this->abastecimentoService->excluirAbastecimento($id);

            if ($resultado) {
                return redirect()->route('abastecimentos.index')->with('success', 'Abastecimento excluída com sucesso!');
            }

            return redirect()->route('abastecimentos.index')->with('error', 'Erro ao excluir abastecimento.');
        } catch (\Exception $e) {
            Log::error("Erro ao excluir abastecimento ID {$id}: " . $e->getMessage());
            return redirect()->route('abastecimentos.index')->with('error', 'Erro inesperado ao excluir abastecimento.');
        }
    }

}
