<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EmpresaService;
use App\Services\EnderecoService;
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

            dd(Auth::user()->tipo_usuario);
            if (Auth::user()->tipo_usuario == 0)
            {
                return view('empresa.index', compact('empresas', 'enderecos'));
            }else{
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

            $this->empresaService->cadastrarEmpresa($request->all());
            return redirect()->route('empresas.index')->with('success', 'Empresa cadastrada com sucesso!');
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'cnpj' => 'required|string|max:18',
                'razao_social' => 'required|string|max:255',
                'endereco_id' => 'required|integer',
            ]);

            $this->empresaService->atualizarEmpresa($id, $request->all());
            return redirect()->route('empresas.index')->with('success', 'Empresa atualizada com sucesso!');
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->empresaService->excluirEmpresa($id);
            return redirect()->route('empresas.index')->with('success', 'Empresa excluída com sucesso!');
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}