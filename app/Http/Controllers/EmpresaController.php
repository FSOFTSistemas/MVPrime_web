<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EmpresaService;
use App\Services\EnderecoService;
use Dotenv\Exception\ValidationException;
use Exception;
use Illuminate\Support\Facades\Auth;

class EmpresaController extends Controller
{
    protected $empresaService;
    protected $enderecoService;

    public function __construct(EmpresaService $empresaService, EnderecoService $enderecoService)
    {
        $this->empresaService = $empresaService;
        $this->enderecoService = $enderecoService;
    }

    public function index()
    {
        try {

            $empresas = $this->empresaService->getEmpresa();
            $enderecos = $this->enderecoService->listarEnderecos();


            $user = Auth::user()->refresh();
            if ($user->tipo_usuario == 0) {
                return view('empresa.index', compact('empresas', 'enderecos'));
            } else {
                return view('empresa._form', compact('empresas', 'enderecos'));
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function create()
    {
        $enderecos = $this->enderecoService->listarEnderecos();
        return view('empresa._form', compact('enderecos'));
    }

    public function store(Request $request)
    {

        try {
            $this->validate($request, [
                'cnpj' => 'required|string|max:18',
                'razao_social' => 'required|string|max:255',
                'endereco_id' => 'required|integer',
            ]);

            $empresa = $this->empresaService->cadastrarEmpresa($request->all());
            if ($empresa) {
                return redirect()->route('empresas.index')->with('success', 'Empresa cadastrada com sucesso!');
            }
            return redirect()->back()->withInput()->withErrors('error', 'Error');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors('error', 'Error');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'cnpj' => 'required|string|max:18',
                'razao_social' => 'required|string|max:255',
            ], [
                'cnpj.required' => 'O campo CNPJ é obrigatório.',
                'cnpj.string' => 'O CNPJ deve ser um texto.',
                'cnpj.max' => 'O CNPJ não pode ter mais que 18 caracteres.',

                'razao_social.required' => 'O campo Razão Social é obrigatório.',
                'razao_social.string' => 'A Razão Social deve ser um texto.',
                'razao_social.max' => 'A Razão Social não pode ter mais que 255 caracteres.',

            ]);


            $empresa = $this->empresaService->atualizarEmpresa($id, $request->all());
            if ($empresa) {
                return redirect()->route('empresas.index')->with('success', 'Empresa atualizada com sucesso!');
            }
            return redirect()->back()->withInput()->with('error', 'Error');
        } catch (ValidationException $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $empresa = $this->empresaService->excluirEmpresa($id);
            if ($empresa) {

                return redirect()->route('empresas.index')->with('success', 'Empresa excluída com sucesso!');
            }
            return redirect()->back()->withInput()->withErrors('error', '500');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors('error', '500');
        }
    }
}
