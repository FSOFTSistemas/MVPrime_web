<?php

namespace App\Http\Controllers;

use App\Services\EnderecoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EnderecoController extends Controller
{
    protected $enderecoService;

    // Injeta o serviço de Endereço no construtor
    public function __construct(EnderecoService $enderecoService)
    {
        $this->enderecoService = $enderecoService;
    }

    // Método para armazenar um novo endereço
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'logradouro' => 'required|string|max:255',
            'numero' => 'required|string|max:50',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'cep' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $dadosEndereco = [
            'logradouro' => $request->input('logradouro'),
            'numero' => $request->input('numero'),
            'bairro' => $request->input('bairro'),
            'cidade' => $request->input('cidade'),
            'cep' => $request->input('cep'),
        ];

        $endereco = $this->enderecoService->createEndereco($dadosEndereco);

        if ($endereco) {
            return redirect()->route('empresa.create')->with('success', 'Endereço cadastrado com sucesso.');
        } else {
            return back()->with('error', 'Erro ao cadastrar o endereço. Tente novamente mais tarde.');
        }
    }

    // Método para listar todos os endereços
    public function listarEnderecos()
    {
        // Chama o serviço para listar os endereços
        $enderecos = $this->enderecoService->listarEnderecos();

        // Retorna para a view com os endereços
        return view('enderecos.index', compact('enderecos'));
    }
}