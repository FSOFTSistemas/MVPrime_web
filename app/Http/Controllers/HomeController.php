<?php

namespace App\Http\Controllers;

use App\Services\HomeService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected $homeService;

    public function __construct(HomeService $home_service)
    {
        $this->homeService = $home_service;
        
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        Carbon::setLocale('pt_BR');

        
        switch ($user->tipo_usuario) {
            case 1:
                $dadosDias = $this->formatarDadosDia($this->homeService->listarAbastecimentosDia());
                $dadosMes = $this->formatarDadosMes($this->homeService->listarAbastecimentosMes());
                $dadosPrefeitura = $this->homeService->listarAbastecimentosPrefeitura();
                $dadosMaster = $this->homeService->listarMaster($user->empresa_id);
                $totalPrefeituras = $dadosMaster['total_prefeituras'];
                $totalUsuarios = $dadosMaster['total_usuarios'];
                $totalAbastecimento = $dadosMaster['total_abastecimento_hoje'];

                

                return view('home', [
                    'diaLabels' => $dadosDias['labels'],
                    'diaData' => $dadosDias['data'],
                    'mesLabels' => $dadosMes['labels'],
                    'mesData' => $dadosMes['data'],
                    'dadosPrefeitura' => $dadosPrefeitura,
                    'totalPrefeituras' => $totalPrefeituras,
                    'totalUsuarios' => $totalUsuarios,
                    'totalAbastecimento' => $totalAbastecimento
                    
                ]);

            case 2:
                $dadosDias = $this->formatarDadosDia($this->homeService->listarAbastecimentosPostoDia($user->posto_id));
                $dadosMes = $this->formatarDadosMes($this->homeService->listarAbastecimentosPostoMes($user->posto_id));
                $totalAbastecimentosDia = count($dadosDias['data']);
                $totalAbastecimentosMes = count($dadosMes['data']);

                return view('homePosto', [
                    'diaLabels' => $dadosDias['labels'],
                    'diaData' => $dadosDias['data'],
                    'mesLabels' => $dadosMes['labels'],
                    'mesData' => $dadosMes['data'],
                    'totalAbastecimentosDia' => $totalAbastecimentosDia,
                    'totalAbastecimentosMes' => $totalAbastecimentosMes,
                ]);

            case 3:
                $dadosDias = $this->formatarDadosDia($this->homeService->listarAbastecimentosPrefeituraDia($user->prefeitura_id));
                $dadosMes = $this->formatarDadosMes($this->homeService->listarAbastecimentosPrefeituraMes($user->prefeitura_id));

                return view('homePrefeitura', [
                    'diaLabels' => $dadosDias['labels'],
                    'diaData' => $dadosDias['data'],
                    'mesLabels' => $dadosMes['labels'],
                    'mesData' => $dadosMes['data'],
                ]);
        }
    }

    private function formatarDadosDia($dados)
    {
        $colecao = collect($dados);
        return [
            'labels' => $colecao->pluck('dia')->map(fn($dia) => Carbon::parse($dia)->translatedFormat('d'))->toArray(),
            'data' => $colecao->pluck('total_valor')->toArray(),
        ];
    }

    private function formatarDadosMes($dados)
    {
        $colecao = collect($dados);
        return [
            'labels' => $colecao->pluck('mes')->map(fn($mes) => Carbon::parse($mes)->translatedFormat('M-Y'))->toArray(),
            'data' => $colecao->pluck('total_valor')->toArray(),
        ];
    }
}

//1 master
//2 posto
//3 prefeitura