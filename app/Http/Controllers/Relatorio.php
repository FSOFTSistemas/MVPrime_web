<?php

namespace App\Http\Controllers;

use App\Models\Abastecimento;
use App\Services\RelatorioService;
use App\Services\MotoristaService;
use App\Services\VeiculosService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class Relatorio extends Controller
{
    protected RelatorioService $relatorioService;

    public function __construct(RelatorioService $relatorioService, MotoristaService $motoristaService, VeiculosService $veiculosService)
    {
        $this->relatorioService = $relatorioService;
        $this->motoristaService = $motoristaService;
        $this->veiculosService = $veiculosService;
    }
    public function abastecimentoPorData()
    {
        $motoristas = $this->motoristaService->getMotoristas() ?? [];
        $veiculos = $this->veiculosService->getVeiculos() ?? [];

        return view('rel.abastecimento', compact('motoristas', 'veiculos'));
    }

    public function gerarAbastecimentosPDF(Request $request)
    {
        try {
            $filtros = $request->only([
                'data_inicio', 'data_fim', 'veiculo_id', 'motorista', 'tipo_combustivel'
            ]);

            $abastecimentos = $this->relatorioService->buscarAbastecimentos($filtros);

            // prepara o filtro para o pdf
            if ($request->filled('veiculo_id')) {
                $placa = $this->veiculosService->buscarVeiculoPorId($request['veiculo_id'])['placa'];
                $filtros['placa'] = $placa;
                unset($filtros['veiculo_id']); // pra não aparecer no pdf o nome veiculo_id
            }

            if ($request->filled('motorista')) {
                $nomeMotorista = $this->motoristaService->buscarMotoristaPorId($request['motorista'])['nome'];
                $filtros['motorista'] = $nomeMotorista;
            }

            

            $pdf = Pdf::loadView('rel.pdf.rel_abast', [
                'abastecimentos' => $abastecimentos,
                'filtros' => $filtros,
            ]);
            return $pdf->stream('rel.pdf.rel_abast');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao gerar relatório: ' . $e->getMessage());
        }
    }
}
