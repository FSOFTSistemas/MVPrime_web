<?php

namespace App\Http\Controllers;

use App\Services\HomeService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
        $prefeitura_id = session('prefeitura_id');
        // $posto_id = session('posto_id');
        Carbon::setLocale('pt_BR');


        switch ($user->tipo_usuario) {
            case 0:

                return view('homeMaster');

            case 1:
                $dadosDias = $this->formatarDadosDia($this->homeService->listarAbastecimentosDia());
                $dadosMes = $this->formatarDadosMes($this->homeService->listarAbastecimentosMes());
                $dadosPrefeitura = $this->homeService->listarAbastecimentosPrefeitura($user->empresa_id);
                $dadosMaster = $this->homeService->listarMaster($user->empresa_id);
                $totalPrefeituras = $dadosMaster['total_prefeituras'];
                $totalUsuarios = $dadosMaster['total_usuarios'];
                $totalAbastecimento = number_format($dadosMaster['total_abastecimento_hoje'], 2, ',', '.');



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
                $dadosPosto = $this->homeService->listarPosto($user->posto_id);
                $totalAbastecimentosHoje = number_format($dadosPosto['total_abastecimento_hoje'], 2, ',', '.');
                $totalAbastecimentosMes = $dadosPosto['valor_total_mes'];
                $AbastecimentosMesAtual = number_format($dadosPosto['abastecimentos_mes_atual'], 2, ',', '.');
                $valorPorCombustivel = $dadosPosto['combustivel'];

                return view('homePosto', [
                    'totalAbastecimentosHoje' => $totalAbastecimentosHoje,
                    'abastecimentosMesAtual' => $AbastecimentosMesAtual,
                    'totalAbastecimentosMes' => $totalAbastecimentosMes,
                    'combustivel' => $valorPorCombustivel
                ]);

            case 3:
                $totalVeiculos = $this->homeService->veiculosPorPrefeitura($prefeitura_id);
                $totalVeiculos = is_null($totalVeiculos) ? 0 : count($totalVeiculos);

                $totalMotoristas = $this->homeService->motoristaPorPrefeitura($prefeitura_id);
                $totalMotoristas = is_null($totalMotoristas) ? 0 : count($totalMotoristas);

                $abastecimentoPorPrefeitura = $this->homeService->abastecimentoPorPrefeitura($prefeitura_id, 1, 10, 1);
                // dd($abastecimentoPorPrefeitura);
                $mesAtual = Carbon::now()->format('Y-m');
                $totalValorMesAtual = collect($abastecimentoPorPrefeitura)
                    ->filter(function ($item) use ($mesAtual) {
                        return Carbon::parse($item['data_abastecimento'])->format('Y-m') === $mesAtual;
                    })
                    ->sum('valor');
                $abastecimentoPorSecretaria = $this->homeService->abastecimentoPorSecretaria($prefeitura_id);
                // dd($abastecimentoPorSecretaria);

                return view('homePrefeitura', [
                    'totalVeiculos' => $totalVeiculos,
                    'totalMotoristas' => $totalMotoristas,
                    'totalMes' => $totalValorMesAtual,
                    'abastecimentoPorSecretaria' => $abastecimentoPorSecretaria
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
