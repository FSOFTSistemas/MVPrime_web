<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Services\MotoristaService;
use App\Services\PrefeituraService;
use App\Services\EnderecoService;
use App\Services\SecretariaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use SweetAlert2\Laravel\Swal;

class MotoristasController extends Controller
{
    protected $motoristaService;
    protected $secretariaService;

    public function __construct(MotoristaService $motoristaService, SecretariaService $secretariaService)
    {
        $this->motoristaService = $motoristaService;
        $this->secretariaService = $secretariaService;
    }

    public function index()
    {
        try {

            $motoristas = $this->motoristaService->getMotoristas();
            $secretarias = $this->secretariaService->getSecretarias();

            $secretarias = $secretarias ?: [];
            return view('motorista.index', compact('motoristas', 'secretarias'));


        } catch (\Exception $e) {
            Log::error('Erro ao listar motoristas: ' . $e->getMessage());
            return back()->with('error', 'Erro ao carregar as motoristas.');
        }
    } 

    public function create()
    {
        try {
            $secretarias = $this->secretariaService->getSecretarias();
            return view('motorista._form', compact('secretarias'));
        } catch (\Exception $e) {
            Log::error('Erro ao carregar formulário de criação de motorista: ' . $e->getMessage());
            return back()->with('error', 'Erro ao carregar o formulário.');
        }
    }

public function store(Request $request)
{
    try {
        $dados = $request->validate([
            'nome' => 'required|string',
            'cnh' => 'required|string',
            'vencimento_cnh' => 'required|date', // Valida como data
            'secretaria_id' => 'required|string', // Ou 'string' dependendo do tipo do campo
        ]);
        // Formatar a data de vencimento para o formato 'Y-m-d' (YYYY-MM-DD)
        $dados['vencimento_cnh'] = Carbon::parse($dados['vencimento_cnh'])->format('Y-m-d');
        // Passar os dados formatados para o serviço
        $resultado = $this->motoristaService->cadastrarMotorista($dados);

        if ($resultado) {

            Swal::fire([
                'title' => 'Sucesso !',
                'text' => 'Motorista cadastrado com sucesso!',
                'icon' => 'success',
                'confirmButtonText' => 'OK'
            ]);

            return redirect()->route('motoristas.index')->with('success', 'Motorista cadastrada com sucesso!');
        }

        return back()->with('error', 'Erro ao cadastrar motorista.');
    } catch (\Exception $e) {
        Log::error('Erro ao cadastrar motorista: ' . $e->getMessage());
        return back()->with('error', 'Erro inesperado ao cadastrar motorista.');
    }
}

    public function update(Request $request, $id)
    {
        try {
            
            $dados = $request->validate([
                'nome' => 'required|string',
                'cnh'=> 'required|string',
                'vencimento_cnh' => 'required|date',
                'secretaria_id' => 'required|string',
            ]);

            $dados['vencimento_cnh'] = Carbon::parse($dados['vencimento_cnh'])->format('Y-m-d');
            $resultado = $this->motoristaService->atualizarMotorista($id, $dados);
            // dd($dados);

            if ($resultado) {

                Swal::fire([
                    'title' => 'Sucesso !',
                    'text' => 'Motorista atualizado com sucesso!',
                    'icon' => 'success',
                    'confirmButtonText' => 'OK'
                ]);

                return redirect()->route('motoristas.index')->with('success', 'Motorista atualizada com sucesso!');
            }

            return back()->with('error', 'Erro ao atualizar motorista.');
        } catch (\Exception $e) {
            Log::error("Erro ao atualizar motorista ID {$id}: " . $e->getMessage());
            return back()->with('error', 'Erro inesperado ao atualizar motorista.');
        }
    }

    public function destroy($id)
    {
        try {
            $resultado = $this->motoristaService->excluirMotorista($id);

            if ($resultado) {

                Swal::fire([
                    'title' => 'Sucesso !',
                    'text' => 'Motorista excluído com sucesso!',
                    'icon' => 'success',
                    'confirmButtonText' => 'OK'
                ]);

                return redirect()->route('motoristas.index')->with('success', 'Motorista excluída com sucesso!');
            }

            return redirect()->route('motoristas.index')->with('error', 'Erro ao excluir motorista.');
        } catch (\Exception $e) {
            Log::error("Erro ao excluir motorista ID {$id}: " . $e->getMessage());
            return redirect()->route('motoristas.index')->with('error', 'Erro inesperado ao excluir motorista.');
        }
    }
}
