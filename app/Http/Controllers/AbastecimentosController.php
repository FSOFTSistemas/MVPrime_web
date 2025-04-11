<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
namespace App\Http\Controllers;
use App\Services\AbastecimentoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AbastecimentosController extends Controller
{
    protected $abastecimentoService;

    public function __construct(AbastecimentoService $abastecimentoService)
    {
        $this->abastecimentoService = $abastecimentoService;
    }

    public function index()
    {
        try {
            $abastecimentos = $this->abastecimentoService->listarAbastecimentos();
            return view('abastecimento.index', compact('abastecimentos'));
        } catch (\Exception $e) {
            Log::error('Erro ao listar abastecimentos: ' . $e->getMessage());
            return back()->with('error', 'Erro ao carregar as abastecimentos.');
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
