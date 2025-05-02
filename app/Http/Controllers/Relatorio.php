<?php

namespace App\Http\Controllers;

use App\Models\Abastecimento;
use App\Services\RelatorioService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class Relatorio extends Controller
{
    protected RelatorioService $relatorioService;

    public function __construct(RelatorioService $relatorioService)
    {
        $this->relatorioService = $relatorioService;
    }
    public function abastecimentoPorData()
    {
        return view('rel.abastecimento');
    }

    public function gerarAbastecimentosPDF(Request $request)
    {
        try {
            $filtros = $request->only([
                'data_inicio', 'data_fim', 'placa', 'motorista', 'tipo_combustivel'
            ]);

            $abastecimentos = $this->relatorioService->buscarAbastecimentos($filtros);

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
